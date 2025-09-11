<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Candidate Dashboard - Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color:#f4f6f9; font-family: 'Segoe UI', sans-serif; }
    .progressbar { counter-reset: step; display:flex; justify-content:space-between; margin:30px 0; list-style:none; }
    .progressbar li { flex:1; text-align:center; position:relative; }
    .progressbar li a { color:#6c757d; text-decoration:none; font-weight:500; display:block; }
    .progressbar li.active a { color:#1abc9c; font-weight:600; }
    .progressbar li::before { counter-increment:step; content:counter(step); width:35px; height:35px; line-height:35px; border:2px solid #6c757d; display:block; margin:0 auto 10px; border-radius:50%; background:#fff; color:#6c757d; }
    .progressbar li.active::before { border-color:#1abc9c; background:#1abc9c; color:#fff; }
    .progressbar li::after { content:''; position:absolute; width:100%; height:2px; background:#6c757d; top:18px; left:-50%; z-index:-1; }
    .progressbar li:first-child::after { content:none; }
    .progressbar li.active::after { background:#1abc9c; }
    .footer { background:#f8f9fa; padding:12px; text-align:center; font-size:14px; color:#666; border-top:1px solid #eaeaea; }
  </style>
</head>
<body>
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <div class="sidebar bg-dark text-white p-3" style="min-width:220px;">
    <div class="text-center mb-4">
      <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" class="img-fluid" style="max-height:65px;">
      <h6 class="mt-2">Candidate Dashboard</h6>
    </div>
    <a href="profile.html" class="d-block text-light mb-2"><i class="fas fa-user mr-2"></i> Profile</a>
    <a href="application.html" class="d-block text-light mb-2"><i class="fas fa-file-alt mr-2"></i> Application</a>
    <a href="admit.html" class="d-block text-light mb-2"><i class="fas fa-id-card mr-2"></i> Admit Card</a>
    <a href="results.html" class="d-block text-light mb-2"><i class="fas fa-poll mr-2"></i> Results</a>
    <a href="notifications.html" class="d-block text-light mb-2"><i class="fas fa-bell mr-2"></i> Notifications</a>
    <a href="logout.html" class="d-block text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
  </div>

  <!-- Main -->
  <div class="flex-grow-1 d-flex flex-column">
    <!-- Topbar -->
    <nav class="navbar navbar-expand topbar bg-success text-white">
      <a class="navbar-brand text-white font-weight-bold" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" style="height:40px;" class="mr-2">
        Jharkhand Public Service Commission
      </a>
      <div class="ml-auto d-flex align-items-center">
        <span class="mr-3">Welcome, Candidate</span>
        <img src="https://via.placeholder.com/40" class="rounded-circle border">
      </div>
    </nav>

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

    <!-- Footer -->
    <footer class="footer">© 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved</footer>
  </div>
</div>
</body>
</html>
