@extends('layouts.public')
@section('title','Payment Summary')

@section('content')
<div class="container">

  {{-- Header --}}
  <div class="bssc-header d-flex align-items-center shadow-sm">
      <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo">
      <div class="flex-grow-1 text-center">
        <div style="font-size: 1.15rem; font-weight: 700; color: #1b3869;">Bihar Staff Selection Commission</div>
        <div style="font-size: 0.98rem; color: #313131;">P.O.-VETERINARY COLLEGE, PATNA - 800014</div>
        <div style="font-size: 0.93rem; color: #38406f;">Adv No.-05/25, 4th Graduate Level Combined Competitive Exam</div>
        <div style="font-size: 0.93rem; color: #3b525e;">चतुर्थ स्नातक स्तरीय संयुक्त प्रतियोगिता परीक्षा</div>
      </div>
  </div>

  {{-- Notice --}}
  <div class="notice-board">
    <div class="marquee">
      <span>सभी आवेदकों को सूचित किया जाता है कि ऑनलाइन आवेदन प्रक्रिया 5 अक्टूबर 2025 तक खुली रहेगी | कृपया आगे की सूचना एवं अपडेट्स के लिए इस नोटिस बोर्ड पर ध्यान दें | For assistance, contact support@bssc.gov.in.</span>
    </div>
  </div>

  <div class="text-end mt-3">
    <form action="{{ route('candidate.logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
    </form>
</div>

  {{-- Summary card --}}
  <div class="summary-card">
      <h2 class="summary-title">Confirm Profile Details</h2>

      <div class="row mb-3">
        <div class="col-6 row-label">Application ID:</div>
        <div class="col-6 text-end">{{ $application->application_no ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Aadhar Card Number:</div>
        <div class="col-6 text-end">{{ $application->aadhaar_card_number ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Applicant Name:</div>
        <div class="col-6 text-end">{{ $application->full_name ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Mobile:</div>
        <div class="col-6 text-end">{{ $application->mobile_no ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Email:</div>
        <div class="col-6 text-end">{{ $application->email ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Date of Birth:</div>
        <div class="col-6 text-end">{{ $application->date_of_birth ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Gender:</div>
        <div class="col-6 text-end">{{ $application->gender ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Father Name:</div>
        <div class="col-6 text-end">{{ $application->father_name ?? 'Pending...' }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-6 row-label">Mother Name:</div>
        <div class="col-6 text-end">{{ $application->mother_name ?? 'Pending...' }}</div>
      </div>
      <hr>
      
      <form action="{{ route('profile.summary.save', $application->application_no ?? 0) }}" method="GET">
        @csrf
        <button type="submit" name="action" value="agree" class="btn btn-primary btn-lg">I Agree</button>
        <button type="submit" name="action" value="update" class="btn btn-primary btn-lg">Update</button>
      </form>

  </div>
</div>
@endsection
