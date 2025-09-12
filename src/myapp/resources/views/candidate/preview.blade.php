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
                    <div class="col-md-6"><p><strong>Full Name:</strong> John Doe</p></div>
                    <div class="col-md-6"><p><strong>Mobile:</strong> 9876543210</p></div>
                    <div class="col-md-6"><p><strong>Date of Birth:</strong> 01-01-1995</p></div>
                    <div class="col-md-6"><p><strong>Gender:</strong> Male</p></div>
                </div>
            </div>

            <!-- Education & Experience -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-graduation-cap me-2 text-primary"></i> Education & Experience</h6>
                <div class="row">
                    <div class="col-md-6"><p><strong>Qualification:</strong> M.Sc. Physics</p></div>
                    <div class="col-md-6"><p><strong>Experience:</strong> 3 Years</p></div>
                </div>
            </div>

            <!-- Uploaded Files -->
            <div class="preview-section mb-4">
                <h6><i class="fas fa-file-upload me-2 text-primary"></i> Uploaded Files</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Photo:</strong></p>
                        <img src="{{ asset('candidate/photos/profile.png') }}" class="rounded shadow-sm border" width="120" alt="Photo">
                    </div>
                    <div class="col-md-6">
                        <p><strong>Signature:</strong></p>
                        <img src="{{ asset('candidate/photos/signature.png') }}" class="border" width="150" alt="Signature">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-right mt-4">
                <a href="education.html" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('candidate.completed') }}" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Submit
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .progressbar {
        counter-reset: step;
        display: flex;
        justify-content: space-between;
        margin: 30px 0;
        padding: 0;
        list-style-type: none;
    }
    .progressbar li {
        position: relative;
        flex: 1;
        text-align: center;
        font-size: 14px;
    }
    .progressbar li a {
        display: block;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
    }
    .progressbar li.active a {
        color: #1abc9c;
        font-weight: 600;
    }
    .progressbar li::before {
        counter-increment: step;
        content: counter(step);
        width: 35px;
        height: 35px;
        line-height: 35px;
        border: 2px solid #6c757d;
        display: block;
        text-align: center;
        margin: 0 auto 10px auto;
        border-radius: 50%;
        background-color: #fff;
        color: #6c757d;
        transition: 0.3s;
    }
    .progressbar li.active::before {
        border-color: #1abc9c;
        background-color: #1abc9c;
        color: #fff;
    }
    .progressbar li::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #6c757d;
        top: 18px;
        left: -50%;
        z-index: -1;
    }
    .progressbar li:first-child::after {
        content: none;
    }
    .progressbar li.active::after {
        background-color: #1abc9c;
    }
    .preview-section h6 {
        font-weight: 600;
        margin-top: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }
</style>
@endsection
