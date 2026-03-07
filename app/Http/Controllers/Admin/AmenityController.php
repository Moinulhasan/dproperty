<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::latest()->get();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function add()
    {
        return view('admin.amenity.create');
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        Amenity::create($request->all());

        return redirect()->route('admin.amenity.list')->with('success', 'Amenity created successfully.');
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenity.edit', compact('amenity'));
    }

    public function editPost(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $amenity->update($request->all());

        return redirect()->route('admin.amenity.list')->with('success', 'Amenity updated successfully.');
    }

    public function delete(Amenity $amenity)
    {
        $amenity->delete();
        return redirect()->route('admin.amenity.list')->with('success', 'Amenity deleted successfully.');
    }
}
