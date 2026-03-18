<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyDetailController extends Controller
{
    public function index()
    {
        $details = PropertyDetail::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.property_detail.index', compact('details'));
    }

    public function add()
    {
        return view('admin.property_detail.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'input_type' => 'required|in:text,number,select',
            'options' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $options = null;
            if ($request->input_type == 'select' && $request->filled('options')) {
                $options = array_map('trim', explode(',', $request->options));
            }

            PropertyDetail::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'input_type' => $request->input_type,
                'options' => $options,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status == 'active' ? 1 : 0,
            ]);

            return redirect()->route('admin.property-detail.list')->with('success', 'Property detail field added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(PropertyDetail $propertyDetail)
    {
        return view('admin.property_detail.edit', compact('propertyDetail'));
    }

    public function editPost(Request $request, PropertyDetail $propertyDetail)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'input_type' => 'required|in:text,number,select',
            'options' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $options = null;
            if ($request->input_type == 'select' && $request->filled('options')) {
                $options = array_map('trim', explode(',', $request->options));
            }

            $propertyDetail->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'input_type' => $request->input_type,
                'options' => $options,
                'sort_order' => $request->sort_order ?? 0,
                'status' => $request->status == 'active' ? 1 : 0,
            ]);

            return redirect()->route('admin.property-detail.list')->with('success', 'Property detail field updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function delete(PropertyDetail $propertyDetail)
    {
        $propertyDetail->values()->delete();
        $propertyDetail->delete();
        return redirect()->route('admin.property-detail.list')->with('success', 'Property detail field deleted successfully.');
    }
}
