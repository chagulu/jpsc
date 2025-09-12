<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Candidate Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/candidate.css') }}" rel="stylesheet">

  <style>
    body { background-color:#f4f6f9; font-family: 'Segoe UI', sans-serif; }
    .footer { background:#f8f9fa; padding:12px; text-align:center; font-size:14px; color:#666; border-top:1px solid #eaeaea; }
  </style>
</head>
<body>
<div class="d-flex" id="wrapper">

  {{-- Sidebar --}}
  <div class="sidebar bg-dark text-white p-3" style="min-width:220px;">
    <div class="text-center mb-4">
      <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" class="img-fluid" style="max-height:65px;">
      <h6 class="mt-2">Candidate Dashboard</h6>
    </div>
   <a href="{{ route('candidate.profile') }}" class="d-block text-light mb-2">
      <i class="fas fa-user mr-2"></i> Profile
  </a>

    <a href="{{ route('candidate.profile') }}" class="d-block text-light mb-2"><i class="fas fa-file-alt mr-2"></i> Application</a>
    <a href="" class="d-block text-light mb-2"><i class="fas fa-id-card mr-2"></i> Admit Card</a>
    <a href="" class="d-block text-light mb-2"><i class="fas fa-poll mr-2"></i> Results</a>
    <a href="" class="d-block text-light mb-2"><i class="fas fa-bell mr-2"></i> Notifications</a>
   <form id="logout-form" action="{{ route('candidate.logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="d-block text-danger btn btn-link p-0">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
    </button>
</form>


  </div>

  {{-- Main --}}
  <div class="flex-grow-1 d-flex flex-column">
    
    {{-- Topbar --}}
    <nav class="navbar navbar-expand topbar bg-success text-white">
      <a class="navbar-brand text-white font-weight-bold" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" style="height:40px;" class="mr-2">
        Jharkhand Public Service Commission
      </a>
      <div class="ml-auto d-flex align-items-center">
        <span class="mr-3">Welcome, Candidate</span>
        <img src="https://via.placeholder.com/40" class="rounded-circle border">
      </div>
    </nav>

    {{-- Page content --}}
    <div class="container p-4 flex-grow-1">
      @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="footer">© 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved</footer>
  </div>
</div>
</body>
</html>
