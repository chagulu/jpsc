@extends('layouts.candidate.app')

@section('title', 'Preview Application')

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <ul class="progressbar">
        <li><a href="">Profile</a></li>
        <li><a href="">Sign & Photo</a></li>
        <li><a href="">Other Details</a></li>
        <li><a href="">Education</a></li>
        <li class="active"><a href="">Preview</a></li>
        <li><a href="">Completed</a></li>
    </ul>
</div>

<!-- Page Content -->
<div class="container p-4 flex-grow-1">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Preview Your Application</h5>
        </div>
        <div class="card-body">

            <!-- Personal Information -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-user me-2 text-primary"></i> Personal Information</h6>
                <div class="row">
                    <div class="col-md-6"><p><strong>Full Name:</strong> {{ $application->full_name }}</p></div>
                    <div class="col-md-6"><p><strong>Mobile:</strong> {{ $application->mobile_no }}</p></div>
                    <div class="col-md-6"><p><strong>Date of Birth:</strong> {{ $application->date_of_birth?->format('d-m-Y') }}</p></div>
                    <div class="col-md-6"><p><strong>Gender:</strong> {{ ucfirst($application->gender) }}</p></div>
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
                <a href="#" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('candidate.completed') }}" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Submit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
