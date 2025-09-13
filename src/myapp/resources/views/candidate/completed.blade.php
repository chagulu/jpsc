@extends('layouts.candidate.app')

@section('title', 'Application Completed')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Main Page -->
    <div class="flex-grow-1 d-flex flex-column">

        <!-- Progress Bar -->
        <div class="container-fluid">
    <ul class="progressbar">
        <li class="active"><a href="{{ route('candidate.profile', $application->id) }}">Profile</a></li>
        <li class="active"><a href="{{ route('candidate.uploadDocuments', $application->id) }}">Sign & Photo</a></li>
        <li class="active"><a href="{{ route('candidate.otherDetails', $application->id) }}">Other Details</a></li>
        <li class="active"><a href="{{ route('candidate.education', $application->id) }}">Education</a></li>
        <li class="active"><a href="{{ route('candidate.preview', $application->id) }}">Preview</a></li>
        <li class="active"><a href="javascript:void(0)">Completed</a></li>
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

                    <a href="{{ route('candidate.showPreview', $application->id) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-eye mr-1"></i> View Application
                    </a>
                    <a href="{{ route('candidate.download', $application->id) }}" class="btn btn-success">
                        <i class="fas fa-download mr-1"></i> Download PDF
                    </a>
                    <a href="{{ route('candidate.print', $application->id) }}" target="_blank" class="btn btn-warning">
                        <i class="fas fa-print mr-1"></i> Print
                    </a>


                </div>
            </div>
        </div>

    </div>
</div>


@endsection
