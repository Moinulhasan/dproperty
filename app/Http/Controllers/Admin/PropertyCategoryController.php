<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PropertyCategoryController extends Controller
{
    public function index()
    {
        $categories = PropertyCategory::with('parent')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.property_category.index', compact('categories'));
    }

    public function add()
    {
        $categories = PropertyCategory::whereNull('parent_id')->get();
        return view('admin.property_category.add', compact('categories'));
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:property_categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $slug = Str::slug($request->name);
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (PropertyCategory::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }

            PropertyCategory::create([
                'name' => $request->name,
                'slug' => $slug,
                'parent_id' => $request->parent_id,
                'status' => $request->status == 'active' ? 1 : 0,
            ]);

            return redirect()->route('admin.property_category.list')->with('success', 'Property Category added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while adding the property category. Please try again.')->withInput();
        }
    }

    public function edit(PropertyCategory $propertyCategory)
    {
        $categories = PropertyCategory::whereNull('parent_id')->where('id', '!=', $propertyCategory->id)->get();
        return view('admin.property_category.edit', compact('propertyCategory', 'categories'));
    }

    public function editPost(Request $request, PropertyCategory $propertyCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:property_categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $propertyCategory->name = $request->name;
            $propertyCategory->parent_id = $request->parent_id;
            $propertyCategory->status = $request->status == 'active' ? 1 : 0;
            
            if ($propertyCategory->isDirty('name')) {
                $slug = Str::slug($request->name);
                $originalSlug = $slug;
                $count = 1;
                while (PropertyCategory::where('slug', $slug)->where('id', '!=', $propertyCategory->id)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }
                $propertyCategory->slug = $slug;
            }

            $propertyCategory->save();

            return redirect()->route('admin.property_category.list')->with('success', 'Property Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while updating the property category. Please try again.')->withInput();
        }
    }

    public function delete(PropertyCategory $propertyCategory)
    {
        $propertyCategory->delete();
        return redirect()->route('admin.property_category.list')->with('success', 'Property Category deleted successfully.');
    }
}
