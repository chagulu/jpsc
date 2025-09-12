@extends('layouts.candidate.app')

@section('title', 'Other Details')

@section('content')
    <!-- Progress Bar -->
    <div class="container-fluid mb-4">
        <ul class="progressbar">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Sign & Photo</a></li>
            <li class="active"><a href="javascript:void(0)">Other Details</a></li>
            <li><a href="#">Education</a></li>
            <li><a href="#">Preview</a></li>
            <li><a href="#">Completed</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Other Details</h5>
            </div>
            <div class="card-body p-4">
                <form id="candidateForm" 
                      action="{{ route('candidate.otherDetailsStore', $application->id) }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Date of Birth -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label font-weight-bold">
                            <i class="fas fa-birthday-cake text-primary mr-2"></i>Date of Birth
                        </label>
                        <div class="col-md-6">
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label font-weight-bold">
                            <i class="fas fa-venus-mars text-primary mr-2"></i>Gender
                        </label>
                        <div class="col-md-6">
                            <select name="gender" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label font-weight-bold">
                            <i class="fas fa-users text-primary mr-2"></i>Category
                        </label>
                        <div class="col-md-6">
                            <select name="category" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                <option>General</option>
                                <option>OBC</option>
                                <option>SC</option>
                                <option>ST</option>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <!-- Address -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label font-weight-bold">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>Address
                        </label>
                        <div class="col-md-6">
                            <input type="text" name="address_line1" class="form-control mb-2" placeholder="Address Line 1" required>
                            <input type="text" name="address_line2" class="form-control mb-2" placeholder="Address Line 2 (Optional)">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="city" class="form-control" placeholder="City" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="district" class="form-control" placeholder="District">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="state" class="form-control" placeholder="State" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="pincode" class="form-control" placeholder="Pincode" required>
                                </div>
                            </div>
                            <input type="text" name="country" class="form-control" placeholder="Country" value="India" required>
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

                    <!-- Action Buttons -->
                    <div class="form-group row mt-4">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Save & Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .progressbar {
            display: flex;
            justify-content: space-between;
            padding: 0;
            margin-bottom: 20px;
            list-style: none;
        }
        .progressbar li {
            flex: 1;
            text-align: center;
            position: relative;
            font-size: 14px;
            font-weight: 500;
        }
        .progressbar li.active a {
            font-weight: bold;
            color: #007bff;
        }
        .progressbar li:before {
            content: '';
            display: block;
            height: 10px;
            width: 10px;
            background: #ccc;
            border-radius: 50%;
            margin: 0 auto 8px;
        }
        .progressbar li.active:before {
            background: #007bff;
        }
    </style>
@endsection
