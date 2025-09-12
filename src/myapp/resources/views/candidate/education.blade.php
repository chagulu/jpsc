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
                    <select class="form-control" name="education[0][exam_name]" required>
                        <option value="">Select</option>
                        <option value="10th">10th</option>
                        <option value="12th/Diploma">12th/Diploma</option>
                        <option value="Graduation">Graduation</option>
                        <option value="Post-Graduation">Post-Graduation</option>
                        <option value="PhD">Ph.D.</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="subheading">Degree<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][degree]" placeholder="Enter Degree" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="subheading">Subject/Stream<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][subject]" placeholder="Enter Subject" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="subheading">Institute/College<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][school_college]" required>
                </div>
                <div class="form-group col-md-4">
                    <label class="subheading">University/Board<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][board_university]" required>
                </div>
                <div class="form-group col-md-2">
                    <label class="subheading">Status</label>
                    <select class="form-control" name="education[0][status]">
                        <option value="">Select</option>
                        <option value="Completed">Completed</option>
                        <option value="Pursuing">Pursuing</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label class="subheading">Month<span>*</span></label>
                    <select class="form-control" name="education[0][passing_month]" required>
                        <option value="">Select</option>
                        @foreach ([
                            'January','February','March','April','May','June',
                            'July','August','September','October','November','December'
                        ] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label class="subheading">Year<span>*</span></label>
                    <select class="form-control" name="education[0][passing_year]" required>
                        <option value="">Select</option>
                        @for ($y = date('Y'); $y >= 2000; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label class="subheading">% Marks<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][marks_obtained]" required>
                </div>
                <div class="form-group col-md-2">
                    <label class="subheading">Class/Grade</label>
                    <select class="form-control" name="education[0][division]">
                        <option value="">Select</option>
                        <option value="First">First</option>
                        <option value="Second">Second</option>
                        <option value="Third">Third</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="subheading">Certificate Number<span>*</span></label>
                    <input type="text" class="form-control" name="education[0][certificate_number]" required>
                </div>
                <div class="form-group col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm removeBlock">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

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
