@extends('layouts.candidate.app')

@section('title', 'Education Details')

@section('content')
  <!-- Progress Bar -->
  <div class="container-fluid mb-4">
    <ul class="progressbar">
      <li><a href="#">Profile</a></li>
      <li><a href="#">Sign & Photo</a></li>
      <li><a href="#">Other Details</a></li>
      <li class="active"><a href="#">Education</a></li>
      <li><a href="#">Preview</a></li>
      <li><a href="#">Completed</a></li>
    </ul>
  </div>

  <!-- Page Content -->
  <div class="container p-4 flex-grow-1">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">Education Details</div>
      <div class="card-body" id="educationContainer">
        <form id="candidateForm" action="{{ route('candidate.educationStore', $application->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          @php
              $educations = $application->education ?? collect([new \App\Models\ApplicationEducation]);
          @endphp

          @foreach($educations as $index => $edu)
          <div class="education-block mb-4 p-3 border rounded">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="subheading">Exam Passed<span>*</span></label>
                <select class="form-control" name="education[{{ $index }}][exam_name]" required>
                  <option value="">Select</option>
                  @foreach(['10th','12th/Diploma','Graduation','Post-Graduation','PhD'] as $exam)
                    <option value="{{ $exam }}" {{ ($edu->exam_name ?? '') == $exam ? 'selected' : '' }}>{{ $exam }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Degree<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][degree]" value="{{ $edu->degree ?? '' }}" placeholder="Enter Degree" required>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Subject/Stream<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][subject]" value="{{ $edu->subject ?? '' }}" placeholder="Enter Subject" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="subheading">Institute/College<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][school_college]" value="{{ $edu->school_college ?? '' }}" required>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">University/Board<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][board_university]" value="{{ $edu->board_university ?? '' }}" required>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Status</label>
                <select class="form-control" name="education[{{ $index }}][status]">
                  <option value="">Select</option>
                  <option value="Completed" {{ ($edu->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                  <option value="Pursuing" {{ ($edu->status ?? '') == 'Pursuing' ? 'selected' : '' }}>Pursuing</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Month<span>*</span></label>
                <select class="form-control" name="education[{{ $index }}][passing_month]" required>
                  <option value="">Select</option>
                  @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                    <option value="{{ $month }}" {{ ($edu->passing_month ?? '') == $month ? 'selected' : '' }}>{{ $month }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-2">
                <label class="subheading">Year<span>*</span></label>
                <select class="form-control" name="education[{{ $index }}][passing_year]" required>
                  <option value="">Select</option>
                  @for ($y = date('Y'); $y >= 2000; $y--)
                    <option value="{{ $y }}" {{ ($edu->passing_year ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">% Marks<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][marks_obtained]" value="{{ $edu->marks_obtained ?? '' }}" required>
              </div>
              <div class="form-group col-md-2">
                <label class="subheading">Class/Grade</label>
                <select class="form-control" name="education[{{ $index }}][division]">
                  <option value="">Select</option>
                  <option value="First" {{ ($edu->division ?? '') == 'First' ? 'selected' : '' }}>First</option>
                  <option value="Second" {{ ($edu->division ?? '') == 'Second' ? 'selected' : '' }}>Second</option>
                  <option value="Third" {{ ($edu->division ?? '') == 'Third' ? 'selected' : '' }}>Third</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="subheading">Certificate Number<span>*</span></label>
                <input type="text" class="form-control" name="education[{{ $index }}][certificate_number]" value="{{ $edu->certificate_number ?? '' }}" required>
              </div>
              <div class="form-group col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm removeBlock">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
          @endforeach

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

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).on("click", "#addBlock", function() {
    let block = $(".education-block").first().clone();
    block.find("input, select").val(""); // clear values
    // fix name attributes for cloned block
    let newIndex = $(".education-block").length;
    block.find("input, select").each(function(){
      let name = $(this).attr('name');
      if(name) {
        name = name.replace(/\[\d+\]/, `[${newIndex}]`);
        $(this).attr('name', name);
      }
    });
    $("#educationContainer").append(block);
  });

  $(document).on("click", ".removeBlock", function() {
    if ($(".education-block").length > 1) {
      $(this).closest(".education-block").remove();
    } else {
      alert("At least one education detail is required.");
    }
  });
</script>
@endsection
