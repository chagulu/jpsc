<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $query = Applicant::query();

        // Optional filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Pagination: 10 per page
        $applicants = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.applicants.applicant_list', compact('applicants'));
    }
}
