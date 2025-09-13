@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            Application #{{ $application->application_no }}
        </h4>
    </div>
    <div class="card-body p-4">

        {{-- Personal Information --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-card-list"></i> Personal Information</h5>
        <div class="row mb-4">
            <div class="col-md-4"><strong>Father's Name:</strong> {{ $application->father_name ?? '—' }}</div>
            <div class="col-md-4"><strong>Mother's Name:</strong> {{ $application->mother_name ?? '—' }}</div>
            <div class="col-md-4"><strong>Gender:</strong> {{ $application->gender }}</div>
            <div class="col-md-4"><strong>DOB:</strong> {{ $application->date_of_birth?->format('d-m-Y') }}</div>
            <div class="col-md-4"><strong>Age:</strong> {{ $application->age ?? '—' }}</div>
            <div class="col-md-4"><strong>Category:</strong> {{ $application->category }}</div>
            <div class="col-md-4"><strong>Caste:</strong> {{ $application->caste ?? '—' }}</div>
            <div class="col-md-4"><strong>Non Creamy Layer:</strong> {{ $application->non_creamy_layer }}</div>
            <div class="col-md-4"><strong>Domicile of Bihar:</strong> {{ $application->domicile_bihar ? 'Yes' : 'No' }}</div>
        </div>

        <hr>

        {{-- PWD / Defence / NCC --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-hospital"></i> Special Status</h5>
        <div class="row mb-4">
            <div class="col-md-4"><strong>PWD:</strong> {{ $application->is_pwd ? 'Yes' : 'No' }}</div>
            @if($application->is_pwd)
                <div class="col-md-4"><strong>Disability Nature:</strong> {{ $application->disability_nature ?? '—' }}</div>
                <div class="col-md-4"><strong>40%+ Disability:</strong> {{ $application->pwd_40_percent ? 'Yes' : 'No' }}</div>
            @endif
            <div class="col-md-4"><strong>Ex-Serviceman:</strong> {{ $application->ex_serviceman }}</div>
            <div class="col-md-4"><strong>Defence Service:</strong> 
                {{ $application->defence_service_year ?? 0 }} Yr 
                {{ $application->defence_service_month ?? 0 }} Mo 
                {{ $application->defence_service_day ?? 0 }} D
            </div>
            <div class="col-md-4"><strong>Worked after NCC:</strong> {{ $application->worked_after_ncc ? 'Yes' : 'No' }}</div>
            <div class="col-md-4"><strong>Bihar Govt Employee:</strong> {{ $application->bihar_govt_employee }}</div>
            <div class="col-md-4"><strong>Govt Service Years:</strong> {{ $application->govt_service_years ?? '—' }}</div>
            <div class="col-md-4"><strong>Attempts After Employment:</strong> {{ $application->attempts_after_emp ?? '—' }}</div>
        </div>

        <hr>

        {{-- Progress Status --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-bar-chart"></i> Progress Status</h5>
        @if($application->progress_status && $application->progress_status->count())
            <table class="table table-bordered table-striped mb-4">
                <thead class="table-light">
                    <tr>
                        <th>Step</th>
                        <th>Status</th>
                        <th>Completion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($application->progress_status as $progress)
                        <tr>
                            <td>{{ $progress->step_name }}</td>
                            <td>
                                <span class="badge 
                                    @if($progress->status == 'Completed') bg-success
                                    @elseif($progress->status == 'In Progress') bg-warning
                                    @else bg-secondary @endif">
                                    {{ $progress->status }}
                                </span>
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar 
                                        @if($progress->percentage == 100) bg-success 
                                        @else bg-info @endif" 
                                        role="progressbar" 
                                        style="width: {{ $progress->percentage }}%;">
                                        {{ $progress->percentage }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No progress data available.</p>
        @endif

        <hr>

        {{-- Address --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-geo-alt"></i> Address Details</h5>
        @if($application->addresses && $application->addresses->count())
            <ul class="list-group mb-4">
                @foreach($application->addresses as $addr)
                    <li class="list-group-item">
                        <strong>{{ ucfirst($addr->type) }}:</strong> 
                        {{ $addr->line1 }}, {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No address details available.</p>
        @endif

        <hr>

        {{-- Education --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-mortarboard"></i> Education Details</h5>
        @if($application->education && $application->education->count())
            <table class="table table-bordered table-striped mb-4">
                <thead class="table-light">
                    <tr>
                        <th>Exam</th>
                        <th>Degree</th>
                        <th>Year</th>
                        <th>Institute</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($application->education as $edu)
                        <tr>
                            <td>{{ $edu->exam_name }}</td>
                            <td>{{ $edu->degree }}</td>
                            <td>{{ $edu->passing_year }}</td>
                            <td>{{ $edu->institute ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No education details available.</p>
        @endif

        <hr>

        {{-- Documents --}}
        <h5 class="text-secondary mb-3"><i class="bi bi-file-earmark-text"></i> Uploaded Documents</h5>
        @if($application->documents)
            <div class="d-flex gap-3">
                @if($application->documents->photo)
                    <a href="{{ asset('storage/'.$application->documents->photo) }}" target="_blank" class="btn btn-outline-primary btn-sm">Photo</a>
                @endif
                @if($application->documents->signature)
                    <a href="{{ asset('storage/'.$application->documents->signature) }}" target="_blank" class="btn btn-outline-primary btn-sm">Signature</a>
                @endif
                @if($application->upload_supported_document)
                    <a href="{{ asset('storage/'.$application->upload_supported_document) }}" target="_blank" class="btn btn-outline-primary btn-sm">Name Change Proof</a>
                @endif
            </div>
        @else
            <p class="text-muted">No documents uploaded.</p>
        @endif

        <div class="mt-4">
            <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
