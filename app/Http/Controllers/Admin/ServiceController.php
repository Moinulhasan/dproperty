<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $services = Services::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.service.list',compact('services'));
    }

    public function add()
    {
        return view('admin.service.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        try {
            // save file
            $file = $request->file('image')->store('services', 'public');
            Services::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $file,
                'status' => $request->status == 'active' ? 1 : 0,
                'user_id' => auth()->id(),
            ]);
            return redirect()->route('admin.service.list')->with('success', 'Service added successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors('An error occurred while adding the service. Please try again.')
                ->withInput();
        }
    }

    public function edit(Services $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    public function editPost(Request $request, Services $service)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        try {
            $service->title = $request->title;
            $service->description = $request->description;
            $service->status = $request->status == 'active' ? 1 : 0;

            if ($request->hasFile('image')) {
                // delete old image
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                // save new image
                $file = $request->file('image')->store('services', 'public');
                $service->image = $file;
            }

            $service->save();
            return redirect()->route('admin.service.list')->with('success', 'Service updated successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors('An error occurred while updating the service. Please try again.')
                ->withInput();
        }
    }

    public function delete(Services $service)
    {
        $service->delete();
        return redirect()->route('admin.service.list')->with('success', 'Service deleted successfully.');
    }
}
