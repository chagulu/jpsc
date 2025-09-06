@extends('layouts.admin') {{-- Your admin layout --}}

@section('title', 'Applications List')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Applications</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="applicationsTable">
                    <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Applicant Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Submitted At</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            {{-- Filters --}}
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Search ID"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Search Name"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Search Mobile"></th>
                            <th><input type="text" class="form-control form-control-sm filter-input" placeholder="Search Email"></th>
                            <th><input type="date" class="form-control form-control-sm filter-input"></th>
                            <th>
                                <select class="form-select form-select-sm filter-select">
                                    <option value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $app)
                        <tr>
                            <td>{{ $app->application_no }}</td>
                            <td>{{ $app->full_name }}</td>
                            <td>{{ $app->mobile_no }}</td>
                            <td>{{ $app->email ?? '—' }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>{{ $app->status }}</td>
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
    // Optional: JS for filtering (if you want instant client-side filtering)
    document.querySelectorAll('.filter-input').forEach(input => {
        input.addEventListener('keyup', function() {
            let table = document.getElementById('applicationsTable');
            let filter = this.value.toLowerCase();
            let colIndex = Array.from(input.parentNode.parentNode.children).indexOf(input.parentNode);
            Array.from(table.tBodies[0].rows).forEach(row => {
                row.style.display = row.cells[colIndex].innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    });
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', function() {
            let table = document.getElementById('applicationsTable');
            let filter = this.value.toLowerCase();
            let colIndex = Array.from(select.parentNode.parentNode.children).indexOf(select.parentNode);
            Array.from(table.tBodies[0].rows).forEach(row => {
                row.style.display = (!filter || row.cells[colIndex].innerText.toLowerCase() === filter) ? '' : 'none';
            });
        });
    });
</script>
@endsection
