@extends('layouts.candidate.app')

@section('title', 'Candidate Dashboard')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Main Content -->
    <div class="flex-grow-1 d-flex flex-column">

        <div class="container-fluid mt-3">
            <div class="dashboardmaindiv">

                <!-- OTR Status Card -->
                <div class="card otrsegment">
                    <div class="card-header text-center">
                        <h6 class="m-0 font-weight-bold text-dark">OTR Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="mobilediv">
                            <p>Email Verified</p>
                            <span style="color:green" class="tickmarkstyle">✔</span>
                        </div>

                        <div class="mobiledivinnerbg">
                            <p>Mobile Verified</p>
                            <span style="color:green" class="tickmarkstyle">✔</span>
                        </div>

                        <div class="mobilediv">
                            <p>Profile Details Updated</p>
                            <span style="color:green" class="tickmarkstyle">✔</span>
                        </div>

                        <div class="mobiledivinnerbg">
                            <p>Photo Uploaded</p>
                            <span style="color:red" class="crossmarkstyle">✖</span>
                            <a class="newPageOpenUpdater" href="/otr/sign-photo/open-sign-photo-page?mode=edit">Click Here To Add</a>
                        </div>

                        <div class="mobilediv">
                            <p>Signature Uploaded</p>
                            <span style="color:red" class="crossmarkstyle">✖</span>
                        </div>

                        <div class="mobiledivinnerbg">
                            <p>Other Details Updated</p>
                            <span style="color:red" class="crossmarkstyle">✖</span>
                        </div>

                        <div class="mobilediv">
                            <p>Education &amp; Experience Details Updated</p>
                            <span style="color:red" class="crossmarkstyle">✖</span>
                        </div>

                        <div class="mobiledivinnerbg">
                            <p>Finally Submitted</p>
                            <span style="color:red" class="crossmarkstyle">✖</span>
                        </div>
                    </div>
                </div>

                <!-- Candidate Details Card -->
                <div class="card photosection">
                    <div class="card-header text-center">
                        <h6 class="m-0 font-weight-bold text-dark">Candidate Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="profilemaindiv">
                            <div class="profileimg">
                                <img id="photoimage" 
                                     src="{{ asset('candidate/photos/profile.png') }}" 
                                     height="130" width="130" alt="profile"
                                     onerror="this.onerror=null; this.src='{{ asset('candidate/photos/profile.png') }}';">
                            </div>
                            <div class="profileimg">
                                <img id="signimage" 
                                     src="{{ asset('candidate/signatures/signature.jpg') }}" 
                                     height="130" width="130" alt="Signature"
                                     onerror="this.onerror=null; this.src='{{ asset('candidate/signatures/signature.jpg') }}';">
                            </div>
                        </div>

                        <div class="textdeatils">
                            <p class="nametext"><b>Name</b></p>
                            <p>MOHD ARSHAD</p>
                        </div>
                        <div class="textdeatils">
                            <p class="nametext"><b>Date of Birth</b></p>
                            <p>01-01-2001</p>
                        </div>
                        <div class="textdeatils">
                            <p class="nametext"><b>Gender</b></p>
                            <p>Male</p>
                        </div>
                        <div class="textdeatils">
                            <p class="nametext"><b>Category</b></p>
                            <p>---</p>
                        </div>
                        <div class="textdeatils">
                            <p class="nametext"><b>OTR No.</b></p>
                            <p>20250117170</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>

</style>
@endsection
