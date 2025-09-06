<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\ApplicantModel;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $query = ApplicantModel::query();

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by applicant name
        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%' . $request->full_name . '%');
        }

        // Filter by mobile
        if ($request->filled('mobile_no')) {
            $query->where('mobile_no', 'like', '%' . $request->mobile_no . '%');
        }

        // Filter by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Pagination: 10 per page, latest first
        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Keep query params for pagination links
        $applications->appends($request->all());

        return view('admin.applicants.applicant_list', compact('applications'));
    }
}
