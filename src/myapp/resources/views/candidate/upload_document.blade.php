@extends('layouts.candidate.app')

@section('title', 'Sign & Photo')

@section('content')
  <!-- Progress Bar (page-specific, not common) -->
  <div class="container-fluid">
    <ul class="progressbar">
      <li><a href="{{ route('candidate.profile') }}">Profile</a></li>
      <li class="active"><a href="">Sign & Photo</a></li>
      <li><a href="">Other Details</a></li>
      <li><a href="">Education</a></li>
      <li><a href="">Preview</a></li>
      <li><a href="">Completed</a></li>
    </ul>
  </div>

  <div class="card shadow">
    <div class="card-header bg-primary text-white">Upload Sign & Photo</div>
    <div class="card-body">
      <form id="candidateForm" action="{{ route('candidate.uploadDocumentsStore', $application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label>Upload Passport Size Photo</label>
          <input type="file" class="form-control-file" name="photo">
          <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 200KB</small>
        </div>
        <div class="form-group">
          <label>Upload Signature</label>
          <input type="file" class="form-control-file" name="signature">
          <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 100KB</small>
        </div>
        <input type="submit" class="btn btn-primary mr-2" value="Save & Next">
      </form>
    </div>
  </div>
@endsection
