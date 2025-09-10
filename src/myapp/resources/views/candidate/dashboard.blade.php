<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidate Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .sidebar {
      min-height: 100vh;
      background: #343a40;
      color: #fff;
      padding-top: 20px;
    }
    .sidebar a {
      color: #ddd;
      display: block;
      padding: 10px 15px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #495057;
      color: #fff;
    }
    .topbar {
      background: #6777ef;
      color: #fff;
      padding: 10px 20px;
    }
    .topbar .navbar-brand img {
      height: 45px;
    }
    .content {
      padding: 20px;
    }
    .footer {
      background: #f8f9fc;
      padding: 10px;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
      <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="Logo" class="img-fluid" style="max-height:60px;">
      <h6 class="mt-2">Candidate Dashboard</h6>
    </div>
    <a href="#"><i class="fas fa-user"></i> Profile</a>
    <a href="/candidate-application"><i class="fas fa-file-alt"></i> Application</a>
    <a href="#"><i class="fas fa-id-card"></i> Admit Card</a>
    <a href="#"><i class="fas fa-poll"></i> Results</a>
    <a href="#"><i class="fas fa-bell"></i> Notifications</a>
    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Page Content -->
  <div class="flex-grow-1 d-flex flex-column">
    <!-- Topbar -->
    <nav class="navbar topbar">
      <a class="navbar-brand" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" alt="JPSC Logo">
      </a>
      <div class="ml-auto d-flex align-items-center">
        <span class="mr-3">Welcome, Candidate</span>
        <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Profile">
      </div>
    </nav>

    <!-- Content -->
    <div class="content">
      <div class="container-fluid">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Example Profile Card -->
        <div class="card shadow mb-4">
          <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Profile Details</h6>
          </div>
          <div class="card-body">
            {{-- Put your profile form here (from your existing code) --}}
            @yield('content')
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <span>Copyright © 2025 JHARKHAND PUBLIC SERVICE COMMISSION</span>
    </footer>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
