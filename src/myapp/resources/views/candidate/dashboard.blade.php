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
.dashboardmaindiv { display: grid; grid-template-columns: 2fr 1fr; grid-gap: 20px; }
.card { border-radius: 10px; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); }
.mobilediv, .mobiledivinnerbg { display: flex; justify-content: space-between; padding: 10px; font-size: 14px; }
.mobiledivinnerbg { background-color: #f1f1f1; }
.tickmarkstyle, .crossmarkstyle { font-size: 18px; font-weight: bold; }
.profilemaindiv { display: flex; justify-content: center; margin-bottom: 20px; }
.profileimg { margin: 0 10px; }
.profileimg img { border-radius: 8px; border: 1px solid #ddd; }
.textdeatils { display: flex; justify-content: space-between; border-bottom: 1px solid #eaeaea; padding: 5px 0; }
.nametext { margin: 0; font-weight: 600; color: #333; }
.newPageOpenUpdater { display: block; font-size: 12px; margin-top: 5px; color: #007bff; text-decoration: underline; }
</style>
@endsection
