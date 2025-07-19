<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    //
    public function sliderList()
    {
        $sliders = HomeSlider::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.slider.index',compact('sliders'));
    }

    public function sliderAdd()
    {
        return view('admin.slider.add');
    }

    public function sliderAddPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        try {
            // Handle file upload and save slider data
            $file = $request->file('image')->store('slider','public');
            HomeSlider::create([
                'title' => $request->title,
                'image' => $file,
                'created_by' => auth()->id(),
                'status' => $request->status == 'active' ? 1 : 0,
            ]);
            return redirect()->route('admin.slider.list')->with('success', 'Slider added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while adding the slider. Please try again.')
                ->withInput();
        }
    }

    public function sliderEdit(HomeSlider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function sliderEditPost(Request $request, HomeSlider $slider)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        try {
            // Handle file upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($slider->image) {
                    Storage::disk('public')->delete($slider->image);
                }
                $file = $request->file('image')->store('slider', 'public');
                $slider->image = $file;
            }
            $slider->title = $request->title;
            $slider->status = $request->status == 'active' ? 1 : 0;
            $slider->save();
            return redirect()->route('admin.slider.list')->with('success', 'Slider updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while updating the slider. Please try again.')
                ->withInput();
        }
    }

    public function sliderDelete(HomeSlider $slider)
    {
        // delete if image exists
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('admin.slider.list')->with('success', 'Slider deleted successfully.');
    }
}
