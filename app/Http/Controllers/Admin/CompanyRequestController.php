<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CompanyRequest::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('company_name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('mobile_number', 'like', "%{$q}%");
            });
        }

        $requests = $query->paginate(20)->withQueryString();
        return view('admin.company_request.index', compact('requests'));
    }

    public function show(CompanyRequest $companyRequest)
    {
        return view('admin.company_request.show', compact('companyRequest'));
    }

    public function approve(Request $request, CompanyRequest $companyRequest)
    {
        // Approval = create the actual Company row from the request data.
        // Admin can override key fields (especially status / final email)
        // before approval.
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|max:255',
            'phone'    => 'nullable|string|max:30',
            'address'  => 'nullable|string',
            'notes'    => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($companyRequest->status === 'approved' && $companyRequest->company_id) {
            return redirect()->back()->with('success', 'This request has already been approved.');
        }

        // Reuse the uploaded company_logo from the request if available, so
        // the admin doesn't have to re-upload it.
        $company = Company::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'logo'    => $companyRequest->company_logo,
            'status'  => 'active',
        ]);

        $companyRequest->update([
            'status'      => 'approved',
            'admin_notes' => $request->notes,
            'company_id'  => $company->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.company-request.list')
            ->with('success', 'Request approved and Company created. You may now set up login credentials via the User section.');
    }

    public function reject(Request $request, CompanyRequest $companyRequest)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $companyRequest->update([
            'status'      => 'rejected',
            'admin_notes' => $request->notes,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.company-request.list')
            ->with('success', 'Request marked as rejected.');
    }

    public function destroy(CompanyRequest $companyRequest)
    {
        $companyRequest->delete();
        return redirect()->route('admin.company-request.list')
            ->with('success', 'Request deleted.');
    }
}
