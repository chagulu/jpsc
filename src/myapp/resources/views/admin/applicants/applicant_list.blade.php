@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Applicants List</h2>

    <!-- Optional filter -->
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="payment_status" class="form-select">
                    <option value="">-- All Status --</option>
                    <option value="PAID" {{ request('payment_status') == 'PAID' ? 'selected' : '' }}>Paid</option>
                    <option value="PENDING" {{ request('payment_status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Payment Status</th>
                <th>Application Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applicants as $index => $applicant)
            <tr>
                <td>{{ $applicants->firstItem() + $index }}</td>
                <td>{{ $applicant->name }}</td>
                <td>{{ $applicant->email }}</td>
                <td>{{ $applicant->mobile_no }}</td>
                <td>
                    @if($applicant->payment_status == 'PAID')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $applicant->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        {{ $applicants->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
