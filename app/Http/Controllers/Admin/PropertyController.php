<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Company;
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
        return $this->renderList($request, false);
    }

    /**
     * Same listing UI, scoped to home-featured properties only. Drives the
     * "Featured Properties" sidebar menu — visitors see this subset on the
     * homepage's Featured Properties section (is_home_featured = 1).
     */
    public function featuredIndex(Request $request)
    {
        return $this->renderList($request, true);
    }

    protected function renderList(Request $request, bool $featuredOnly)
    {
        $user = auth()->user();
        $query = Property::with(['user.company', 'location'])->orderBy('created_at', 'desc');

        if ($featuredOnly) {
            $query->where('is_home_featured', 1)
            ->orWhere('is_location_featured', 1)
            ->orWhere('is_featured', 1);
        }

        // Apply Filters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->filled('property_category_id')) {
            $catId = (int) $request->property_category_id;
            $category = \App\Models\PropertyCategory::find($catId);
            if ($category && $category->parent_id === null) {
                $childIds = $category->children->pluck('id')->toArray();
                $query->whereIn('property_category_id', array_merge([$catId], $childIds));
            } else {
                $query->where('property_category_id', $catId);
            }
        }
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        }
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
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

        $properties = $query->paginate(20)->withQueryString();
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->orderBy('name')->get();
        $locations  = Location::where('status', 1)->orderBy('order')->orderBy('name')->get();

        return view('admin.property.index', compact('properties', 'categories', 'locations', 'featuredOnly'));
    }

    public function add()
    {
        $amenities = \App\Models\Amenity::orderBy('order')->orderBy('name')->get();
        $locations = Location::where('status', 1)->orderBy('order')->orderBy('name')->get();
        $propertyDetails = PropertyDetail::where('status', 1)->orderBy('sort_order')->get();
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->get();
        $companies = auth()->user()->hasRole('Super Admin')
            ? Company::where('status', 'active')->orderBy('name')->get()
            : collect();
        return view('admin.property.add', compact('amenities', 'locations', 'propertyDetails', 'categories', 'companies'));
    }

    public function addPost(Request $request)
    {
        // Validation matches the DB schema's NOT NULL contract: every field
        // the user is expected to fill in for a valid property is required.
        // Legacy columns (area, bedrooms, bathrooms, link) were migrated to
        // nullable separately since they're now handled via the dynamic
        // property_detail_values system.
        $validator = \Validator::make($request->all(), [
            'title'                 => 'required|string|max:255',
            'price'                 => 'required|numeric|min:0',
            'property_category_id'  => 'required|exists:property_categories,id',
            'property_status'       => 'required|string|in:Rent,Sell',
            'company_id'            => 'nullable|exists:companies,id',
            'location_id'           => 'required|exists:locations,id',
            'project_id'            => 'required|string|max:100',
            'is_furnished'          => 'required|string',
            'description'           => 'required|string',
            'route'                 => 'nullable|string',
            'sub_route'             => 'nullable|string',
            'road'                  => 'nullable|string',
            'lane'                  => 'nullable|string',
            'bedrooms'              => 'nullable|integer|min:0',
            'bathrooms'             => 'nullable|integer|min:0',
            'area'                  => 'nullable|numeric|min:0',
            'images.*'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'feature_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'floor_plan'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'video_link'            => 'nullable|url',
            'map_link'              => 'nullable|string',
            'amenities'             => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Whitelist only the actual properties columns. Avoids ever
            // sending stray request fields (like _token) to the DB and makes
            // the location fields explicit so they always save.
            $data = $request->only([
                'title', 'price', 'property_category_id', 'property_status',
                'description', 'project_id', 'video_link', 'map_link',
                'bedrooms', 'bathrooms', 'area', 'is_furnished',
                'location_id', 'route', 'sub_route', 'road', 'lane',
            ]);

            // Normalise: empty string -> null so DB stores NULL not "".
            foreach (['location_id', 'route', 'sub_route', 'road', 'lane', 'video_link', 'map_link'] as $f) {
                if (array_key_exists($f, $data) && $data[$f] === '') {
                    $data[$f] = null;
                }
            }

            $data['slug'] = \Str::slug($request->title) . '-' . time();
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $data['is_home_featured'] = $request->has('is_home_featured') ? 1 : 0;
            $data['is_location_featured'] = $request->has('is_location_featured') ? 1 : 0;
            $data['apply_watermark'] = $request->has('apply_watermark') ? 1 : 0;
            $data['created_by'] = auth()->id();

            // Super Admin picks the company from the dropdown; everyone else
            // inherits it from their own user record.
            $user = auth()->user();
            $data['company_id'] = $user->hasRole('Super Admin')
                ? ($request->filled('company_id') ? $request->company_id : null)
                : $user->company_id;

            // Set old category and property_type strings for backward compatibility
            $categoryModel = \App\Models\PropertyCategory::with('parent')->find($request->property_category_id);
            if ($categoryModel) {
                $data['property_type'] = $categoryModel->name;
                $data['category'] = $categoryModel->parent ? $categoryModel->parent->name : $categoryModel->name;
            }

            // Resolve the watermark logo path once. Tries the property's
            // selected company logo first; if not available, falls back to
            // the App Settings site logo. If neither yields a file on disk,
            // the service receives null and silently skips the stamp.
            // The checkbox only governs the FEATURE IMAGE and GALLERY IMAGES;
            // floor plans are never watermarked.
            $logoPath = null;
            if ($data['apply_watermark']) {
                $logoPath = $this->resolveWatermarkLogoPath($data['company_id'] ?? null);
            }

            // Handle Gallery Images — watermarked when the checkbox is on.
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . uniqid() . '.webp'; // Set to webp for better compression
                    $targetPath = public_path('uploads/property/') . $name;
                    $this->imageService->process($image->getRealPath(), $targetPath, 75, $logoPath);
                    $images[] = 'uploads/property/' . $name;
                }
                $data['images'] = $images;
            }

            // Handle Feature Image — watermarked when the checkbox is on.
            if ($request->hasFile('feature_image')) {
                $name = time() . '_feature.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->feature_image->getRealPath(), $targetPath, 75, $logoPath);
                $data['feature_image'] = 'uploads/property/' . $name;
            }

            // Handle Floor Plan — explicit null so floor plans are NEVER
            // watermarked, regardless of the Apply Watermark checkbox state.
            if ($request->hasFile('floor_plan')) {
                $name = time() . '_floor.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->floor_plan->getRealPath(), $targetPath, 75, null);
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
            // Log the real error for the dev/ops team; keep the user-facing
            // message generic so we don't leak SQL/stack details.
            \Log::error('Property add failed: ' . $exception->getMessage(), [
                'user_id' => auth()->id(),
                'trace'   => $exception->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
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


        $amenities = Amenity::orderBy('order')->orderBy('name')->get();
        $locations = Location::where('status', 1)->orderBy('order')->orderBy('name')->get();
        $propertyDetails = PropertyDetail::where('status', 1)->orderBy('sort_order')->get();
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->get();
        $companies = $user->hasRole('Super Admin')
            ? Company::where('status', 'active')->orderBy('name')->get()
            : collect();
        return view('admin.property.edit', compact('property', 'amenities', 'locations', 'propertyDetails', 'categories', 'companies'));
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

        // Same required-field contract as addPost.
        $validator = \Validator::make($request->all(), [
            'title'                 => 'required|string|max:255',
            'price'                 => 'required|numeric|min:0',
            'property_category_id'  => 'required|exists:property_categories,id',
            'property_status'       => 'required|string|in:Rent,Sell',
            'company_id'            => 'nullable|exists:companies,id',
            'location_id'           => 'required|exists:locations,id',
            'project_id'            => 'required|string|max:100',
            'is_furnished'          => 'required|string',
            'description'           => 'required|string',
            'route'                 => 'nullable|string',
            'sub_route'             => 'nullable|string',
            'road'                  => 'nullable|string',
            'lane'                  => 'nullable|string',
            'bedrooms'              => 'nullable|integer|min:0',
            'bathrooms'             => 'nullable|integer|min:0',
            'area'                  => 'nullable|numeric|min:0',
            'images.*'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'feature_image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'floor_plan'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'video_link'            => 'nullable|url',
            'map_link'              => 'nullable|string',
            'amenities'             => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Whitelist update payload so we never write stray request fields
            // (like _token) and so every location column is explicitly set.
            $data = $request->only([
                'title', 'price', 'property_category_id', 'property_status',
                'description', 'project_id', 'video_link', 'map_link',
                'bedrooms', 'bathrooms', 'area', 'is_furnished',
                'location_id', 'route', 'sub_route', 'road', 'lane',
            ]);

            foreach (['location_id', 'route', 'sub_route', 'road', 'lane', 'video_link', 'map_link'] as $f) {
                if (array_key_exists($f, $data) && $data[$f] === '') {
                    $data[$f] = null;
                }
            }

            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $data['is_home_featured'] = $request->has('is_home_featured') ? 1 : 0;
            $data['is_location_featured'] = $request->has('is_location_featured') ? 1 : 0;
            $data['apply_watermark'] = $request->has('apply_watermark') ? 1 : 0;

            // Only Super Admin can re-assign the company on edit. Other roles
            // cannot change company ownership of a property — strip it so the
            // existing value is preserved.
            if ($user->hasRole('Super Admin')) {
                $data['company_id'] = $request->filled('company_id') ? $request->company_id : null;
            } else {
                unset($data['company_id']);
            }

            // Update old category and property_type strings
            $categoryModel = \App\Models\PropertyCategory::with('parent')->find($request->property_category_id);
            if ($categoryModel) {
                $data['property_type'] = $categoryModel->name;
                $data['category'] = $categoryModel->parent ? $categoryModel->parent->name : $categoryModel->name;
            }

            // Resolve watermark logo path — same rule as addPost. Use the
            // about-to-be-saved company_id (which may differ from the current
            // $property->company_id when Super Admin re-assigned it).
            $effectiveCompanyId = $data['company_id'] ?? $property->company_id;
            $logoPath = null;
            if ($data['apply_watermark']) {
                $logoPath = $this->resolveWatermarkLogoPath($effectiveCompanyId);
            }

            // Handle Gallery Images — watermarked when the checkbox is on.
            if ($request->hasFile('images')) {
                $images = $property->images ?? [];
                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . uniqid() . '.webp';
                    $targetPath = public_path('uploads/property/') . $name;
                    $this->imageService->process($image->getRealPath(), $targetPath, 75, $logoPath);
                    $images[] = 'uploads/property/' . $name;
                }
                $data['images'] = $images;
            }

            // Handle Feature Image — watermarked when the checkbox is on.
            if ($request->hasFile('feature_image')) {
                if ($property->feature_image && file_exists(public_path($property->feature_image))) {
                    unlink(public_path($property->feature_image));
                }
                $name = time() . '_feature.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->feature_image->getRealPath(), $targetPath, 75, $logoPath);
                $data['feature_image'] = 'uploads/property/' . $name;
            }

            // Handle Floor Plan — explicit null so floor plans are NEVER
            // watermarked, regardless of the Apply Watermark checkbox state.
            if ($request->hasFile('floor_plan')) {
                if ($property->floor_plan && file_exists(public_path($property->floor_plan))) {
                    unlink(public_path($property->floor_plan));
                }
                $name = time() . '_floor.webp';
                $targetPath = public_path('uploads/property/') . $name;
                $this->imageService->process($request->floor_plan->getRealPath(), $targetPath, 75, null);
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
            \Log::error('Property update failed: ' . $exception->getMessage(), [
                'property_id' => $property->id,
                'user_id'     => auth()->id(),
                'trace'       => $exception->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
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

    /**
     * Persist a new order for the gallery's `images` array. The frontend
     * sends the full ordered list of image paths after a drag — we validate
     * each path is one the property currently owns, then overwrite the JSON
     * column with the new sequence. The card galleries on the public site
     * iterate this array directly, so the new order is reflected immediately.
     */
    public function reorderImages(Request $request, Property $property)
    {
        $this->authorizeMutation($property);

        $newOrder = $request->input('order', []);
        if (!is_array($newOrder)) {
            return response()->json(['success' => false, 'message' => 'Invalid payload.'], 422);
        }

        $current = $property->images ?? [];
        // Only keep paths that already belong to this property — guards against
        // a tampered client trying to inject foreign paths.
        $sanitized = array_values(array_filter($newOrder, fn ($p) => in_array($p, $current, true)));

        // Append any images the client omitted to avoid silently dropping
        // a gallery entry if the JS missed one.
        foreach ($current as $p) {
            if (!in_array($p, $sanitized, true)) {
                $sanitized[] = $p;
            }
        }

        $property->update(['images' => $sanitized]);

        return response()->json(['success' => true, 'message' => 'Gallery order saved.']);
    }

    /**
     * Flip the property's status flag (1 active / 0 inactive). Frontend
     * queries already filter by status = 1 so inactive properties drop off
     * the public site immediately without needing to delete them.
     */
    public function toggleStatus(Property $property)
    {
        $this->authorizeMutation($property);

        $property->update(['status' => $property->status ? 0 : 1]);

        $label = $property->status ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Property {$label} successfully.");
    }

    /**
     * Resolve the absolute filesystem path of the logo to stamp on uploaded
     * images. Preference order:
     *   1. The given company's logo file (stored under public/uploads/company/).
     *   2. The App Settings site logo (stored under public/storage/logos/ via
     *      Laravel's storage:link symlink).
     * Returns null when nothing usable is on disk, in which case the image
     * service skips the watermark silently.
     *
     * URL-only values (e.g., seeded Unsplash placeholders) are skipped because
     * we can't draw an HTTP URL onto a GD canvas — only local files work.
     */
    protected function resolveWatermarkLogoPath(?int $companyId): ?string
    {
        // 1) Company logo
        if ($companyId) {
            $company = Company::find($companyId);
            if ($company && $company->logo && !$this->isUrl($company->logo)) {
                $candidate = public_path($company->logo);
                if (file_exists($candidate)) {
                    return $candidate;
                }
            }
        }

        // 2) App Settings site logo. getRawOriginal('logo') is the raw column
        //    value before the model's getLogoAttribute() accessor wraps it in
        //    asset() — that's what maps cleanly to a filesystem path.
        $settings = \App\Models\AppSettings::where('site_name', 'dproperty')->first();
        $rawSiteLogo = $settings?->getRawOriginal('logo');
        if ($rawSiteLogo && !$this->isUrl($rawSiteLogo)) {
            // App Settings stores via Storage::put on the public disk, so
            // the on-disk location is public/storage/{rawSiteLogo}.
            $candidate = public_path('storage/' . ltrim($rawSiteLogo, '/'));
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function isUrl(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }

    protected function authorizeMutation(Property $property): void
    {
        $user = auth()->user();
        if ($user->hasRole('Super Admin')) {
            return;
        }
        if ($user->hasRole('Property Admin')) {
            if ($property->user && $property->user->company_id === $user->company_id) {
                return;
            }
            abort(403, 'Unauthorized.');
        }
        if ($property->created_by !== $user->id) {
            abort(403, 'Unauthorized.');
        }
    }
}
