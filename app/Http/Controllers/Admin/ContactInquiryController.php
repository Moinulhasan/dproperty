<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    public function index()
    {
        $inquiries = ContactInquiry::orderBy('created_at', 'desc')->get();
        return view('admin.contact_inquiry.index', compact('inquiries'));
    }

    public function show(ContactInquiry $contactInquiry)
    {
        if ($contactInquiry->status == 'pending') {
            $contactInquiry->update(['status' => 'read']);
        }
        return view('admin.contact_inquiry.show', compact('contactInquiry'));
    }

    public function updateStatus(Request $request, ContactInquiry $contactInquiry)
    {
        $request->validate([
            'status' => 'required|in:pending,read,archived',
        ]);

        $contactInquiry->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    public function delete(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();
        return redirect()->route('admin.contact-inquiry.list')->with('success', 'Inquiry deleted successfully.');
    }
}
