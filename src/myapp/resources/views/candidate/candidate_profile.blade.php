@extends('layouts.candidate.app')

@section('title','Profile')

@section('content')

<!-- Step Progress Bar -->
 
<div class="container-fluid mb-4">
  <ul class="progressbar d-flex justify-content-between">
        <li class="active"><a href="javascript:void(0)">Profile</a></li>
        <li><a href="{{ route('candidate.uploadDocuments', $application->id) }}">Sign & Photo</a></li>
        <li><a href="{{ route('candidate.otherDetails', $application->id) }}">Other Details</a></li>
        <li><a href="{{ route('candidate.education', $application->id) }}">Education</a></li>
        <li><a href="{{ route('candidate.preview', $application->id) }}">Preview</a></li>
        <li><a href="{{ route('candidate.completed', $application->id) }}">Completed</a></li>
  </ul>
</div>

<!-- Profile Form -->
<div class="container p-4 flex-grow-1">
  <div class="card shadow border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <span><i class="fas fa-user mr-2"></i> Candidate Profile Form</span>
      <small class="text-light">Application No: <b>{{ $application->application_no }}</b></small>
    </div>

    <div class="card-body">
      <form id="candidateForm" action="{{ route('jet.application.update',$application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="internal_profile" value="internal_profile">
        <input type="hidden" name="id" value="{{ $application->id }}">

        <!-- Aadhaar -->
        <h6 class="mt-3 mb-3 text-primary"><i class="fas fa-id-card mr-2"></i> Identity Information</h6>
        <div class="form-group row">
          <label for="aadhaarCardNumber" class="col-sm-3 col-form-label">Aadhaar Card Number</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" maxlength="12"
                   id="aadhaarCardNumber" name="aadhaarCardNumber"
                   value="{{ old('aadhaarCardNumber', $application->aadhaar_card_number) }}"
                   onchange="validateAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                   placeholder="Aadhaar Card Number">
          </div>
        </div>

        <div class="form-group row">
          <label for="confirmAadhaarCardNumber" class="col-sm-3 col-form-label">Confirm Aadhaar Card Number</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" maxlength="12"
                   id="confirmAadhaarCardNumber" name="confirmAadhaarCardNumber"
                   value="{{ old('confirmAadhaarCardNumber', $application->aadhaar_card_number) }}"
                   onchange="validateConfirmAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                   placeholder="Confirm Aadhaar Card Number"
                   oncopy="return false;" oncut="return false;" onpaste="return false;">
          </div>
        </div>

        <!-- Contact -->
        <h6 class="mt-4 mb-3 text-primary"><i class="fas fa-phone-alt mr-2"></i> Contact Information</h6>
        <div class="form-group row">
          <label for="mobileNumber" class="col-sm-3 col-form-label">Mobile Number <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="mobileNumber" disabled
                   value="{{ old('mobileNumber', $application->mobile_no) }}">
          </div>
        </div>
        <div class="form-group row">
          <label for="emailId" class="col-sm-3 col-form-label">Email ID <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="email" class="form-control" id="emailId" name="emailId"
                   value="{{ old('emailId', $application->email) }}"
                   onchange="validateEmail()" placeholder="Email ID">
          </div>
        </div>

        <!-- Personal Details -->
        <h6 class="mt-4 mb-3 text-primary"><i class="fas fa-user-graduate mr-2"></i> Personal Details</h6>
        <div class="form-group row">
          <label for="name" class="col-sm-3 col-form-label">Full Name <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name', $application->full_name) }}"
                   oninput="formatFatherName(this)" placeholder="As per 10th Certificate">
          </div>
        </div>
        <div class="form-group row">
          <label for="confirmName" class="col-sm-3 col-form-label">Confirm Name <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="confirmName" name="confirmName"
                   value="{{ old('confirmName', $application->full_name) }}"
                   onchange="validateConfirmName()" oninput="formatFatherName(this)"
                   placeholder="Confirm Name"
                   oncopy="return false;" oncut="return false;" onpaste="return false;">
          </div>
        </div>

        <!-- Roll Number & DOB -->
        <div class="form-group row">
          <label for="rollNumber" class="col-sm-3 col-form-label">Class 10th Roll No. <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="rollNumber" name="rollNumber" maxlength="15"
                   value="{{ old('rollNumber', $application->roll_number) }}" placeholder="Roll Number">
          </div>
        </div>
        <div class="form-group row">
          <label for="dateOfBirth" class="col-sm-3 col-form-label">Date of Birth <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth"
                     max="2007-09-07"
                     value="{{ old('dateOfBirth', \Carbon\Carbon::parse($application->date_of_birth)->format('Y-m-d')) }}">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="confirmDateOfBirth" class="col-sm-3 col-form-label">Confirm DOB <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
              <input type="date" class="form-control" id="confirmDateOfBirth" name="confirmDateOfBirth"
                     max="2007-09-07"
                     value="{{ old('confirmDateOfBirth', \Carbon\Carbon::parse($application->date_of_birth)->format('Y-m-d')) }}"
                     onchange="validateConfirmDateOfBirth()">
            </div>
          </div>
        </div>

        <!-- Gender -->
        <div class="form-group row">
          <label for="gender" class="col-sm-3 col-form-label">Gender <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <select class="form-control" id="gender" name="gender">
              <option value="">Select</option>
              <option value="Male" {{ old('gender', $application->gender) == 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ old('gender', $application->gender) == 'Female' ? 'selected' : '' }}>Female</option>
              <option value="Third Gender" {{ old('gender', $application->gender) == 'Third Gender' ? 'selected' : '' }}>Third Gender</option>
            </select>
          </div>
        </div>

        <!-- Parents -->
        <h6 class="mt-4 mb-3 text-primary"><i class="fas fa-users mr-2"></i> Parents Details</h6>
        <div class="form-group row">
          <label for="fatherName" class="col-sm-3 col-form-label">Father's Name <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="fatherName" name="fatherName"
                   value="{{ old('fatherName', $application->father_name) }}" placeholder="Father's Name">
          </div>
        </div>
        <div class="form-group row">
          <label for="motherName" class="col-sm-3 col-form-label">Mother's Name <span class="text-danger">*</span></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="motherName" name="motherName"
                   value="{{ old('motherName', $application->mother_name) }}" placeholder="Mother's Name">
          </div>
        </div>

        <!-- Alternate -->
        <h6 class="mt-4 mb-3 text-primary"><i class="fas fa-phone mr-2"></i> Alternate Contact</h6>
        <div class="form-group row">
          <label for="alternateNumber" class="col-sm-3 col-form-label">Alternate Mobile</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="alternateNumber" name="alternateNumber"
                   maxlength="10"
                   value="{{ old('alternateNumber', $application->alternate_no) }}"
                   placeholder="Alternate Mobile Number"
                   oninput="this.value=this.value.replace(/[^0-9]/g,'')">
          </div>
        </div>

        <!-- Buttons -->
        <div class="form-group row mt-4">
          <div class="col-sm-7 offset-sm-3">
        <!-- <a href="{{ route('profile.summary')  }}" class="btn btn-success">
                <i class="fas fa-arrow-left mr-1"></i>  Back
        </a> -->

          @if(
            ($progress_status['step_name'] === 'photo' && $progress_status['status'] !== 'Completed')
            || empty($progress_status['step_name'])
            )
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-arrow-right mr-1"></i> Save & Next
            </button>
        @else
        <a href="{{ route('candidate.uploadDocuments', $application->id) }}" class="btn btn-primary mr-2">
            Next
        </a>
        @endif
            
            <a href="{{ url('candidate/dashboard') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-1"></i> Cancel
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Custom Progressbar CSS -->

@endsection
