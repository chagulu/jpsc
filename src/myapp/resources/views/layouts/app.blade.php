{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Candidate Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body{ background:#f4f6f9; font-family: 'Segoe UI', sans-serif; }
    /* progressbar, footer etc — your CSS */
  </style>
</head>
<body>
  <div class="d-flex" id="wrapper">
    {{-- include candidate sidebar --}}
    @include('layouts.candidate.sidebar')

    <div class="flex-grow-1 d-flex flex-column">
      {{-- include candidate header --}}
      @include('layouts.candidate.header')

      {{-- optional progress bar (keeps active state) --}}
      <div class="container-fluid">
        <ul class="progressbar">
          <li class="{{ request()->is('candidate/profile*') ? 'active' : '' }}"><a href="">Profile</a></li>
          <li class="{{ request()->is('candidate/sign-photo*') ? 'active' : '' }}"><a href="">Sign & Photo</a></li>
          <li class="{{ request()->is('candidate/other-details*') ? 'active' : '' }}"><a href="">Other Details</a></li>
          <li class="{{ request()->is('candidate/education*') ? 'active' : '' }}"><a href="">Education</a></li>
          <li class="{{ request()->is('candidate/preview*') ? 'active' : '' }}"><a href="">Preview</a></li>
          <li class="{{ request()->is('candidate/completed*') ? 'active' : '' }}"><a href="">Completed</a></li>
        </ul>
      </div>

      {{-- main content from child views --}}
      <div class="container p-4 flex-grow-1">
        @yield('content')
      </div>

      <footer class="footer">© 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved</footer>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
