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
                            <input type="date" name="dob" class="form-control" required
                                   value="{{ old('dob', optional($application->date_of_birth)?->format('Y-m-d')) }}">
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
                                @foreach(['Male','Female','Transgender'] as $gender)
                                    <option value="{{ $gender }}" 
                                        {{ old('gender', $application->gender) === $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                @endforeach
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
                                @foreach(['UR','OBC','SC','ST','EBC','BC','EWS'] as $cat)
                                    <option value="{{ $cat }}" 
                                        {{ old('category', $application->category) === $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label font-weight-bold">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>Address
                        </label>
                        <div class="col-md-6">
                            <input type="text" name="address_line1" class="form-control mb-2" 
                                   placeholder="Address Line 1" 
                                   value="{{ old('address_line1', optional($application->addresses->first())->address_line1) }}" required>
                            <input type="text" name="address_line2" class="form-control mb-2" 
                                   placeholder="Address Line 2 (Optional)" 
                                   value="{{ old('address_line2', optional($application->addresses->first())->address_line2) }}">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="city" class="form-control" placeholder="City" required
                                           value="{{ old('city', optional($application->addresses->first())->city) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="district" class="form-control" placeholder="District"
                                           value="{{ old('district', optional($application->addresses->first())->district) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="state" class="form-control" placeholder="State" required
                                           value="{{ old('state', optional($application->addresses->first())->state) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="pincode" class="form-control" placeholder="Pincode" required
                                           value="{{ old('pincode', optional($application->addresses->first())->pincode) }}">
                                </div>
                            </div>
                            <input type="text" name="country" class="form-control" placeholder="Country" required
                                   value="{{ old('country', optional($application->addresses->first())->country ?? 'India') }}">
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
@endsection
