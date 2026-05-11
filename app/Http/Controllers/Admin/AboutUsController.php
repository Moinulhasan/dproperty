<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    public function index()
    {
        $abouts = AboutUs::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.about_us.index', compact('abouts'));
    }

    public function add()
    {
        return view('admin.about_us.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $name = time() . '_about.' . $request->image->extension();
                $request->image->move(public_path('uploads/about'), $name);
                $imagePath = 'uploads/about/' . $name;
            }

            AboutUs::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'status' => $request->status == 'active' ? 1 : 0,
            ]);

            return redirect()->route('admin.about_us.list')->with('success', 'About Us section added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while adding. Please try again.')->withInput();
        }
    }

    public function edit(AboutUs $aboutUs)
    {
        return view('admin.about_us.edit', compact('aboutUs'));
    }

    public function editPost(Request $request, AboutUs $aboutUs)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        try {
            if ($request->hasFile('image')) {
                if ($aboutUs->image && file_exists(public_path($aboutUs->image))) {
                    unlink(public_path($aboutUs->image));
                }
                $name = time() . '_about.' . $request->image->extension();
                $request->image->move(public_path('uploads/about'), $name);
                $aboutUs->image = 'uploads/about/' . $name;
            }

            $aboutUs->title = $request->title;
            $aboutUs->description = $request->description;
            $aboutUs->status = $request->status == 'active' ? 1 : 0;
            $aboutUs->save();

            return redirect()->route('admin.about_us.list')->with('success', 'About Us section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while updating. Please try again.')->withInput();
        }
    }

    public function delete(AboutUs $aboutUs)
    {
        if ($aboutUs->image && file_exists(public_path($aboutUs->image))) {
            unlink(public_path($aboutUs->image));
        }
        $aboutUs->delete();
        return redirect()->route('admin.about_us.list')->with('success', 'About Us section deleted successfully.');
    }
}
