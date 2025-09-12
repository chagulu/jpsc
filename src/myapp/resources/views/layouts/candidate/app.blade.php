<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Candidate Dashboard')</title>

  <!-- Bootstrap 4 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <!-- Better font: Inter (fallbacks included) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link href="{{ asset('css/candidate.css') }}" rel="stylesheet">

  <style>
    /* Base */
    body { background-color:#f5f7fb; font-family: 'Inter', 'Segoe UI', Roboto, Arial, sans-serif; } /* improved font */ /* [20][15] */
    .footer { background:#f8f9fa; padding:12px; text-align:center; font-size:14px; color:#666; border-top:1px solid #eaeaea; }

    /* Sidebar */
    .sidebar {
      min-width: 240px; /* a bit wider for readability */
      max-width: 260px;
      background: #111827; /* slate-900-like */
      color: #e5e7eb;      /* gray-200 */
      padding: 16px 14px;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0,0,0,0.06);
    } /* [1] */

    .sidebar .brand {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 8px 8px 12px;
      border-bottom: 1px solid rgba(255,255,255,0.06); /* separator */
      margin-bottom: 12px;
    } /* [1] */

    .sidebar .brand img {
      max-height: 64px;
      filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
    }

    .sidebar .brand h6 {
      font-weight: 600;
      font-size: 14px;
      margin-top: 8px;
      letter-spacing: .2px;
      color: #f3f4f6; /* gray-100 */
    }

    .sidebar .section-title {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: #9ca3af; /* gray-400 */
      padding: 12px 12px 6px;
      margin: 4px 0 2px;
    } /* [1] */

    .sidebar .nav-link {
      display: flex;
      align-items: center;
      padding: 10px 12px;
      margin: 4px 6px;
      border-radius: 8px;
      color: #d1d5db; /* gray-300 */
      text-decoration: none;
      transition: background .15s ease, color .15s ease, transform .05s ease;
      font-weight: 500;
      font-size: 14px;
    } /* [2] */

    .sidebar .nav-link i {
      width: 20px;
      font-size: 14px;
      opacity: .95;
      margin-right: 10px;
    }

    .sidebar .nav-link:hover {
      background: rgba(255,255,255,0.06);
      color: #ffffff;
    } /* [2] */

    .sidebar .nav-link.active {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); /* blue-600/700 */
      color: #ffffff;
      box-shadow: 0 2px 10px rgba(37,99,235,.25);
    } /* [1] */

    .sidebar .divider {
      height: 1px;
      background: rgba(255,255,255,0.08);
      margin: 10px 8px;
      border-radius: 1px;
    } /* [1] */

    /* Logout button styled as link but prominent */
    .sidebar .logout {
      color: #fca5a5; /* red-300 */
      font-weight: 600;
    }
    .sidebar .logout:hover { color:#fecaca; background: rgba(239,68,68,0.08); } /* [2] */

    /* Topbar minor tweaks */
    .topbar {
      background: #198754; /* Bootstrap green */
      padding-left: 18px; padding-right: 18px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    /* Make layout responsive */
    @media (max-width: 992px) {
      #wrapper { flex-direction: column; }
      .sidebar { width: 100%; max-width: none; flex-direction: row; flex-wrap: wrap; }
      .sidebar .brand { width: 100%; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 4px; }
      .sidebar .nav-link { flex: 1 1 calc(50% - 12px); } /* two per row on tablets */
    }
    @media (max-width: 576px) {
      .sidebar .nav-link { flex: 1 1 100%; } /* stack on phones */
    }
  </style>
</head>
<body>
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="brand">
      <a href="{{ url('/candidate/dashboard') }}" class="d-inline-block">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" class="img-fluid" alt="JPSC">
      </a>
      <h6>Candidate Dashboard</h6>
    </div>

    <div class="section-title">Navigation</div>

    <a href="{{ route('candidate.profile') }}" class="nav-link {{ request()->routeIs('candidate.profile') ? 'active' : '' }}">
      <i class="fas fa-user"></i> <span>Profile</span>
    </a>

    <a href="{{ route('candidate.profile') }}" class="nav-link">
      <i class="fas fa-file-alt"></i> <span>Application</span>
    </a>

    <a href="#" class="nav-link">
      <i class="fas fa-id-card"></i> <span>Admit Card</span>
    </a>

    <a href="#" class="nav-link">
      <i class="fas fa-poll"></i> <span>Results</span>
    </a>

    <a href="#" class="nav-link">
      <i class="fas fa-bell"></i> <span>Notifications</span>
    </a>

    <div class="divider"></div>

    <form id="logout-form" action="{{ route('candidate.logout') }}" method="POST" class="w-100 m-0">
      @csrf
      <button type="submit" class="nav-link logout btn btn-link text-left p-0">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
      </button>
    </form>
  </div>

  <!-- Main -->
  <div class="flex-grow-1 d-flex flex-column">

    <!-- Topbar -->
    <nav class="navbar navbar-expand topbar bg-primary text-white px-3">
    <a class="navbar-brand text-white font-weight-bold d-flex align-items-center" href="#">
        <img src="https://www.jpscexam.com/otr_new/img/logo/jpscImage.png" style="height:40px;" class="mr-2" alt="JPSC">
        Jharkhand Public Service Commission
    </a>

    <div class="ml-auto dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2">Welcome, Candidate</span>
            <img src="{{ asset('candidate/photos/profile.png') }}" 
     class="rounded-circle border" 
     alt="User" 
     style="width:32px; height:32px; object-fit:cover;">

        </a>
        <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('candidate.profile') }}">
                <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <!-- Logout form -->
            <form id="logout-form" action="{{ route('candidate.logout') }}" method="POST" class="w-100 m-0">
                @csrf
                <button type="submit" class="nav-link logout btn btn-link text-left p-0">
                    <i class="fas fa-sign-out-alt mr-2"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>




    <!-- Page content -->
    <div class="container p-4 flex-grow-1">
      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">© 2025 JHARKHAND PUBLIC SERVICE COMMISSION | All Rights Reserved</footer>
  </div>
</div>
</body>
</html>

<!-- Required Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
