@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Application Details - {{ $application->application_no }}</h4>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $application->full_name }}</p>
        <p><strong>Mobile:</strong> {{ $application->mobile_no }}</p>
        <p><strong>Email:</strong> {{ $application->email ?? '—' }}</p>
        <p><strong>Status:</strong> {{ $application->status }}</p>
        <p><strong>Submitted At:</strong> {{ $application->created_at->format('d-m-Y H:i') }}</p>

        <hr>
        <h5>Education Details</h5>
        <ul>
            @foreach($application->education as $edu)
                <li>{{ $edu->exam_name }} - {{ $edu->degree }} ({{ $edu->passing_year }})</li>
            @endforeach
        </ul>

        <hr>
        <h5>Uploaded Documents</h5>
        @if($application->documents)
            <p>
                @if($application->documents->photo)
                    <a href="{{ asset('storage/'.$application->documents->photo) }}" target="_blank">Photo</a>
                @endif
                @if($application->documents->signature)
                    | <a href="{{ asset('storage/'.$application->documents->signature) }}" target="_blank">Signature</a>
                @endif
            </p>
        @else
            <p>No documents uploaded.</p>
        @endif

        <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
