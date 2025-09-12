@extends('layouts.candidate.app')

@section('title', 'Candidate Dashboard')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">

        <div class="container-fluid mt-4">
            <div class="row g-4">
                
                <!-- OTR Status -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center">
                            <h6 class="m-0">OTR Status</h6>
                        </div>
                        <div class="card-body p-3">

                            <!-- Status List -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Email Verified 
                                    <span class="badge bg-success rounded-pill">✔</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Mobile Verified 
                                    <span class="badge bg-success rounded-pill">✔</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Profile Details Updated 
                                    <span class="badge bg-success rounded-pill">✔</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Photo Uploaded 
                                    <span class="badge bg-danger rounded-pill">✖</span>
                                    <a href="/otr/sign-photo/open-sign-photo-page?mode=edit" class="small text-primary ms-2">Click Here To Add</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Signature Uploaded 
                                    <span class="badge bg-danger rounded-pill">✖</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Other Details Updated 
                                    <span class="badge bg-danger rounded-pill">✖</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Education & Experience Details 
                                    <span class="badge bg-danger rounded-pill">✖</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Finally Submitted 
                                    <span class="badge bg-danger rounded-pill">✖</span>
                                </li>
                            </ul>

                            <!-- Progress Bar -->
                            <div class="mt-3">
                                <p class="mb-1"><b>Completion:</b></p>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" 
                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidate Details -->
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-secondary text-white text-center">
                            <h6 class="m-0">Candidate Details</h6>
                        </div>
                        <div class="card-body p-4">

                            <div class="row text-center mb-3">
                                <div class="col">
                                    <img src="{{ asset('candidate/photos/profile.png') }}" 
                                         class="rounded border" 
                                         width="120" height="120"
                                         onerror="this.onerror=null; this.src='{{ asset('candidate/photos/profile.png') }}';"
                                         alt="Profile Photo">
                                    <p class="mt-2 small text-muted">Photo</p>
                                </div>
                                <div class="col">
                                    <img src="{{ asset('candidate/signatures/signature.jpg') }}" 
                                         class="rounded border" 
                                         width="120" height="120"
                                         onerror="this.onerror=null; this.src='{{ asset('candidate/signatures/signature.jpg') }}';"
                                         alt="Signature">
                                    <p class="mt-2 small text-muted">Signature</p>
                                </div>
                            </div>

                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>MOHD ARSHAD</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Birth</th>
                                        <td>01-01-2001</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Gender</th>
                                        <td>Male</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Category</th>
                                        <td>---</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">OTR No.</th>
                                        <td><span class="badge bg-info">20250117170</span></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
