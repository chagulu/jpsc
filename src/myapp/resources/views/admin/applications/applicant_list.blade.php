@extends('layouts.admin')

@section('title', 'Applications List')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Applications</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.applications.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Application ID</label>
                            <input type="text" name="application_no" value="{{ request('application_no') }}" class="form-control" placeholder="Search Application ID">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>OTR No</label>
                            <input type="text" name="otr_no" value="{{ request('otr_no') }}" class="form-control" placeholder="Search OTR No">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Applicant Name</label>
                            <input type="text" name="full_name" value="{{ request('full_name') }}" class="form-control" placeholder="Search Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Mobile</label>
                            <input type="text" name="mobile_no" value="{{ request('mobile_no') }}" class="form-control" placeholder="Search Mobile">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Email</label>
                            <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Search Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Submitted At</label>
                            <input type="date" name="created_at" value="{{ request('created_at') }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                                <option value="Paid" {{ request('status')=='Paid'?'selected':'' }}>Paid</option>
                                <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover" id="applicationsTable">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Applicant Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>{{ $app->candidate->otr_no ?? '—' }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->candidate->mobile_number ?? '—' }}</td>
                            <td>{{ $app->candidate->email ?? '—' }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>{{ $app->status }}</td>
                            <td>
                                <a href="{{ route('admin.applications.show', $app->id) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-submit form on Enter or change
    document.querySelectorAll('#filterForm input, #filterForm select').forEach(field => {
        field.addEventListener('change', () => document.getElementById('filterForm').submit());
        field.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') document.getElementById('filterForm').submit();
        });
    });
</script>
@endsection
