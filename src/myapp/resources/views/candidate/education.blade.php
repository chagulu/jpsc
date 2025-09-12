@extends('layouts.candidate.app')

@section('title', 'Education Details')

@section('content')
<div class="container-fluid mb-4">
    <ul class="progressbar">

        <li class="active"><a href="{{ route('candidate.profile', $application->id) }}">Profile</a></li>
        <li class="active"><a href="{{ route('candidate.uploadDocuments', $application->id) }}">Sign & Photo</a></li>
        <li class="active"><a href="{{ route('candidate.otherDetails', $application->id) }}">Other Details</a></li>
        <li class="active"><a href="javascript:void(0)">Education</a></li>
        <li><a href="{{ route('candidate.preview', $application->id) }}">Preview</a></li>
        <li><a href="{{ route('candidate.completed', $application->id) }}">Completed</a></li>
    </ul>
</div>

<div class="container p-4 flex-grow-1">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">Education Details</div>
        <div class="card-body">
            <form id="candidateForm" action="{{ route('candidate.educationStore', $application->id) }}" method="POST">
                @csrf

                @php
                    $educations = $application->education()->get();
                    if ($educations->isEmpty()) {
                        $educations = collect([new \App\Models\ApplicationEducation]);
                    }
                @endphp

                <div id="educationContainer">
                    @foreach($educations as $index => $edu)
                        <div class="education-block mb-4 p-3 border rounded">
                            <input type="hidden" name="education[{{ $index }}][id]" value="{{ $edu->id ?? '' }}">
                            <input type="hidden" name="education[{{ $index }}][deleted]" value="0" class="deletedFlag">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Exam Passed<span>*</span></label>
                                    <select class="form-control" name="education[{{ $index }}][exam_name]" required>
                                        <option value="">Select</option>
                                        @foreach(['10th','12th/Diploma','Graduation','Post-Graduation','PhD'] as $exam)
                                            <option value="{{ $exam }}" {{ ($edu->exam_name ?? '') == $exam ? 'selected' : '' }}>{{ $exam }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Degree<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][degree]" value="{{ $edu->degree ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Subject/Stream<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][subject]" value="{{ $edu->subject ?? '' }}" required>
                                </div>
                            </div>

                            <div class="form-row mt-2">
                                <div class="form-group col-md-4">
                                    <label>Institute/College<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][school_college]" value="{{ $edu->school_college ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>University/Board<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][board_university]" value="{{ $edu->board_university ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Status</label>
                                    <select class="form-control" name="education[{{ $index }}][status]">
                                        <option value="">Select</option>
                                        <option value="Completed" {{ ($edu->status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Pursuing" {{ ($edu->status ?? '') == 'Pursuing' ? 'selected' : '' }}>Pursuing</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Month<span>*</span></label>
                                    <select class="form-control" name="education[{{ $index }}][passing_month]" required>
                                        <option value="">Select</option>
                                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                            <option value="{{ $month }}" {{ ($edu->passing_month ?? '') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mt-2">
                                <div class="form-group col-md-2">
                                    <label>Year<span>*</span></label>
                                    <select class="form-control" name="education[{{ $index }}][passing_year]" required>
                                        <option value="">Select</option>
                                        @for ($y = date('Y'); $y >= 2000; $y--)
                                            <option value="{{ $y }}" {{ ($edu->passing_year ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>% Marks<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][marks_obtained]" value="{{ $edu->marks_obtained ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Class/Grade</label>
                                    <select class="form-control" name="education[{{ $index }}][division]">
                                        <option value="">Select</option>
                                        <option value="First" {{ ($edu->division ?? '') == 'First' ? 'selected' : '' }}>First</option>
                                        <option value="Second" {{ ($edu->division ?? '') == 'Second' ? 'selected' : '' }}>Second</option>
                                        <option value="Third" {{ ($edu->division ?? '') == 'Third' ? 'selected' : '' }}>Third</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Certificate Number<span>*</span></label>
                                    <input type="text" class="form-control" name="education[{{ $index }}][certificate_number]" value="{{ $edu->certificate_number ?? '' }}" required>
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm removeBlock"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

               
                <a href="{{ route('candidate.otherDetails',$application->id)  }}" class="btn btn-success">
                    <i class="fas fa-arrow-left mr-1"></i>  Back
                </a>
                @if($progress_status != 'Completed')
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-arrow-right mr-1"></i> Save & Next
                </button>
                @else
                    <a href="{{ route('candidate.preview', $application->id) }}" class="btn btn-primary mr-2">Next </a>
                @endif
                

                 <button type="button" id="addBlock" class="btn btn-success mt-2">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </form>
        </div>
    </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let counter = $('#educationContainer .education-block').length;

    // Add new block
    $('#addBlock').click(function() {
        let newBlock = $('#educationContainer .education-block:first').clone();

        // Clear all input/select values
        newBlock.find('input').val('');
        newBlock.find('select').val('');

        // Update indexes
        newBlock.find('[name]').each(function() {
            let name = $(this).attr('name');
            name = name.replace(/\[\d+\]/, `[${counter}]`);
            $(this).attr('name', name);
        });

        $('#educationContainer').append(newBlock);
        counter++;
    });

    // Remove block
    $('#educationContainer').on('click', '.removeBlock', function() {
        let blocks = $('#educationContainer .education-block');
        if (blocks.length === 1) {
            blocks.find('input, select').val(''); // clear first row
        } else {
            $(this).closest('.education-block').remove();
        }
    });
});
</script>

