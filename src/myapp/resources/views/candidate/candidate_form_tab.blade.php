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
          <form>
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" class="form-control" placeholder="Enter full name">
            </div>
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="text" class="form-control" placeholder="Enter mobile number">
            </div>
            <a href="sign-photo.html" class="btn btn-success">Save & Next</a>
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
