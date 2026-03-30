<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyDetail;
use App\Services\ImageProcessingService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected ImageProcessingService $imageService;

    public function __construct(ImageProcessingService $imageService)
    {
        $this->imageService = $imageService;
    }

    //
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Property::with('user.company')->orderBy('created_at', 'desc');

        // Apply Filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        }
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('route', 'like', '%' . $request->location . '%')
                    ->orWhere('sub_route', 'like', '%' . $request->location . '%');
            });
        }

        if ($user->hasRole('Super Admin')) {
            // Full access
        } elseif ($user->hasRole('Property Admin')) {
            $companyUserIds = $user->company ? $user->company->users->pluck('id') : [$user->id];
            $query->whereIn('created_by', $companyUserIds);
        } else {
            // Agent or other roles
            $query->where('created_by', $user->id);
        }

        $properties = $query->paginate(3)->withQueryString();
        return view('admin.property.index', compact('properties'));
    }

    public function add()
    {
        $amenities = \App\Models\Amenity::all();
        $locations = Location::where('status', 1)->orderBy('name')->get();
        $propertyDetails = PropertyDetail::where('status', 1)->orderBy('sort_order')->get();
        return view('admin.property.add', compact('amenities', 'locations', 'propertyDetails'));
    }

    public function addPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'property_type' => 'required|string',
            'property_status' => 'required|string|in:Buy,Rent,Sell',
            'route' => 'nullable|string',
            'sub_route' => 'nullable|string',
            'road' => 'nullable|string',
            'lane' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'is_furnished' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'floor_plan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_link' => 'nullable|url',
            'map_link' => 'nullable|url',
            'amenities' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['images', 'feature_image', 'floor_plan', 'amenities', 'is_featured', 'is_home_featured', 'is_location_featured', 'details']);
            $data['slug'] = \Str::slug($request->title) . '-' . time();
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $data['is_home_featured'] = $request->has('is_home_featured') ? 1 : 0;
            $data['is_location_featured'] = $request->has('is_location_featured') ? 1 : 0;
            $data['created_by'] = auth()->id();

            // Handle Gallery Images
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . uniqid() . '.webp'; // Set to webp for better compression
                    $targetPath = public_path('uploads/property/') . $name;
                    $this->imageService->process($image->getRealPath(), $targetPath);
                    $images[] = 'uploads/property/' . $name;
                }
                $data['images'] = $images;
            }

            // Handle Feature Image
            if ($request->hasFile('feature_image')) {
                $name = time() . '_feature.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->feature_image->getRealPath(), $targetPath);
                $data['feature_image'] = 'uploads/property/' . $name;
            }

            // Handle Floor Plan
            if ($request->hasFile('floor_plan')) {
                $name = time() . '_floor.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->floor_plan->getRealPath(), $targetPath);
                $data['floor_plan'] = 'uploads/property/' . $name;
            }

            $property = Property::create($data);

            if ($request->has('amenities')) {
                $property->amenities()->attach($request->amenities);
            }

            // Save dynamic detail values
            if ($request->has('details')) {
                foreach ($request->details as $detailId => $value) {
                    if ($value !== null && $value !== '') {
                        $property->detailValues()->create([
                            'property_detail_id' => $detailId,
                            'value' => $value,
                        ]);
                    }
                }
            }

            return redirect()->route('admin.property.list')->with('success', 'Property added successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()])->withInput();
        }
    }

    public function edit(Property $property)
    {
        // Authorization check
        $user = auth()->user();
        if ($user->hasRole('Super Admin')) {
        } elseif ($user->hasRole('Property Admin')) {
            if ($property->user->company_id !== $user->company_id) {
                abort(403, 'Unauthorized access to this property.');
            }
        } elseif ($property->created_by !== $user->id) {
            abort(403, 'Unauthorized access to this property.');
        }


        $amenities = Amenity::all();
        $locations = Location::where('status', 1)->orderBy('name')->get();
        $propertyDetails = PropertyDetail::where('status', 1)->orderBy('sort_order')->get();
        return view('admin.property.edit', compact('property', 'amenities', 'locations', 'propertyDetails'));
    }

    public function editPost(Request $request, Property $property)
    {
        // Authorization check (same as edit)
        $user = auth()->user();
        if (!$user->hasRole('Super Admin')) {
            if ($user->hasRole('Property Admin')) {
                if ($property->user->company_id !== $user->company_id) {
                    abort(403);
                }
            }
            elseif ($property->created_by !== $user->id) {
                abort(403);
            }
        }

        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'property_type' => 'required|string',
            'property_status' => 'required|string',
            'route' => 'nullable|string',
            'sub_route' => 'nullable|string',
            'road' => 'nullable|string',
            'lane' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'is_furnished' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'floor_plan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_link' => 'nullable|url',
            'map_link' => 'nullable|url',
            'amenities' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except(['images', 'feature_image', 'floor_plan', 'amenities', 'is_featured', 'is_home_featured', 'is_location_featured', 'details']);
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $data['is_home_featured'] = $request->has('is_home_featured') ? 1 : 0;
            $data['is_location_featured'] = $request->has('is_location_featured') ? 1 : 0;

            // Handle Gallery Images
            if ($request->hasFile('images')) {
                $images = $property->images ?? [];
                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . uniqid() . '.webp';
                    $targetPath = public_path('uploads/property/') . $name;
                    $this->imageService->process($image->getRealPath(), $targetPath);
                    $images[] = 'uploads/property/' . $name;
                }
                $data['images'] = $images;
            }

            // Handle Feature Image
            if ($request->hasFile('feature_image')) {
                if ($property->feature_image && file_exists(public_path($property->feature_image))) {
                    unlink(public_path($property->feature_image));
                }
                $name = time() . '_feature.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->feature_image->getRealPath(), $targetPath);
                $data['feature_image'] = 'uploads/property/' . $name;
            }

            // Handle Floor Plan
            if ($request->hasFile('floor_plan')) {
                if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
                    unlink(public_path($property->floor_plan));
                }
                $name = time() . '_floor.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->floor_plan->getRealPath(), $targetPath);
                $data['floor_plan'] = 'uploads/property/' . $name;
            }

            $property->update($data);

            if ($request->has('amenities')) {
                $property->amenities()->sync($request->amenities);
            } else {
                $property->amenities()->sync([]);
            }

            // Sync dynamic detail values
            if ($request->has('details')) {
                foreach ($request->details as $detailId => $value) {
                    $property->detailValues()->updateOrCreate(
                        ['property_detail_id' => $detailId],
                        ['value' => $value]
                    );
                }
            }

            return redirect()->route('admin.property.list')->with('success', 'Property updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()])->withInput();
        }
    }

    public function delete(Property $property)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin')) {
            if ($user->hasRole('Property Admin')) {
                if ($property->user->company_id !== $user->company_id) {
                    abort(403);
                }
            } elseif ($property->created_by !== $user->id) {
                abort(403);
            }
        }

        // Delete files
        if ($property->images) {
            foreach ($property->images as $image) {
                if (file_exists(public_path($image))) unlink(public_path($image));
            }
        }
        if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
            unlink(public_path($property->floor_plan));
        }

        $property->delete();
        return redirect()->route('admin.property.list')->with('success', 'Property deleted successfully.');
    }

    public function deleteImage(Request $request, Property $property)
    {
        // Authorization check
        $user = auth()->user();
        if (!$user->hasRole('Super Admin')) {
            if ($user->hasRole('Property Admin')) {
                if ($property->user->company_id !== $user->company_id) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
                }
            } elseif ($property->created_by !== $user->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        $imagePath = $request->image_path;
        $images = $property->images ?? [];

        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);

            // Delete physical file
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            $property->update(['images' => array_values($images)]);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }
}
