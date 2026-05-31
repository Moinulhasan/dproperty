<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.company.index', compact('companies'));
    }

    public function add()
    {
        return view('admin.company.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('logo');
            if ($request->hasFile('logo')) {
                $imageName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('uploads/company'), $imageName);
                $data['logo'] = 'uploads/company/' . $imageName;
            }
            Company::create($data);
            return redirect()->route('admin.company.list')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }

    public function editPost(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('logo');
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($company->logo && file_exists(public_path($company->logo))) {
                    unlink(public_path($company->logo));
                }
                $imageName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('uploads/company'), $imageName);
                $data['logo'] = 'uploads/company/' . $imageName;
            }
            $company->update($data);
            return redirect()->route('admin.company.list')->with('success', 'Company updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Company $company)
    {
        if ($company->logo && file_exists(public_path($company->logo))) {
            unlink(public_path($company->logo));
        }
        $company->delete();
        return redirect()->route('admin.company.list')->with('success', 'Company deleted successfully.');
    }
}
