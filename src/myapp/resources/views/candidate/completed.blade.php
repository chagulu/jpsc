@extends('layouts.candidate.app')

@section('title', 'Application Completed')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Main Page -->
    <div class="flex-grow-1 d-flex flex-column">

        <!-- Progress Bar -->
        <div class="container-fluid">
            <ul class="progressbar">
                <li><a href="">Profile</a></li>
                <li><a href="">Sign & Photo</a></li>
                <li><a href="">Other Details</a></li>
                <li><a href="">Education</a></li>
                <li><a href="">Preview</a></li>
                <li class="active"><a href="">Completed</a></li>
            </ul>
        </div>

        <!-- Page Content -->
        <div class="container p-4 flex-grow-1">
            <div class="card shadow text-center p-5">
                <div class="card-body">
                    <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    <h3 class="mt-3 text-success">Application Submitted Successfully!</h3>
                    <p class="mt-2">
                        Your application has been successfully submitted 
                        @if($application->submitted_at)
                            on <strong>{{ $application->submitted_at->format('d-M-Y h:i A') }}</strong>.
                        @else
                            to the Commission.
                        @endif
                    </p>
                    
                    <div class="alert alert-info mt-4">
                        <strong>Application ID:</strong> {{ $application->application_no ?? 'N/A' }} <br>
                        <strong>Date:</strong> {{ $application->submitted_at ? $application->submitted_at->format('d-M-Y') : now()->format('d-M-Y') }}
                    </div>

                    <div class="mt-4">
                        <a href="" class="btn btn-outline-primary">
                            <i class="fas fa-eye mr-1"></i> View Application
                        </a>
                        <a href="" class="btn btn-success">
                            <i class="fas fa-download mr-1"></i> Download PDF
                        </a>
                        <a href="" target="_blank" class="btn btn-warning">
                            <i class="fas fa-print mr-1"></i> Print
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .progressbar { counter-reset: step; display: flex; justify-content: space-between; margin: 30px 0; padding: 0; list-style-type: none; }
    .progressbar li { position: relative; flex: 1; text-align: center; font-size: 14px; }
    .progressbar li a { display: block; color: #6c757d; text-decoration: none; font-weight: 500; }
    .progressbar li.active a { color: #28a745; font-weight: 600; }
    .progressbar li::before { counter-increment: step; content: counter(step); width: 35px; height: 35px; line-height: 35px; border: 2px solid #6c757d; display: block; text-align: center; margin: 0 auto 10px auto; border-radius: 50%; background-color: #fff; color: #6c757d; transition: 0.3s; }
    .progressbar li.active::before { border-color: #28a745; background-color: #28a745; color: #fff; }
    .progressbar li::after { content: ''; position: absolute; width: 100%; height: 2px; background-color: #6c757d; top: 18px; left: -50%; z-index: -1; }
    .progressbar li:first-child::after { content: none; }
    .progressbar li.active::after { background-color: #28a745; }
</style>
@endsection
