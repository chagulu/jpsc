<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Candidate Application Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; }
    .sidebar {
      min-height: 100vh; background: #343a40; color: #fff; padding-top: 20px;
    }
    .sidebar a { color: #ddd; display: block; padding: 10px 15px; text-decoration: none; }
    .sidebar a:hover { background: #495057; color: #fff; }
    .topbar { background: #6777ef; color: #fff; padding: 10px 20px; }
    .topbar .navbar-brand img { height: 45px; }
    .content { padding: 20px; }
    .footer { background: #f8f9fc; padding: 10px; text-align: center; font-size: 14px; }

    /* Form styling */
    .header { text-align: center; margin-bottom: 20px; }
    .header img { max-height: 80px; }
    .form-title { font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 20px; }
    .table th { background: #f1f1f1; }
    .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; }
    .signature-box { height: 60px; border: 1px dashed #000; margin-top: 20px; text-align: center; padding-top: 15px; font-style: italic; }
    .photo-box, .sign-box { border: 1px solid #000; width: 120px; height: 150px; text-align: center; font-size: 12px; line-height: 140px; margin-bottom: 10px; }
    .sign-box { height: 60px; line-height: 55px; }
    .barcode { text-align: center; margin-top: 10px; }
    .barcode img { max-width: 200px; }
  </style>
</head>
<body>
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="Logo" class="img-fluid" style="max-height:60px;">
      <h6 class="mt-2">Candidate Dashboard</h6>
    </div>
    <a href="#"><i class="fas fa-user"></i> Profile</a>
    <a href="/candidate-application"><i class="fas fa-file-alt"></i> Application</a>
    <a href="#"><i class="fas fa-id-card"></i> Admit Card</a>
    <a href="#"><i class="fas fa-poll"></i> Results</a>
    <a href="#"><i class="fas fa-bell"></i> Notifications</a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Page Content -->
  <div class="flex-grow-1 d-flex flex-column">

    <!-- Header -->
    <nav class="navbar topbar">
      <a class="navbar-brand" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="JPSC Logo">
      </a>
      <div class="ml-auto d-flex align-items-center">
        <span class="mr-3">Welcome, Candidate</span>
        <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Profile">
      </div>
    </nav>

    <!-- Content -->
    <div class="content">
      <div class="container-fluid">

        <!-- Application Form -->
        <div class="header">
          <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo">
          <h4>Bihar Staff Selection Commission</h4>
          <p>P.O.- Veterinary College, Patna - 800014</p>
          <div class="form-title">Candidate Application Form</div>
        </div>

        <!-- Top Row with Photos & Barcode -->
        <div class="row mb-4">
          <div class="col-md-3 text-center">
            <div class="photo-box">Candidate Photo</div>
            <div class="sign-box">Signature</div>
          </div>
          <div class="col-md-6 text-center">
            <h5><b>Application No:</b> APP-2025-1234</h5>
            <div class="barcode">
              <img src="https://barcode.tec-it.com/barcode.ashx?data=APP-2025-1234&code=Code128&dpi=96" alt="Barcode">
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>

        <!-- Candidate Details -->
        <div class="section-title">Candidate Details</div>
        <table class="table table-bordered">
          <tbody>
            <tr><th style="width: 30%;">Full Name</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Date of Birth</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Gender</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Father's Name</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Mother's Name</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Mobile Number</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Email ID</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Aadhaar Number</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Roll Number</th><td>{{ $application->full_name}}</td></tr>
          </tbody>
        </table>

        <!-- Address -->
        <div class="section-title">Address</div>
        <table class="table table-bordered">
          <tbody>
            <tr><th style="width: 30%;">Permanent Address</th><td>{{ $application->full_name}}</td></tr>
            <tr><th>Correspondence Address</th><td>{{ $application->full_name}}</td></tr>
          </tbody>
        </table>

        <!-- Declaration -->
        <div class="section-title">Declaration</div>
        <p>
          I hereby declare that the information furnished above is true and correct to the best of my knowledge. 
          I understand that if any information is found false at any stage, my candidature will be cancelled.
        </p>

        <!-- Signature Section -->
        <div class="row">
          <div class="col-md-6">
            <p>Date: ____________</p>
            <p>Place: ____________</p>
          </div>
          <div class="col-md-6 text-right">
            <div class="signature-box">{{ $application->full_name}}</div>
          </div>
        </div>

      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <span>Copyright © 2025 JHARKHAND PUBLIC SERVICE COMMISSION</span>
    </footer>
  </div>
</div>
</body>
</html>
