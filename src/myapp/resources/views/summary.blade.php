@extends('layouts.app') {{-- optional, if you have a layout --}}

@section('content')
<div class="container">

  <div class="bssc-header d-flex align-items-center shadow-sm mb-3">
      <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo" style="height:100px;width:100px;">
      <div class="flex-grow-1 text-center">
        <div style="font-size: 1.15rem; font-weight: 700; color: #1b3869;">Bihar Staff Selection Commission</div>
        <div style="font-size: 0.98rem; color: #313131;">P.O.-VETERINARY COLLEGE, PATNA - 800014</div>
        <div style="font-size: 0.93rem; color: #38406f;">Adv No.-05/25, 4th Graduate Level Combined Competitive Exam</div>
        <div style="font-size: 0.93rem; color: #3b525e;">चतुर्थ स्नातक स्तरीय संयुक्त प्रतियोगिता परीक्षा</div>
      </div>
  </div>

  <div class="summary-card p-4 shadow rounded bg-white">
      <h2 class="summary-title text-center mb-4">Payment Summary</h2>

      <div class="row mb-2">
        <div class="col-6 fw-semibold">Application ID:</div>
        <div class="col-6 text-end">{{ $application->application_no }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-6 fw-semibold">Applicant Name:</div>
        <div class="col-6 text-end">{{ $application->full_name }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-6 fw-semibold">Mobile:</div>
        <div class="col-6 text-end">{{ $application->mobile_no }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-6 fw-semibold">Email:</div>
        <div class="col-6 text-end">{{ $application->email ?? '—' }}</div>
      </div>

      <hr>
      <div class="row mb-2">
        <div class="col-6 fw-semibold">Base Fee:</div>
        <div class="col-6 text-end text-primary">₹{{ number_format($baseFee, 2) }}</div>
      </div>
      <div class="row mb-2">
        <div class="col-6 fw-semibold">GST (18%):</div>
        <div class="col-6 text-end text-primary">₹{{ number_format($gst, 2) }}</div>
      </div>
      <div class="row mb-2">
        <div class="col-6 fw-semibold">Total Payable:</div>
        <div class="col-6 text-end fs-5 text-primary">₹{{ number_format($total, 2) }}</div>
      </div>

      <div class="alert alert-info mt-4">
        Verify your details before proceeding. Once you click Pay, you’ll be redirected to the secure Paytm payment page.
      </div>

      <div class="d-grid">
        <button class="btn btn-primary btn-lg">Proceed to Pay</button>
      </div>
  </div>
</div>
@endsection
