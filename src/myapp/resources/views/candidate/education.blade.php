@extends('layouts.candidate.app')

@section('title', 'Other Details')

@section('content')
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
        <form id="candidateForm" action="{{ route('candidate.educationStore', $application->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- One Education Block -->
          <div class="education-block mb-4 p-3 border rounded">
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
                <button type="button" class="btn btn-danger btn-sm removeBlock">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Add Button -->
          <button type="button" id="addBlock" class="btn btn-success mt-2">
            <i class="fas fa-plus"></i> Add More
          </button>
          <input type="submit" class="btn btn-primary mr-2 mt-2" value="Save & Next">

        </form>
      </div>
    </div>
  </div>
@endsection

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).on("click", "#addBlock", function() {
    let block = $(".education-block").first().clone();
    block.find("input, select").val(""); // clear values
    $("#educationContainer").prepend(block); // clones carry mb-4 p-3 border rounded
  });

  $(document).on("click", ".removeBlock", function() {
    if ($(".education-block").length > 1) {
      $(this).closest(".education-block").remove();
    } else {
      alert("At least one education detail is required.");
    }
  });
</script>
