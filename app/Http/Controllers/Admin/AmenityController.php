<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        // Lower `order` first; ties broken by name so identical orders stay
        // alphabetical instead of jittering between requests.
        $amenities = Amenity::orderBy('order')->orderBy('name')->get();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function add()
    {
        return view('admin.amenity.create');
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        Amenity::create($request->only(['name', 'icon', 'order']));

        return redirect()->route('admin.amenity.list')->with('success', 'Amenity created successfully.');
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenity.edit', compact('amenity'));
    }

    public function editPost(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'icon'  => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $amenity->update($request->only(['name', 'icon', 'order']));

        return redirect()->route('admin.amenity.list')->with('success', 'Amenity updated successfully.');
    }

    public function delete(Amenity $amenity)
    {
        $amenity->delete();
        return redirect()->route('admin.amenity.list')->with('success', 'Amenity deleted successfully.');
    }
}
