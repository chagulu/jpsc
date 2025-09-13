@extends('layouts.candidate.app')

@section('title', 'Preview Application')

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <ul class="progressbar">
        <li class="active"><a href="{{ route('candidate.profile', $application->id) }}">Profile</a></li>
        <li class="active"><a href="{{ route('candidate.uploadDocuments', $application->id) }}">Sign & Photo</a></li>
        <li class="active"><a href="{{ route('candidate.otherDetails', $application->id) }}">Other Details</a></li>
        <li class="active"><a href="{{ route('candidate.education', $application->id) }}">Education</a></li>
        <li class="active"><a href="javascript:void(0)">Preview</a></li>
        <li><a href="{{ route('candidate.completed', $application->id) }}">Completed</a></li>
    </ul>
</div>

<!-- Page Content -->
<div class="container p-4 flex-grow-1">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Preview Your Application</h5>
        </div>
        <div class="card-body">

            <!-- Application Info -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-id-card me-2 text-primary"></i> Application Info</h6>
                <div class="row">
                    <div class="col-md-6"><p><strong>Application No:</strong> {{ $application->application_no ?? 'N/A' }}</p></div>
                    <div class="col-md-6"><p><strong>Submitted Date:</strong> {{ $application->submitted_at?->format('d-m-Y h:i A') ?? 'Not Submitted' }}</p></div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-user me-2 text-primary"></i> Personal Information</h6>
                <div class="row">
                    <div class="col-md-6"><p><strong>Full Name:</strong> {{ $application->full_name }}</p></div>
                    <div class="col-md-6"><p><strong>Father's Name:</strong> {{ $application->father_name }}</p></div>
                    <div class="col-md-6"><p><strong>Mother's Name:</strong> {{ $application->mother_name }}</p></div>
                    <div class="col-md-6"><p><strong>Mobile:</strong> {{ $application->mobile_no }}</p></div>
                    <div class="col-md-6"><p><strong>Email:</strong> {{ $application->email }}</p></div>
                    <div class="col-md-6"><p><strong>Date of Birth:</strong> {{ $application->date_of_birth?->format('d-m-Y') }}</p></div>
                    <div class="col-md-6"><p><strong>Gender:</strong> {{ ucfirst($application->gender) }}</p></div>
                    <div class="col-md-6"><p><strong>Category:</strong> {{ $application->category ?? 'N/A' }}</p></div>
                    <div class="col-md-6"><p><strong>Marital Status:</strong> {{ ucfirst($application->marital_status ?? 'N/A') }}</p></div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-map-marker-alt me-2 text-primary"></i> Address</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Permanent Address:</strong><br>
                            {{ $application->permanent_address ?? 'N/A' }}<br>
                            {{ $application->permanent_city ?? '' }},
                            {{ $application->permanent_state ?? '' }} - {{ $application->permanent_pincode ?? '' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Correspondence Address:</strong><br>
                            {{ $application->correspondence_address ?? 'N/A' }}<br>
                            {{ $application->correspondence_city ?? '' }},
                            {{ $application->correspondence_state ?? '' }} - {{ $application->correspondence_pincode ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Other Details -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-info-circle me-2 text-primary"></i> Other Details</h6>
                <div class="row">
                    <div class="col-md-6"><p><strong>Nationality:</strong> {{ $application->nationality ?? 'N/A' }}</p></div>
                    <div class="col-md-6"><p><strong>Disability:</strong> {{ $application->disability ?? 'No' }}</p></div>
                    <div class="col-md-6"><p><strong>Identification Mark:</strong> {{ $application->identification_mark ?? 'N/A' }}</p></div>
                    <div class="col-md-6"><p><strong>Aadhaar No:</strong> {{ $application->aadhaar_no ?? 'N/A' }}</p></div>
                </div>
            </div>

            <!-- Education -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-graduation-cap me-2 text-primary"></i> Education</h6>
                @forelse($application->education as $edu)
                    <div class="row border-bottom py-2">
                        <div class="col-md-4"><strong>{{ $edu->exam_name }}</strong></div>
                        <div class="col-md-4">Degree: {{ $edu->degree }}</div>
                        <div class="col-md-4">Subject: {{ $edu->subject }}</div>
                        <div class="col-md-4">School/College: {{ $edu->school_college }}</div>
                        <div class="col-md-4">Board/Univ: {{ $edu->board_university }}</div>
                        <div class="col-md-4">Passing: {{ $edu->passing_month }} {{ $edu->passing_year }}</div>
                        <div class="col-md-4">Status: {{ $edu->status }}</div>
                        <div class="col-md-4">Marks: {{ $edu->marks_obtained }}</div>
                        <div class="col-md-4">Division: {{ $edu->division }}</div>
                        <div class="col-md-4">Certificate No: {{ $edu->certificate_number }}</div>
                    </div>
                @empty
                    <p>No education details available.</p>
                @endforelse
            </div>

            <!-- Uploaded Files -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-file-upload me-2 text-primary"></i> Uploaded Files</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Photo:</strong></p>
                        <img src="{{ asset('storage/' . $application->documents?->photo) }}" 
                             class="rounded shadow-sm border" width="120" alt="Photo">
                    </div>
                    <div class="col-md-6">
                        <p><strong>Signature:</strong></p>
                        <img src="{{ asset('storage/' . $application->documents?->signature) }}" 
                             class="border" width="150" alt="Signature">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-right mt-4">
                <a href="{{ route('candidate.education',$application->id) }}" class="btn btn-success">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
                <a href="{{ route('candidate.completed',$application->id) }}" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Submit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
