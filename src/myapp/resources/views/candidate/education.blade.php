<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidate Dashboard - Education</title>

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
    .education-block { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #fff; }
    .subheading { font-size: 13px; font-weight: 600; }
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
    <a href="sign-photo.html" class="d-block text-light mb-2"><i class="fas fa-image mr-2"></i> Sign & Photo</a>
    <a href="other-details.html" class="d-block text-light mb-2"><i class="fas fa-info-circle mr-2"></i> Other Details</a>
    <a href="education.html" class="d-block text-light mb-2 active"><i class="fas fa-graduation-cap mr-2"></i> Education</a>
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
        <li><a href="sign-photo.html">Sign & Photo</a></li>
        <li><a href="other-details.html">Other Details</a></li>
        <li class="active"><a href="education.html">Education</a></li>
        <li><a href="preview.html">Preview</a></li>
        <li><a href="completed.html">Completed</a></li>
      </ul>
    </div>

    <!-- Page Content -->
    <div class="container p-4 flex-grow-1">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">Education Details</div>
        <div class="card-body" id="educationContainer">
           <form id="candidateForm" action="{{ route('candidate.educationStore',$application->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
          <!-- One Education Block -->
          <div class="education-block">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="subheading">Exam Passed<span>*</span></label>
                <select class="form-control">
                  <option value="">Select</option>
                  <option value="1">10th</option>
                  <option value="2">12th/Diploma</option>
                  <option value="3">Graduation</option>
                  <option value="4">Post-Graduation</option>
                  <option value="5">PH.D.</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Degree<span>*</span></label>
                <input type="text" class="form-control" placeholder="Enter Degree">
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Subject/Stream<span>*</span></label>
                <input type="text" class="form-control" placeholder="Enter Subject">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="subheading">Institute/College<span>*</span></label>
                <input type="text" class="form-control">
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">University/Board<span>*</span></label>
                <input type="text" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Status</label>
                <select class="form-control">
                  <option value="">Select</option>
                  <option>Completed</option>
                  <option>Pursuing</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Month<span>*</span></label>
                <select class="form-control">
                  <option value="">Select</option>
                  <option>January</option><option>February</option><option>March</option>
                  <option>April</option><option>May</option><option>June</option>
                  <option>July</option><option>August</option><option>September</option>
                  <option>October</option><option>November</option><option>December</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="subheading">Year<span>*</span></label>
                <select class="form-control">
                  <option value="">Select</option>
                  <!-- Year Options -->
                  <option>2025</option><option>2024</option><option>2023</option><option>2022</option>
                  <option>2021</option><option>2020</option><option>2019</option><option>2018</option>
                  <option>2017</option><option>2016</option><option>2015</option><option>2014</option>
                  <option>2013</option><option>2012</option><option>2011</option><option>2010</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">% Marks<span>*</span></label>
                <input type="text" class="form-control">
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Class/Grade</label>
                <select class="form-control">
                  <option value="">Select</option>
                  <option>First</option>
                  <option>Second</option>
                  <option>Third</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Certificate Number<span>*</span></label>
                <input type="text" class="form-control">
              </div>
              <div class="form-group col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm removeBlock"><i class="fas fa-trash"></i></button>
              </div>
            </div>
          </div>

          <!-- Add Button -->
          <button type="button" id="addBlock" class="btn btn-success"><i class="fas fa-plus"></i> Add More</button>
          <!-- <a href="preview.html" class="btn btn-primary ml-2">Save & Next</a> -->
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

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).on("click", "#addBlock", function() {
    let block = $(".education-block").first().clone();
    block.find("input, select").val(""); // clear values
    $("#educationContainer").prepend(block);
  });

  $(document).on("click", ".removeBlock", function() {
    if ($(".education-block").length > 1) {
      $(this).closest(".education-block").remove();
    } else {
      alert("At least one education detail is required.");
    }
  });
</script>

</body>
</html>
