<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    //
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function add()
    {
        return view('admin.testimonial.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'review' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            's_link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // file upload logic

            $file = $request->file('image')->store('testimonials', 'public');
            // Save testimonial data to the database
            Testimonial::create([
                'name' => $request->name,
                'designation' => $request->designation,
                'review' => $request->review,
                'image' => $file,
                's_link' => $request->s_link,
                'status' => $request->status == 'active' ? 1 : 0,
            ]);
            return redirect()->route('admin.testimonial.list')->with('success', 'Testimonial added successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function editPost(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'review' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            's_link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            // delete previous image if exists
            if ($request->hasFile('image')) {
                if ($testimonial->image) {
                    \Storage::disk('public')->delete($testimonial->image);
                }
                $file = $request->file('image')->store('testimonials', 'public');
                $testimonial->image = $file;
            }
            $testimonial->name = $request->name;
            $testimonial->designation = $request->designation;
            $testimonial->review = $request->review;
            $testimonial->status = $request->status == 'active' ? 1 : 0;
            $testimonial->save();
            return redirect()->route('admin.testimonial.list')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function delete(Testimonial $testimonial)
    {
        // first remove the image
        if ($testimonial->image) {
            \Storage::disk('public')->delete($testimonial->image);
        }
        // then delete the testimonial
        $testimonial->delete();
        return redirect()->route('admin.testimonial.list')->with('success', 'Testimonial deleted successfully.');
    }
}
