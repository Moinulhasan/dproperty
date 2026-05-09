<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyRequest;
use Illuminate\Http\Request;

class PropertyRequestController extends Controller
{
    public function index()
    {
        $requests = PropertyRequest::orderBy('created_at', 'desc')->get();
        return view('admin.property_request.index', compact('requests'));
    }

    public function show(PropertyRequest $propertyRequest)
    {
        return view('admin.property_request.show', compact('propertyRequest'));
    }

    public function updateStatus(Request $request, PropertyRequest $propertyRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,approved,rejected',
        ]);

        $propertyRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Property request status updated successfully.');
    }

    public function delete(PropertyRequest $propertyRequest)
    {
        $propertyRequest->delete();
        return redirect()->route('admin.property-request.list')->with('success', 'Property request deleted successfully.');
    }
}
