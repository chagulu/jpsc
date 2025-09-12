<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Details</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

 <style>
    .p-custom-align {
      margin-left: 30px;
      font-size: 10pt;
    }
    .label-custom-align {
      margin-left: 10px;
      font-size: 10pt;
    }
    .custom-margin {
      margin-bottom: -15px;
    }
    .disabled {
      opacity: 0.5;
      pointer-events: none;
    }
    .hidden {
      display: none;
    }
    .otp-container {
      display: flex;
      justify-content: flex-end;
      width: 100%;
    }
    .required {
      color: red;
    }
    .sidebar-brand-icon img {
      max-height: 4.5rem;
      height: 4.4rem;
    }
    .navbar {
      padding: 0;
    }
  </style>
</head>
<body class="someBlock" id="page-top" onload="setDefaultData(); loadDefaultData(); getSupportDocumentUploadData();">

<div class="overlay" id="overlay">
  <div class="loader" id="loader"></div>
</div>

<div id="wrapper">
  <!-- Sidebar (optional) -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-navbar topbar static-top" style="background-color: #6777ef;">
        <ul class="navbar-nav">
          <div class="sidebar-brand-icon">
            <a href="/"><img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="JPSC Logo"></a>
          </div>
        </ul>
      </nav>
      <br>

      <!-- Container Fluid-->
      <div class="container-fluid" id="container-wrapper">
        <div class="row">
          <div class="col-lg-8">
            @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            <!-- Profile Form Card -->
            <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                <h6 class="m-0 font-weight-bold text-primary">Profile Details</h6>
              </div>
              <div class="card-body">
                <!-- Success & Error Message Divs -->
              <div id="successMessage" class="alert alert-success" style="display:none;"></div>
              <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>

               {{-- @dd($application) --}}
               <form id="candidateForm" action="{{ route('jet.application.update',$application->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            @if($progress_status != 'Completed')
                                    <input type="submit" class="btn btn-primary mr-2" value="Save & Next">
                            @else
                            <a href="{{ route('candidate.uploadDocuments', $application->id) }}" class="btn btn-primary mr-2">Next </a>
                            @endif
                        
                        
                        </div>
                    </div>
                    </form>
              </div>
            </div>
          </div>

          <!-- Instructions -->
          <div class="col-lg-4">
            <div class="card mb-6">
              <div class="card-body">
                <div class="form-group row custom-margin">
                  <label class="col-sm-5 col-form-label label-custom-align"><b>Candidate Name:</b></label>
                  <label class="col-sm-12">
                    <p class="p-custom-align"><b>1:</b> Do not use any prefixes such as Shri, Dr., Mr., Mrs. etc.</p>
                    <p class="p-custom-align"><b>2:</b> Enter your name exactly as it appears on your Matriculation/Secondary Examination Certificate.</p>
                  </label>
                </div>
                <div class="form-group row custom-margin">
                  <label class="col-sm-4 col-form-label label-custom-align"><b>Date of Birth:</b></label>
                  <label class="col-sm-12">
                    <p class="p-custom-align"><b>1:</b> Enter your date of birth as recorded in your Matriculation/Secondary Examination Certificate.</p>
                  </label>
                </div>
                <div class="form-group row custom-margin">
                  <label class="col-sm-9 col-form-label label-custom-align"><b>Father’s Name and Mother’s Name:</b></label>
                  <label class="col-sm-12">
                    <p class="p-custom-align"><b>1:</b> Do not use any prefixes such as Shri, Dr., Mr., Mrs. etc.</p>
                    <p class="p-custom-align"><b>2:</b> Enter your father’s and mother’s names exactly as in your Matriculation/Secondary Examination Certificate.</p>
                  </label>
                </div>
              </div>
            </div>
          </div>

        </div><!-- row end -->
      </div><!-- container-fluid end -->
    </div><!-- content end -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright © 2025 JHARKHAND PUBLIC SERVICE COMMISSION, All Rights Reserved.</span>
        </div>
      </div>
    </footer>
  </div><!-- content-wrapper end -->
</div><!-- wrapper end -->

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Scripts -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<input type="hidden" id="start">
<input type="hidden" id="stop">
<input type="hidden" id="progressStatus" value="Please wait..">

<script>

    /* Aadhaar Validation */
    function validateAadhaar() {
        const aadhaar = document.getElementById("aadhaarCardNumber").value;
        if (!/^\d{12}$/.test(aadhaar)) {
            alert("Aadhaar number must be exactly 12 digits.");
            document.getElementById("aadhaarCardNumber").value = "";
            document.getElementById("aadhaarCardNumber").focus();
            return false;
        }
        return true;
    }

    function validateConfirmAadhaar() {
        const aadhaar = document.getElementById("aadhaarCardNumber").value;
        const confirm = document.getElementById("confirmAadhaarCardNumber").value;
        if (!/^\d{12}$/.test(confirm)) {
            alert("Confirm Aadhaar number must be exactly 12 digits.");
            document.getElementById("confirmAadhaarCardNumber").value = "";
            document.getElementById("confirmAadhaarCardNumber").focus();
            return false;
        }
        if (aadhaar !== confirm) {
            alert("Aadhaar numbers do not match.");
            document.getElementById("confirmAadhaarCardNumber").value = "";
            document.getElementById("confirmAadhaarCardNumber").focus();
            return false;
        }
        return true;
    }

    /* Email Validation */
    function validateEmail() {
        const email = document.getElementById("emailId").value;
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!pattern.test(email)) {
            alert("Enter a valid email address.");
            document.getElementById("emailId").value = "";
            document.getElementById("confirmAadhaarCardNumber").focus();
            return false;
        }
        return true;
    }

    function checkEmail() {
        const email = document.getElementById("emailId").value;
        const confirm = document.getElementById("confirmEmailId").value;
        if (confirm === "") {
          alert("Enter a valid confirm email address.");
          document.getElementById("confirmEmailId").value = "";
          document.getElementById("confirmEmailId").focus();
          return;
      }
        if (email !== confirm) {
            alert("Email IDs do not match.");
            document.getElementById("confirmEmailId").value = "";
            document.getElementById("confirmAadhaarCardNumber").focus();
            return false;
        }
        return true;
    }

    /* Name Fields */
    function validateConfirmName() {
        const name = document.getElementById("name").value.trim();
        const confirm = document.getElementById("confirmName").value.trim();
        if (name !== confirm) {
            alert("Names do not match.");
            document.getElementById("confirmName").value = "";
            document.getElementById("confirmName").focus();
            return false;
        }
        return true;
    }

    function validateFatherName() {
        const name = document.getElementById("fatherName").value.trim();
        const confirm = document.getElementById("confirmFatherName").value.trim();
        if (name !== confirm) {
            alert("Father's names do not match.");
            document.getElementById("confirmFatherName").value = "";
            return false;
        }
        return true;
    }

    function validateMotherName() {
        const name = document.getElementById("motherName").value.trim();
        const confirm = document.getElementById("confirmMotherName").value.trim();
        if (name !== confirm) {
            alert("Mother's names do not match.");
            document.getElementById("confirmMotherName").value = "";
            return false;
        }
        return true;
    }

    /* Date of Birth */
    function validateConfirmDateOfBirth() {
        const dob = document.getElementById("dateOfBirth").value;
        const confirm = document.getElementById("confirmDateOfBirth").value;
        if (dob !== confirm) {
            alert("Date of Birth values do not match.");
            document.getElementById("confirmDateOfBirth").value = "";
            return false;
        }
        return true;
    }

    /* Gender */
    function validateConfirmGender() {
        const gender = document.getElementById("gender").value;
        const confirm = document.getElementById("confirmGender").value;
        if (gender !== confirm) {
            alert("Gender values do not match.");
            document.getElementById("confirmGender").value = "";
            return false;
        }
        return true;
    }

    /* Name Change Handling */
    function isNameChanged() {
        const yes = document.getElementById("rdChangedNameYes").checked;
        document.getElementById("inputBox").style.display = yes ? "block" : "none";
        document.getElementById("haveYouEverChangedName").value = yes ? "true" : "false";
        }

        function validateChangedName() {
        const name = document.getElementById("changedName").value.trim();
        const confirm = document.getElementById("verifyChangedName").value.trim();
        if (name !== confirm) {
            alert("Changed names do not match.");
            document.getElementById("verifyChangedName").value = "";
            return false;
        }
        return true;
    }

    /* Helpers */
    // function formatFatherName(input) {
    //     input.value = input.value.replace(/[^a-zA-Z\s]/g, '').toUpperCase();
    // }

    /* OTP Handling Stub (you can connect backend later) */
    function sendOtpForOtr(type, action) {
        if (action === "send") {
            
        } else if (action === "verify") {
            alert("OTP verified for " + type);
        }
    }
    function loadDefaultData() {
        if("new" == "view") {
            disableAllFieldInForm("profile_form");
            if("" == "no") {
                document.getElementById("btnSaveBasicDetails").disabled = true;
            }
                document.getElementById("btnSaveBasicDetails").value = "Next";

    } else {
        document.getElementById("btnSaveBasicDetails").value = "Save & Next";
    }

    if("new" == "edit" && "" == "true") {
             // $("#aadhaarCardNumber").attr('disabled',true);
             // $("#confirmAadhaarCardNumber").attr('disabled',true);
              $("#mobileNumber").attr('disabled',true);
              $("#confirmMobileNumber").attr('disabled',true);
              $("#emailId").attr('disabled',true);
              $("#confirmEmailId").attr('disabled',true);
              $("#name").attr('disabled',true);
              $("#confirmName").attr('disabled',true);
              //$("#fatherName").attr('disabled',true);
              //$("#confirmFatherName").attr('disabled',true);
             // $("#motherName").attr('disabled',true);
             // $("#confirmMotherName").attr('disabled',true);
              $("#dateOfBirth").attr('disabled',true);
              $("#confirmDateOfBirth").attr('disabled',true);

    }
    }

    function generatePdfLink(input) {
        const file = input.files[0];
        const pdfLinkContainer = document.getElementById("pdfLinkContainer");
        pdfLinkContainer.innerHTML = "";
        if (file && file.type === "application/pdf") {
            const fileUrl = URL.createObjectURL(file);
            const link = document.createElement("a");
            link.href = fileUrl;
            link.target = "_blank";
            link.textContent = "View Uploaded PDF";
            pdfLinkContainer.appendChild(link);
            input.addEventListener("change", () => URL.revokeObjectURL(fileUrl));
            $("#supportDocumentPdf").hide();
        }
    }

    function validateAndSelectFile(input) {
        const file = input.files[0];
        if (file) {
            const fileType = file.type.toLowerCase();
            const validExtensions = ["application/pdf"];
            const minSizeInBytes = 50 * 1024;
            const maxSizeInBytes = 300 * 1024;
            if (file.size < minSizeInBytes || file.size > maxSizeInBytes) {
            alert("File size should be between 50 KB and 300 KB.");
            input.value = "";
            return false;
            }
            if (!validExtensions.includes(fileType)) {
            alert("Unsupported file format. Please upload only pdf file.");
            input.value = "";
            return false;
            }
        }
    }

    function formatFatherName(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
        input.value = input.value.split(' ').map(word => word.toUpperCase()).join(' ');
    }
    


    function saveCandidateProfile() {
      
      // Basic validations before submission
      if (!validateAadhaar() || !validateConfirmAadhaar()) return;
      // Name validation (required)
      const nameField = document.getElementById("name").value.trim();
      if (nameField === "") {
          alert("Please enter your Name as per Class 10th Certificate.");
          document.getElementById("name").focus();
          return;
      }
        const confirmName = document.getElementById("confirmName").value.trim();
        if (confirmName === "") {
            alert("Please enter your Confirm Name as per Class 10th Certificate.");
            document.getElementById("confirmName").focus();
            return;
        }
        if (!validateConfirmName()) return;

        const rollNumber = document.getElementById("rollNumber").value.trim();
        if (rollNumber === "") {
            alert("Please enter your rollNumber as per Class 10th Certificate.");
            document.getElementById("rollNumber").focus();
            return;
        }

        

        const dateOfBirth = document.getElementById("dateOfBirth").value.trim();
        if (dateOfBirth === "") {
            alert("Please enter your dateOfBirth as per Class 10th Certificate.");
            document.getElementById("dateOfBirth").focus();
            return;
        }

        const confirmDateOfBirth = document.getElementById("confirmDateOfBirth").value.trim();
        if (confirmDateOfBirth === "") {
            alert("Please enter your confirm date Of Birth as per Class 10th Certificate.");
            document.getElementById("confirmDateOfBirth").focus();
            return;
        }
        if (!validateConfirmDateOfBirth()) return;

        const gender = document.getElementById("gender").value.trim();
        if (gender === "") {
            alert("Please select your gender.");
            document.getElementById("gender").focus();
            return;
        }

        const confirmGender = document.getElementById("confirmGender").value.trim();
        if (confirmGender === "") {
            alert("Please select your confirm gender.");
            document.getElementById("confirmGender").focus();
            return;
        }
        if (!validateConfirmGender()) return;

        const fatherName = document.getElementById("fatherName").value.trim();
        if (fatherName === "") {
            alert("Father's name can not be blank");
            document.getElementById("fatherName").focus();
            return;
        }

        const confirmFatherName = document.getElementById("confirmFatherName").value.trim();
        if (confirmFatherName === "") {
            alert("Confirm Father's name can not be blank");
            document.getElementById("confirmFatherName").focus();
            return;
        }
        if (!validateFatherName()) return;
        const motherName = document.getElementById("motherName").value.trim();
        if (motherName === "") {
            alert("Mother's name can not be blank");
            document.getElementById("motherName").focus();
            return;
        }

        const confirmMotherName = document.getElementById("confirmMotherName").value.trim();
        if (confirmMotherName === "") {
            alert("Confirm Mother's name can not be blank");
            document.getElementById("confirmMotherName").focus();
            return;
        }
      
        if (!validateMotherName()) return;
    

      // Submit the form
      document.getElementById("candidateForm").submit();
  }

  /* Go to Home Page */
  function goToHomePage() {
      // Optional confirmation
      if (confirm("Are you sure you want to cancel? All unsaved data will be lost.")) {
          window.location.href = "/"; // Redirect to home page
      }
  }





window.setDefaultData = function() {
  

    // Example: reset form fields (customize as needed)
    const mobile = document.getElementById("mobile");
    const confirmMobile = document.getElementById("confirm_mobile");

    if (mobile && confirmMobile) {
        mobile.value = "";
        confirmMobile.value = "";
    }
};

window.loadDefaultData = function() {
   // Example: set some default values in form fields
    const name = document.getElementById("name");
    const email = document.getElementById("email");

    if (name && email) {
        name.value = "Test User"; // remove or customize
        email.value = "test@example.com"; // remove or customize
    }
};

window.getSupportDocumentUploadData = function () {
    

    // Example placeholder logic
    // Later you can fetch from API or load from DB if needed
    const supportDocField = document.getElementById("supportDocument");
    if (supportDocField) {
        console.log("Support document field found");
        // Example: set default value or placeholder
        supportDocField.placeholder = "Upload your support document here";
    }
};







/* ------------------ MOBILE OTP HANDLING ------------------ */


function showError(msg) {
    $("#errorMessage").text(msg).show();
    $("#successMessage").hide();

    // Auto-hide after 10 seconds
    setTimeout(() => { $("#errorMessage").fadeOut(); }, 10000);
}


</script>


</body>
</html>
