@extends('layouts.candidate.app')

@section('title', 'Other Details')

@section('content')
    <!-- Progress Bar -->
    <div class="container-fluid">
        <ul class="progressbar">
            <li><a href="">Profile</a></li>
            <li><a href="">Sign & Photo</a></li>
            <li class="active"><a href="">Other Details</a></li>
            <li><a href="">Education</a></li>
            <li><a href="">Preview</a></li>
            <li><a href="">Completed</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="container p-4 flex-grow-1">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Other Details</div>
            <div class="card-body">
                <form id="candidateForm" 
                      action="{{ route('candidate.otherDetailsStore', $application->id) }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">-- Select --</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">-- Select Category --</option>
                            <option>General</option>
                            <option>OBC</option>
                            <option>SC</option>
                            <option>ST</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter full address"></textarea>
                    </div>
                   <input type="submit" class="btn btn-primary mr-2" value="Save & Next">
                </form>
            </div>
        </div>
    </div>
@endsection
