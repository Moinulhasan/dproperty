<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use App\Models\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyRegistrationController extends Controller
{
    public function show()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        return view('pages.company_register', compact('settings'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Account info
            'company_name'        => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'designation'         => 'nullable|string|max:255',
            'email'               => 'required|email|max:255',
            'mobile_number'       => 'required|string|max:30',
            'whatsapp_number'     => 'nullable|string|max:30',

            // Company info
            'company_type'         => 'nullable|string|max:100',
            'trade_license_number' => 'nullable|string|max:100',
            'trade_license_expiry' => 'nullable|date',
            'tin_number'           => 'nullable|string|max:100',
            'vat_number'           => 'nullable|string|max:100',
            'company_website'      => 'nullable|url|max:255',
            'years_in_business'    => 'nullable|string|max:50',

            // Address
            'office_address' => 'nullable|string|max:500',
            'country'        => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'district'       => 'nullable|string|max:100',
            'postal_code'    => 'nullable|string|max:20',

            // Listing intent
            'property_category'    => 'nullable|string|max:100',
            'number_of_properties' => 'nullable|string|max:50',
            'service_required'     => 'nullable|in:Sale,Rent,Lease',

            // Document uploads — capped at 5MB each per the form copy.
            'trade_license_copy'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'company_logo'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'national_id_passport'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tin_certificate'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'incorporation_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'utility_bill'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Declaration — three required checkboxes.
            'declare_accurate'    => 'accepted',
            'declare_authorize'   => 'accepted',
            'declare_terms'       => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->only([
                'company_name', 'contact_person_name', 'designation', 'email',
                'mobile_number', 'whatsapp_number',
                'company_type', 'trade_license_number', 'trade_license_expiry',
                'tin_number', 'vat_number', 'company_website', 'years_in_business',
                'office_address', 'country', 'city', 'district', 'postal_code',
                'property_category', 'number_of_properties', 'service_required',
            ]);

            // Persist uploaded documents into public/uploads/company_requests
            // so the admin panel can link to them directly.
            $fileFields = [
                'trade_license_copy', 'company_logo', 'national_id_passport',
                'tin_certificate', 'incorporation_certificate', 'utility_bill',
            ];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $name = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/company_requests'), $name);
                    $data[$field] = 'uploads/company_requests/' . $name;
                }
            }

            $data['status'] = 'pending';

            CompanyRequest::create($data);

            return redirect()->route('company.register')
                ->with('success', 'Your registration has been submitted. Our team will review it and contact you within 24–48 hours.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Submission failed: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
