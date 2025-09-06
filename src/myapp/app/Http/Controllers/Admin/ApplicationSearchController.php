<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JetApplicationModel as Application;

class ApplicationSearchController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = Application::query();

        // Apply filters if present
        if ($request->filled('application_no')) {
            $query->where('application_no', 'like', '%'.$request->application_no.'%');
        }

        if ($request->filled('full_name')) {
            $query->where('full_name', 'like', '%'.$request->full_name.'%');
        }

        if ($request->filled('mobile_no')) {
            $query->where('mobile_no', 'like', '%'.$request->mobile_no.'%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Paginate results
        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        // Keep query params for pagination links
        $applications->appends($request->all());

        return view('admin.applications.applicant_list', compact('applications'));
    }
}
