@extends('layouts.candidate.app')

@section('title', 'Sign & Photo')

@section('content')
<!-- Progress Bar -->
<div class="container-fluid mb-4">
    <ul class="progressbar">
        <li class="active"><a href="{{ route('candidate.profile') }}">Profile</a></li>
        <li class="active"><a href="javascript:void(0)">Sign & Photo</a></li>
        <li><a href="{{ route('candidate.otherDetails', $application->id) }}">Other Details</a></li>
        <li><a href="{{ route('candidate.education', $application->id) }}">Education</a></li>
        <li><a href="{{ route('candidate.preview', $application->id) }}">Preview</a></li>
        <li><a href="{{ route('candidate.completed', $application->id) }}">Completed</a></li>
    </ul>
</div>

<div class="container">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Upload Signature & Photo</h5>
        </div>
        <div class="card-body p-4">
            <form id="candidateForm" action="{{ route('candidate.uploadDocumentsStore', $application->id) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Photo Upload -->
                <div class="form-group row align-items-center">
                    <label class="col-md-3 col-form-label font-weight-bold">Passport Size Photo</label>
                    <div class="col-md-6">
                        <div class="custom-file-upload text-center p-3 border rounded drag-area" id="photoUpload">
                            <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                            <p class="mb-1">Drag & drop or click to upload</p>
                            <input type="file" class="form-control-file d-none" id="photoInput" name="photo" accept="image/*">

                            @php
                                $photoPath = optional($application->documents)->photo
                                             ? asset('storage/' . $application->documents->photo)
                                             : asset('candidate/photos/profile.png');
                            @endphp
                            <img id="photoPreview" src="{{ $photoPath }}" 
                                 class="mt-2 img-thumbnail {{ optional($application->documents)->photo ? '' : 'd-none' }}" 
                                 width="120" height="120">
                        </div>
                        <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 200KB</small>
                    </div>
                </div>

                <!-- Signature Upload -->
                <div class="form-group row align-items-center mt-4">
                    <label class="col-md-3 col-form-label font-weight-bold">Signature</label>
                    <div class="col-md-6">
                        <div class="custom-file-upload text-center p-3 border rounded drag-area" id="signUpload">
                            <i class="fas fa-signature fa-3x text-muted mb-2"></i>
                            <p class="mb-1">Drag & drop or click to upload</p>
                            <input type="file" class="form-control-file d-none" id="signInput" name="signature" accept="image/*">

                            @php
                                $signPath = optional($application->documents)->signature
                                            ? asset('storage/' . $application->documents->signature)
                                            : asset('candidate/signatures/signature.jpg');
                            @endphp
                            <img id="signPreview" src="{{ $signPath }}" 
                                 class="mt-2 img-thumbnail {{ optional($application->documents)->signature ? '' : 'd-none' }}" 
                                 width="120" height="80">
                        </div>
                        <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 100KB</small>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="form-group row mt-4">
                    <div class="col-md-9 offset-md-3">
                        <a href="{{ route('candidate.profile')  }}" class="btn btn-success">
                                <i class="fas fa-arrow-left mr-1"></i>  Back
                        </a>
                        <!-- <button type="submit" class="btn btn-primary btn-lg px-4">
                            Save & Next <i class="fas fa-arrow-right ml-2"></i>
                        </button> -->

                        @if($progress_status != 'Completed')
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-arrow-right mr-1"></i> Save & Next
                            </button>
                        @else
                            <a href="{{ route('candidate.otherDetails', $application->id) }}" class="btn btn-primary mr-2">Next </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .drag-area {
        cursor: pointer;
        transition: border 0.3s;
    }
    .drag-area:hover {
        border: 2px dashed #007bff;
        background: #f9f9f9;
    }

</style>

<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('photoUpload').addEventListener('click', () => {
        document.getElementById('photoInput').click();
    });
    document.getElementById('signUpload').addEventListener('click', () => {
        document.getElementById('signInput').click();
    });

    document.getElementById('photoInput').addEventListener('change', function () {
        previewImage(this, 'photoPreview');
    });
    document.getElementById('signInput').addEventListener('change', function () {
        previewImage(this, 'signPreview');
    });
</script>
@endsection
