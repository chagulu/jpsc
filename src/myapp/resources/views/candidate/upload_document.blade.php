
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidate Dashboard - Sign & Photo</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; }
    .progressbar { counter-reset: step; display: flex; justify-content: space-between; margin: 30px 0; padding: 0; list-style-type: none; }
    .progressbar li { position: relative; flex: 1; text-align: center; font-size: 14px; }
    .progressbar li a { display: block; color: #6c757d; text-decoration: none; font-weight: 500; }
    .progressbar li.active a { color: #1abc9c; font-weight: 600; }
    .progressbar li::before { counter-increment: step; content: counter(step); width: 35px; height: 35px; line-height: 35px; border: 2px solid #6c757d; display: block; text-align: center; margin: 0 auto 10px auto; border-radius: 50%; background-color: #fff; color: #6c757d; transition: 0.3s; }
    .progressbar li.active::before { border-color: #1abc9c; background-color: #1abc9c; color: #fff; }
    .progressbar li::after { content: ''; position: absolute; width: 100%; height: 2px; background-color: #6c757d; top: 18px; left: -50%; z-index: -1; }
    .progressbar li:first-child::after { content: none; }
    .progressbar li.active::after { background-color: #1abc9c; }
    .footer { background: #f8f9fa; padding: 12px; text-align: center; font-size: 14px; color: #666; border-top: 1px solid #eaeaea; }
  </style>
</head>
<body>

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="sidebar bg-dark text-white p-3" style="min-width:220px;">
    <div class="text-center mb-4">
      <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="Logo" class="img-fluid" style="max-height:65px;">
      <h6 class="mt-2">Candidate Dashboard</h6>
    </div>
    <a href="profile.html" class="d-block text-light mb-2"><i class="fas fa-user mr-2"></i> Profile</a>
    <a href="sign-photo.html" class="d-block text-light mb-2 active"><i class="fas fa-image mr-2"></i> Sign & Photo</a>
    <a href="other-details.html" class="d-block text-light mb-2"><i class="fas fa-info-circle mr-2"></i> Other Details</a>
    <a href="education.html" class="d-block text-light mb-2"><i class="fas fa-graduation-cap mr-2"></i> Education</a>
    <a href="preview.html" class="d-block text-light mb-2"><i class="fas fa-eye mr-2"></i> Preview</a>
    <a href="completed.html" class="d-block text-light mb-2"><i class="fas fa-check mr-2"></i> Completed</a>
    <a href="#" class="d-block text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
  </div>

  <!-- Main Page -->
  <div class="flex-grow-1 d-flex flex-column">
    <!-- Topbar -->
    <nav class="navbar navbar-expand topbar bg-success text-white">
      <a class="navbar-brand text-white font-weight-bold" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="JPSC Logo" style="height:40px;" class="mr-2">
        Jharkhand Public Service Commission
      </a>
      <div class="ml-auto d-flex align-items-center">
        <span class="mr-3">Welcome, Candidate</span>
        <img src="https://via.placeholder.com/40" class="rounded-circle border" alt="Profile">
      </div>
    </nav>

    <!-- Progress Bar -->
    <div class="container-fluid">
      <ul class="progressbar">
        <li><a href="profile.html">Profile</a></li>
        <li class="active"><a href="sign-photo.html">Sign & Photo</a></li>
        <li><a href="other-details.html">Other Details</a></li>
        <li><a href="education.html">Education</a></li>
        <li><a href="preview.html">Preview</a></li>
        <li><a href="completed.html">Completed</a></li>
      </ul>
    </div>

    <!-- Page Content -->
    <div class="container p-4 flex-grow-1">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">Upload Sign & Photo</div>
        <div class="card-body">
          <form id="candidateForm" action="{{ route('candidate.uploadDocumentsStore',$application->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label>Upload Passport Size Photo</label>
              <input type="file" class="form-control-file">
              <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 200KB</small>
            </div>
            <div class="form-group">
              <label>Upload Signature</label>
              <input type="file" class="form-control-file">
              <small class="form-text text-muted">Allowed formats: JPG, PNG. Max size: 100KB</small>
            </div>
            <input type="submit" class="btn btn-primary mr-2" value="Save & Next">
          </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      © 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved
    </footer>
  </div>
</div>

</body>
</html>
