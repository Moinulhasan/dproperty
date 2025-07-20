<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //
    public function index()
    {
        $properties = Property::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.property.index', compact('properties'));
    }

    public function add()
    {
        return view('admin.property.add');
    }

    public function addPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'type' => 'required|string|in:fb,yu',
            'description' => 'required|string|max:1000',
            'link' => 'required|url|active_url',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Property::create([
                'type' => $request->type,
                'description' => $request->description,
                'link' => $request->link,
                'status' => $request->status == 'active' ? 1 : 0
            ]);
            return redirect()->route('admin.property.list')->with('success', 'Property added successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()])
                ->withInput();
        }
    }

    public function edit(Property $property)
    {
        return view('admin.property.edit', compact('property'));
    }

    public function editPost(Request $request, Property $property)
    {
        $validator = \Validator::make($request->all(), [
            'type' => 'required|string|in:fb,yu',
            'description' => 'required|string|max:1000',
            'link' => 'required|url|active_url',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $property->update([
                'type' => $request->type,
                'description' => $request->description,
                'link' => $request->link,
                'status' => $request->status == 'active' ? 1 : 0
            ]);
            return redirect()->route('admin.property.list')->with('success', 'Property updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()])
                ->withInput();
        }
    }

    public function delete(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.property.list')->with('success', 'Property deleted successfully.');
    }
}
