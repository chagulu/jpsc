<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidate Dashboard - JPSC</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
    }
    .progressbar {
      counter-reset: step;
      display: flex;
      justify-content: space-between;
      margin: 30px 0;
      padding: 0;
      list-style-type: none;
    }
    .progressbar li {
      position: relative;
      flex: 1;
      text-align: center;
      font-size: 14px;
      cursor: pointer;
    }
    .progressbar li a {
      display: block;
      color: #6c757d;
      text-decoration: none;
      font-weight: 500;
    }
    .progressbar li.active a {
      color: #1abc9c;
      font-weight: 600;
    }
    .progressbar li::before {
      counter-increment: step;
      content: counter(step);
      width: 35px;
      height: 35px;
      line-height: 35px;
      border: 2px solid #6c757d;
      display: block;
      text-align: center;
      margin: 0 auto 10px auto;
      border-radius: 50%;
      background-color: #fff;
      color: #6c757d;
      transition: 0.3s;
    }
    .progressbar li.active::before {
      border-color: #1abc9c;
      background-color: #1abc9c;
      color: #fff;
    }
    .progressbar li::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      background-color: #6c757d;
      top: 18px;
      left: -50%;
      z-index: -1;
    }
    .progressbar li:first-child::after {
      content: none;
    }
    .progressbar li.active::after {
      background-color: #1abc9c;
    }
    .footer {
      background: #f8f9fa;
      padding: 12px;
      text-align: center;
      font-size: 14px;
      color: #666;
      border-top: 1px solid #eaeaea;
    }
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
    <a href="#" class="d-block text-light mb-2"><i class="fas fa-user mr-2"></i> Profile</a>
    <a href="#" class="d-block text-light mb-2"><i class="fas fa-file-alt mr-2"></i> Application</a>
    <a href="#" class="d-block text-light mb-2"><i class="fas fa-id-card mr-2"></i> Admit Card</a>
    <a href="#" class="d-block text-light mb-2"><i class="fas fa-poll mr-2"></i> Results</a>
    <a href="#" class="d-block text-light mb-2"><i class="fas fa-bell mr-2"></i> Notifications</a>
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

    <!-- Progress Bar as Tabs -->
    <div class="container-fluid">
      <ul class="progressbar nav nav-tabs" id="formTabs" role="tablist">
        <li class="active nav-item">
          <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profileForm" role="tab">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="sign-tab" data-toggle="tab" href="#signForm" role="tab">Sign & Photo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="other-tab" data-toggle="tab" href="#otherForm" role="tab">Other Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="education-tab" data-toggle="tab" href="#educationForm" role="tab">Education & Experience</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="preview-tab" data-toggle="tab" href="#previewForm" role="tab">Preview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completedForm" role="tab">Completed</a>
        </li>
      </ul>
    </div>

    <!-- Tab Content (Forms) -->
    <div class="tab-content p-4 flex-grow-1" id="formTabsContent">
      <!-- Profile Form -->
      <div class="tab-pane fade show active" id="profileForm" role="tabpanel">
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
              <button class="btn btn-success">Save & Next</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Sign & Photo Form -->
      <div class="tab-pane fade" id="signForm" role="tabpanel">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">Sign & Photo Upload</div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label>Upload Photo</label>
                <input type="file" class="form-control-file">
              </div>
              <div class="form-group">
                <label>Upload Signature</label>
                <input type="file" class="form-control-file">
              </div>
              <button class="btn btn-success">Save & Next</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Other Details Form -->
      <div class="tab-pane fade" id="otherForm" role="tabpanel">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">Other Details</div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" class="form-control">
              </div>
              <div class="form-group">
                <label>Gender</label>
                <select class="form-control">
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
              </div>
              <button class="btn btn-success">Save & Next</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Education Form -->
      <div class="tab-pane fade" id="educationForm" role="tabpanel">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">Education & Experience</div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label>Highest Qualification</label>
                <input type="text" class="form-control">
              </div>
              <div class="form-group">
                <label>Years of Experience</label>
                <input type="number" class="form-control">
              </div>
              <button class="btn btn-success">Save & Next</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Preview -->
      <div class="tab-pane fade" id="previewForm" role="tabpanel">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">Preview Details</div>
          <div class="card-body">
            <p>Here candidate can preview all the entered details before submission.</p>
            <button class="btn btn-warning">Edit</button>
            <button class="btn btn-success">Submit</button>
          </div>
        </div>
      </div>

      <!-- Completed -->
      <div class="tab-pane fade" id="completedForm" role="tabpanel">
        <div class="card shadow">
          <div class="card-header bg-success text-white">Application Completed</div>
          <div class="card-body text-center">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5>Your application has been successfully submitted!</h5>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      © 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved
    </footer>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Highlight progress bar based on active tab
  $('#formTabs a').on('shown.bs.tab', function (e) {
    $('.progressbar li').removeClass('active');
    $(e.target).parent().addClass('active');
    $(e.target).parent().prevAll().addClass('active'); // highlight previous steps
  });
</script>

</body>
</html>
