<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JetApplicationModel as Application;

class ApplicationSearchController extends Controller
{
    public function index(Request $request)
    {
        // Start query with candidate relationship
        $query = Application::with('candidate')->select('applications.*');

        // Join candidates table
        $query->join('candidates', 'applications.candidate_id', '=', 'candidates.id');

        // Apply filters
        if ($request->filled('application_no')) {
            $query->where('applications.application_no', 'like', '%'.$request->application_no.'%');
        }

        if ($request->filled('full_name')) {
            $query->where('applications.full_name', 'like', '%'.$request->full_name.'%');
        }

        if ($request->filled('mobile_no')) {
            $query->where('candidates.mobile_no', 'like', '%'.$request->mobile_no.'%');
        }

        if ($request->filled('email')) {
            $query->where('candidates.email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('otr_no')) {
            $query->where('candidates.otr_no', 'like', '%'.$request->otr_no.'%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('applications.created_at', $request->created_at);
        }

        if ($request->filled('status')) {
            $query->where('applications.status', $request->status);
        }

        // Paginate results
        $applications = $query->orderBy('applications.created_at', 'desc')->paginate(15);

        // Keep query params for pagination links
        $applications->appends($request->all());

        return view('admin.applications.applicant_list', compact('applications'));
    }
}
