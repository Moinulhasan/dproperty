<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);
        return view('admin.location.index', compact('locations'));
    }

    public function add()
    {
        return view('admin.location.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $name = time() . '_location.' . $request->image->extension();
                $request->image->move(public_path('uploads/locations'), $name);
                $imagePath = 'uploads/locations/' . $name;
            }

            Location::create([
                'name' => $request->name,
                'image' => $imagePath,
                'status' => $request->status == 'active' ? 1 : 0,
                'order' => (int) $request->input('order', 0),
            ]);

            return redirect()->route('admin.location.list')->with('success', 'Location added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while adding the location. Please try again.')->withInput();
        }
    }

    public function edit(Location $location)
    {
        return view('admin.location.edit', compact('location'));
    }

    public function editPost(Request $request, Location $location)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            if ($request->hasFile('image')) {
                // Delete old image
                if ($location->image && file_exists(public_path($location->image))) {
                    unlink(public_path($location->image));
                }
                $name = time() . '_location.' . $request->image->extension();
                $request->image->move(public_path('uploads/locations'), $name);
                $location->image = 'uploads/locations/' . $name;
            }

            $location->name = $request->name;
            $location->status = $request->status == 'active' ? 1 : 0;
            $location->order = (int) $request->input('order', $location->order ?? 0);
            $location->save();

            return redirect()->route('admin.location.list')->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while updating the location. Please try again.')->withInput();
        }
    }

    public function delete(Location $location)
    {
        if ($location->image && file_exists(public_path($location->image))) {
            unlink(public_path($location->image));
        }
        $location->delete();
        return redirect()->route('admin.location.list')->with('success', 'Location deleted successfully.');
    }
}
