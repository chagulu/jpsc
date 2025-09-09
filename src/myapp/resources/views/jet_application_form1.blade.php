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
            <!-- Profile Form Card -->
            <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                <h6 class="m-0 font-weight-bold text-primary">Profile Details</h6>
              </div>
              <div class="card-body">
                <!-- Success & Error Message Divs -->
              <div id="successMessage" class="alert alert-success" style="display:none;"></div>
              <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>


               <form id="candidateForm" action="{{ route('jet.application.submit') }}" method="POST">

                @csrf
                  <center><p style="color:red;font-weight:bold;"></p></center>

                  <!-- Aadhaar -->
                  <div class="form-group row">
                    <label for="aadhaarCardNumber" class="col-sm-3 col-form-label">Aadhaar Card Number</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="aadhaarCardNumber" name="aadhaarCardNumber" onchange="validateAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="Aadhaar Card Number" maxlength="12">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmAadhaarCardNumber" class="col-sm-3 col-form-label">Confirm Aadhaar Card Number</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="confirmAadhaarCardNumber" name="confirmAadhaarCardNumber" placeholder="Confirm Aadhaar Card Number" maxlength="12" oncopy="return false;" oncut="return false;" onpaste="return false;" onchange="validateConfirmAadhaar()" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    </div>
                  </div>

                  <!-- Mobile -->
                  <div class="form-group row">
                    <label for="mobileNumber" class="col-sm-3 col-form-label">Mobile Number <span class="required">*</span></label>
                    <div class="col-sm-4">
                     <input type="text" class="form-control" name ="mobileNumber" id="mobileNumber" onchange="validateMobile(this)" />
                    </div>
                  </div>

                  <!-- Confirm Mobile + OTP -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Confirm Mobile Number<span class="required">*</span></label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" id="confirmMobileNumber" onchange="validateMobile(this)" />


                  </div>
                    <div class="col-sm-2" id="verifiedTickMobile" style="display:none;">
                      <h2 style="color:green">✔</h2>
                    </div>
                    <div class="col-sm-2" id="otpFieldMobile" style="display:none;">
                      <input type="text" class="form-control" id="mobileNumberOtp" name="mobileNumberOtp" placeholder="Enter OTP.." maxlength="6">
                    </div>
                    <div class="col-sm-2">
                      <input type="button" class="btn btn-primary" id="sendOtpMobile" value="Send OTP">
                    </div>
                    <div id="verifyOtpMobileDiv" style="display:none;">
                      <input type="button" class="btn btn-primary" id="verifyOtpMobile" value="Verify">
                    </div>
                  </div>

                  <!-- Email + OTP -->
                  <div class="form-group row">
                    <label for="emailId" class="col-sm-3 col-form-label">Email ID<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" id="emailId" name="emailId" onchange="validateEmail()" placeholder="Email ID">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmEmailId" class="col-sm-3 col-form-label">Confirm Email ID<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" id="confirmEmailId" name="confirmEmailId" onchange="checkEmail()" placeholder="Confirm Email ID" oncopy="return false;" oncut="return false;" onpaste="return false;">
                    </div>
                    <div class="col-sm-2" id="verifiedTickEmail" style="display:none;">
                      <h2 style="color:green">✔</h2>
                    </div>
                    <div class="col-sm-2" id="otpField" style="display:none;">
                      <input type="text" class="form-control" id="otpInput" name="otp" placeholder="OTP" maxlength="6">
                    </div>
                    <div class="col-sm-2">
                      <input type="button" class="btn btn-primary" id="sendOtpButton" value="Send OTP">
                    </div>
                    <div id="verifyOtpEmail" style="display:none;">
                      <input type="button" class="btn btn-primary" id="verifyOtpEmailBtn" value="Verify">
                    </div>
                  </div>

                  <!-- Name -->
                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name (as per Class 10th Certificate)<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="name" name="name" oninput="formatFatherName(this)" placeholder="Name...">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmName" class="col-sm-3 col-form-label">Confirm Name<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="confirmName" name="confirmName" onchange="validateConfirmName()" oninput="formatFatherName(this)" placeholder="Confirm Name..." oncopy="return false;" oncut="return false;" onpaste="return false;">
                    </div>
                  </div>

                  <!-- Roll No -->
                  <div class="form-group row">
                    <label for="rollNumber" class="col-sm-3 col-form-label">Class 10th Roll Number<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="rollNumber" name="rollNumber" maxlength="15" placeholder="Class 10th Roll Number">
                    </div>
                  </div>

                  <!-- Changed Name -->
                  <fieldset class="form-group">
                    <div class="row">
                      <legend class="col-form-label col-sm-3 pt-0">Have you ever changed your name?</legend>
                      <div class="col-sm-4">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="rdIsChangedName" id="rdChangedNameYes" onclick="isNameChanged()" value="true">
                          <label class="form-check-label" for="rdChangedNameYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="rdIsChangedName" id="rdChangedNameNo" onclick="isNameChanged()" value="false">
                          <label class="form-check-label" for="rdChangedNameNo">No</label>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" id="haveYouEverChangedName" name="haveYouEverChangedName" value="false">
                  </fieldset>

                  <div id="inputBox" style="display:none;">
                    <div class="form-group row">
                      <label for="changedName" class="col-sm-3 col-form-label">Changed name<span class="required">*</span></label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="changedName" name="changedName" placeholder="Changed name" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="verifyChangedName" class="col-sm-3 col-form-label">Confirm changed name<span class="required">*</span></label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="verifyChangedName" name="verifyChangedName" onchange="validateChangedName()" placeholder="Confirm changed name" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="uploadSupportedDocument" class="col-sm-3 col-form-label">Upload Document<span class="required">*</span></label>
                      <div class="col-sm-4">
                        <input type="file" class="uploadSupportedDocument" id="uploadSupportedDocument" name="uploadSupportedDocument" style="width:203px;" onchange="validateAndSelectFile(this); generatePdfLink(this);">
                      </div>
                      <div id="pdfLinkContainer" style="margin-top:10px;"></div>
                      <div class="employerandbebbredinnerdivinput" style="margin-left:13px; display:none!important;" id="supportDocumentPdf">
                        <a href="/new-otr/showPdf?type=supportDocumentUpload" target="_blank">
                          <i class="fas fa-file-pdf" style="color:red; font-size:20px;"></i>
                        </a>
                      </div>
                      <p style="font-size:12px;"><b style="color:red;">Note:</b> The document size must be between 50 KB and 300 KB in PDF format.</p>
                    </div>
                  </div>

                  <!-- Date of Birth -->
                  <div class="form-group row">
                    <label for="dateOfBirth" class="col-sm-3 col-form-label">Date of Birth<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <div class="input-group date">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" max="2007-09-07" onkeydown="return false">
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmDateOfBirth" class="col-sm-3 col-form-label">Confirm Date of Birth<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <div class="input-group date">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                        <input type="date" class="form-control" id="confirmDateOfBirth" name="confirmDateOfBirth" max="2007-09-07" onchange="validateConfirmDateOfBirth()" onkeydown="return false">
                      </div>
                    </div>
                  </div>

                  <!-- Gender -->
                  <div class="form-group row">
                    <label for="gender" class="col-sm-3 col-form-label">Gender<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <select class="form-control" id="gender" name="gender">
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Third Gender">Third Gender</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmGender" class="col-sm-3 col-form-label">Confirm Gender<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <select class="form-control" id="confirmGender" name="confirmGender" onchange="validateConfirmGender()">
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Third Gender">Third Gender</option>
                      </select>
                    </div>
                  </div>

                  <!-- Father & Mother -->
                  <div class="form-group row">
                    <label for="fatherName" class="col-sm-3 col-form-label">Father's Name<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Father's Name" oninput="formatFatherName(this)">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmFatherName" class="col-sm-3 col-form-label">Confirm Father's Name<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="confirmFatherName" name="confirmFatherName" onchange="validateFatherName()" placeholder="Confirm Father's Name" oninput="formatFatherName(this)" oncopy="return false;" oncut="return false;" onpaste="return false;">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="motherName" class="col-sm-3 col-form-label">Mother's Name<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="motherName" name="motherName" placeholder="Mother's Name" oninput="formatFatherName(this)">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="confirmMotherName" class="col-sm-3 col-form-label">Confirm Mother's Name<span class="required">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="confirmMotherName" name="confirmMotherName" onchange="validateMotherName()" placeholder="Confirm Mother's Name" oninput="formatFatherName(this)" oncopy="return false;" oncut="return false;" onpaste="return false;">
                    </div>
                  </div>

                  <!-- Alternate Number -->
                  <div class="form-group row">
                    <label for="alternateNumber" class="col-sm-3 col-form-label">Alternate Mobile Number</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="alternateNumber" name="alternateNumber" placeholder="Alternate Mobile Number" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" onchange="isValidMobileNumber(this.value)">
                    </div>
                  </div>

                  <!-- Buttons -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-6">
                      <input type="button" class="btn btn-primary mr-2" onclick="saveCandidateProfile()" value="Save & Next">
                      <input type="button" class="btn btn-secondary" onclick="goToHomePage()" value="Cancel">
                    </div>
                  </div>

                  <input type="hidden" name="id">
                  <input type="hidden" name="otrNo">
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

    $("#sendOtpMobile").on("click", function () {
        let mobile = $("#confirmMobileNumber").val().trim();

        if (!/^[6-9]\d{9}$/.test(mobile)) {
            alert("Please enter a valid 10-digit mobile number starting with 6-9.");
            return;
        }

        // Simulate OTP send
        

        // Show OTP input + verify button
        $("#otpFieldMobile").show();
        $("#verifyOtpMobileDiv").show();

        // Start resend countdown
        let timer = 30;
        let btn = $(this);
        btn.prop("disabled", true).val("Resend in " + timer);

        let interval = setInterval(function () {
            timer--;
            btn.val("Resend in " + timer);
            if (timer <= 0) {
                clearInterval(interval);
                btn.prop("disabled", false).val("Send OTP");
            }
        }, 1000);
    });

   


    /* ------------------ EMAIL OTP HANDLING ------------------ */
    

    $("#verifyOtpEmail").on("click", function () {
        let otp = $("#otpInput").val().trim();

        if (!/^\d{6}$/.test(otp)) {
            alert("Please enter a valid 6-digit OTP.");
            return;
        }

        // Simulate OTP verification
       

        $("#verifiedTickEmail").show(); // Show green tick
        $("#otpField").hide();          // Hide OTP input
        $("#verifyOtpEmail").hide();    // Hide verify button
        $("#sendOtpButton").hide();     // Hide send OTP button
    });


    function saveCandidateProfile() {
      
      // Basic validations before submission
      if (!validateAadhaar() || !validateConfirmAadhaar()) return;
      if (!validateMobile() || !validateConfirmMobileNumber()) return;
      if (!validateEmail() || !checkEmail()) return;
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
      
     

      // If "Changed Name" section is visible, validate it
      // if (document.getElementById("inputBox").style.display === "block") {
      //     if (!validateChangedName()) return;
      // }

      // Check that OTPs are verified
      // if ($("#verifiedTickMobile").css("display") === "none") {
      //     alert("Please verify your mobile number before submitting.");
      //     return;
      // }
      // if ($("#verifiedTickEmail").css("display") === "none") {
      //     alert("Please verify your email before submitting.");
      //     return;
      // }

      // Optional: show loader while submitting
      //$("#overlay").show();

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

  /* ---------------- MOBILE OTP ---------------- */
$("#verifyOtpMobile").on("click", function () {
    let otp = $("#mobileNumberOtp").val().trim();
    let mobile = $("#confirmMobileNumber").val().trim();

    // 1️⃣ Validate OTP format
    if (!/^\d{6}$/.test(otp)) {
        alert("Please enter a valid 6-digit OTP.");
        return;
    }

    // 2️⃣ Send OTP to server for verification
    $.ajax({
        url: "/verify-otp",       // Your backend endpoint
        method: "POST",
        data: {
            type: "mobile",
            value: mobile,       // Mobile number to verify
            otp: otp,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            // 3️⃣ On success, show tick and hide inputs/buttons
            $("#verifiedTickMobile").show();
            $("#otpFieldMobile").hide();
            $("#verifyOtpMobileDiv").hide();
            $("#sendOtpMobile").hide();
        },
        error: function (xhr) {
            // 4️⃣ On failure, show error and keep OTP input visible
            alert("Invalid OTP. Please try again.");
            $("#mobileNumberOtp").val(""); // Optionally clear input
            $("#mobileNumberOtp").focus();
        }
    });
});




/* ---------------- EMAIL OTP ---------------- */



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

// Validate Mobile Number
window.validateMobile = function (input) {
    const field = input || document.getElementById("mobileNumber");
    const value = field.value.trim();
    const regex = /^[6-9]\d{9}$/;

    if (!regex.test(value)) {
        alert("Please enter a valid 10-digit mobile number starting with 6-9.");
        field.value = "";
        field.focus();
        return false;
    }
    return true;
};

// Validate Confirm Mobile Number
window.validateConfirmMobileNumber = function () {
    const mobile = document.getElementById("mobileNumber").value.trim();
    const confirm = document.getElementById("confirmMobileNumber").value.trim();

    if (mobile !== confirm) {
        alert("Mobile numbers do not match.");
        document.getElementById("confirmMobileNumber").value = "";
        document.getElementById("confirmMobileNumber").focus();
        return false;
    }
    return true;
};



/* ------------------ MOBILE OTP HANDLING ------------------ */


$("#sendOtpMobile").off("click").on("click", function () {
    let mobile = $("#confirmMobileNumber").val().trim();

    if (!/^[6-9]\d{9}$/.test(mobile)) {
        showError("Please enter a valid 10-digit mobile number starting with 6-9.");
        return;
    }

    $.ajax({
        url: "/send-otp",
        method: "POST",
        data: {
            type: "mobile",
            value: mobile,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            if (response.success) {
                showSuccess("OTP sent to " + mobile);

                // Show OTP input and verify button
                $("#otpFieldMobile").show();
                $("#verifyOtpMobileDiv").show();

                // Start resend countdown
                let timer = 30;
                let btn = $("#sendOtpMobile");
                btn.prop("disabled", true).val("Resend in " + timer);

                let interval = setInterval(function () {
                    timer--;
                    btn.val("Resend in " + timer);
                    if (timer <= 0) {
                        clearInterval(interval);
                        btn.prop("disabled", false).val("Send OTP");
                    }
                }, 1000);
            } else {
                showError(response.message || "Failed to send OTP. Try again.");
                $("#otpFieldMobile").hide();
                $("#verifyOtpMobileDiv").hide();
            }
        },
        error: function () {
            showError("Error sending OTP. Check your connection.");
            $("#otpFieldMobile").hide();
            $("#verifyOtpMobileDiv").hide();
        }
    });
});







/* ------------------ EMAIL OTP HANDLING ------------------ */
// Use delegated event binding in case button is dynamically rendered
$(document).on("click", "#sendOtpButton", function () {
    let email = $("#confirmEmailId").val().trim();
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!pattern.test(email)) {
        showError("Enter a valid email.");
        return;
    }

    let btn = $(this);

    $.ajax({
        url: "/send-otp",
        method: "POST",
        data: {
            type: "email",
            value: email,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            if (response.success) {
                showSuccess("OTP sent to your email!");

                // Show OTP field and verify button
                $("#otpField").show();
                $("#verifyOtpEmail").show();

                // Start resend timer
                let timer = 30;
                btn.prop("disabled", true).val("Resend in " + timer);
                let interval = setInterval(function () {
                    timer--;
                    btn.val("Resend in " + timer);
                    if (timer <= 0) {
                        clearInterval(interval);
                        btn.prop("disabled", false).val("Send OTP");
                    }
                }, 1000);
            } else {
                showError(response.message || "Failed to send OTP.");
                $("#otpField").hide();
                $("#verifyOtpEmail").hide();
            }
        },
        error: function (xhr) {
            let response = xhr.responseJSON;
            if (response && response.message) {
                showError(response.message);
            } else {
                showError("Failed to send OTP. Please try again.");
            }
            $("#otpField").hide();
            $("#verifyOtpEmail").hide();
        }
    });
});


$("#verifyOtpEmailBtn").on("click", function () {
    let otp = $("#otpInput").val().trim();
    let email = $("#confirmEmailId").val().trim();

    if (!/^\d{6}$/.test(otp)) {
        alert("Please enter a valid 6-digit OTP.");
        return;
    }

    $.ajax({
        url: "/verify-otp",
        method: "POST",
        data: {
            type: "email",
            value: email,
            otp: otp,
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            if (response.success) {
                alert("Email OTP Verified Successfully!");
                $("#verifiedTickEmail").show();
                $("#otpField").hide();
                $("#verifyOtpEmail").hide();
                $("#sendOtpButton").hide();
            } else {
                // OTP invalid — show error and keep input visible
                alert(response.message || "Invalid OTP. Please try again.");
                $("#otpField").show();
                $("#verifyOtpEmail").show();
            }
        },
        error: function (xhr) {
            alert("Email OTP verification failed: " + xhr.responseText);
        }
    });
});

function isValidMobileNumber(number) {
    // Check if number is exactly 10 digits
    if (!/^\d{10}$/.test(number)) {
        alert("Please enter a valid 10-digit mobile number");
        return false;
    }
    return true;
}

   function showSuccess(msg) {
    $("#successMessage").text(msg).show();
    $("#errorMessage").hide();

    // Auto-hide after 10 seconds
    setTimeout(() => { $("#successMessage").fadeOut(); }, 10000);
}

function showError(msg) {
    $("#errorMessage").text(msg).show();
    $("#successMessage").hide();

    // Auto-hide after 10 seconds
    setTimeout(() => { $("#errorMessage").fadeOut(); }, 10000);
}


</script>


</body>
</html>
