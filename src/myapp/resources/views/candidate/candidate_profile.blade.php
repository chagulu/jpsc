@extends('layouts.candidate.app')

@section('title','Profile')



@section('content')

<!-- Progress Bar -->
    <div class="container-fluid">
      <ul class="progressbar">
        <li class="active"><a href="profile.html">Profile</a></li>
        <li><a href="sign-photo.html">Sign & Photo</a></li>
        <li><a href="other-details.html">Other Details</a></li>
        <li><a href="education.html">Education & Experience</a></li>
        <li><a href="preview.html">Preview</a></li>
        <li><a href="completed.html">Completed</a></li>
      </ul>
    </div>
 <!-- Profile Form Content -->
    <div class="container p-4 flex-grow-1">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">Profile Form</div>
        <div class="card-body">
         <form id="candidateForm" action="{{ route('jet.application.update',$application->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="internal_profile" value="internal_profile">
                    <!-- Aadhaar -->
                    <div class="form-group row">
                        <label for="aadhaarCardNumber" class="col-sm-3 col-form-label">Aadhaar Card Number</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('aadhaarCardNumber', $application->aadhaar_card_number) }}"
                            id="aadhaarCardNumber" name="aadhaarCardNumber"
                            onchange="validateAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            placeholder="Aadhaar Card Number" maxlength="12">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmAadhaarCardNumber" class="col-sm-3 col-form-label">Confirm Aadhaar Card Number</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('confirmAadhaarCardNumber', $application->aadhaar_card_number) }}"
                            id="confirmAadhaarCardNumber" name="confirmAadhaarCardNumber"
                            placeholder="Confirm Aadhaar Card Number" maxlength="12"
                            oncopy="return false;" oncut="return false;" onpaste="return false;"
                            onchange="validateConfirmAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="form-group row">
                        <label for="mobileNumber" class="col-sm-3 col-form-label">Mobile Number <span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('mobileNumber', $application->mobile_no) }}"
                            name="mobileNumber" id="mobileNumber" disabled />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group row">
                        <label for="emailId" class="col-sm-3 col-form-label">Email ID<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="email" class="form-control"
                            value="{{ old('emailId', $application->email) }}"
                            id="emailId" name="emailId" onchange="validateEmail()" placeholder="Email ID">
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name (as per Class 10th Certificate)<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('name', $application->full_name) }}"
                            id="name" name="name" oninput="formatFatherName(this)" placeholder="Name...">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmName" class="col-sm-3 col-form-label">Confirm Name<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('confirmName', $application->full_name) }}"
                            id="confirmName" name="confirmName" onchange="validateConfirmName()"
                            oninput="formatFatherName(this)" placeholder="Confirm Name..."
                            oncopy="return false;" oncut="return false;" onpaste="return false;">
                        </div>
                    </div>

                    <!-- Roll No -->
                    <div class="form-group row">
                        <label for="rollNumber" class="col-sm-3 col-form-label">Class 10th Roll Number<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('rollNumber', $application->roll_number) }}"
                            id="rollNumber" name="rollNumber" maxlength="15" placeholder="Class 10th Roll Number">
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group row">
                        <label for="dateOfBirth" class="col-sm-3 col-form-label">Date of Birth<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                            <input type="date" class="form-control"
                            value="{{ old('confirmDateOfBirth', \Carbon\Carbon::parse($application->date_of_birth)->format('Y-m-d')) }}"
                            id="dateOfBirth" name="dateOfBirth" max="2007-09-07" onkeydown="return false">
                        </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmDateOfBirth" class="col-sm-3 col-form-label">Confirm Date of Birth<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                            <input type="date" class="form-control"
                            value="{{ old('confirmDateOfBirth', \Carbon\Carbon::parse($application->date_of_birth)->format('Y-m-d')) }}"
                            id="confirmDateOfBirth" name="confirmDateOfBirth"
                            max="2007-09-07" onchange="validateConfirmDateOfBirth()" onkeydown="return false">
                        </div>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group row">
                        <label for="gender" class="col-sm-3 col-form-label">Gender<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender', $application->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $application->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Third Gender" {{ old('gender', $application->gender) == 'Third Gender' ? 'selected' : '' }}>Third Gender</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmGender" class="col-sm-3 col-form-label">Confirm Gender<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <select class="form-control" id="confirmGender" name="confirmGender" onchange="validateConfirmGender()">
                            <option value="">Select</option>
                            <option value="Male" {{ old('confirmGender', $application->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('confirmGender', $application->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Third Gender" {{ old('confirmGender', $application->gender) == 'Third Gender' ? 'selected' : '' }}>Third Gender</option>
                        </select>
                        </div>
                    </div>

                    <!-- Father & Mother -->
                    <div class="form-group row">
                        <label for="fatherName" class="col-sm-3 col-form-label">Father's Name<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('fatherName', $application->father_name) }}"
                            id="fatherName" name="fatherName" placeholder="Father's Name" oninput="formatFatherName(this)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmFatherName" class="col-sm-3 col-form-label">Confirm Father's Name<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('confirmFatherName', $application->father_name) }}"
                            id="confirmFatherName" name="confirmFatherName" onchange="validateFatherName()"
                            placeholder="Confirm Father's Name" oninput="formatFatherName(this)"
                            oncopy="return false;" oncut="return false;" onpaste="return false;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="motherName" class="col-sm-3 col-form-label">Mother's Name<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('motherName', $application->mother_name) }}"
                            id="motherName" name="motherName" placeholder="Mother's Name" oninput="formatFatherName(this)">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="confirmMotherName" class="col-sm-3 col-form-label">Confirm Mother's Name<span class="required">*</span></label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('confirmMotherName', $application->mother_name) }}"
                            id="confirmMotherName" name="confirmMotherName" onchange="validateMotherName()"
                            placeholder="Confirm Mother's Name" oninput="formatFatherName(this)"
                            oncopy="return false;" oncut="return false;" onpaste="return false;">
                        </div>
                    </div>

                    <!-- Alternate Number -->
                    <div class="form-group row">
                        <label for="alternateNumber" class="col-sm-3 col-form-label">Alternate Mobile Number</label>
                        <div class="col-sm-4">
                        <input type="text" class="form-control"
                            value="{{ old('alternateNumber', $application->alternate_no) }}"
                            id="alternateNumber" name="alternateNumber" placeholder="Alternate Mobile Number"
                            maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            onchange="isValidMobileNumber(this.value)">
                        </div>
                    </div>

                    <!-- Hidden -->
                    <input type="hidden" name="id" value="{{ $application->id }}">
                    <input type="hidden" name="otrNo" value="{{ $application->application_no }}">

                    <!-- Buttons -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-6">
                        <input type="submit" class="btn btn-primary mr-2" value="Save & Next">
                        
                        </div>
                    </div>
                    </form>
        </div>
      </div>
    </div>
@endsection
