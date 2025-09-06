<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','BSSC Payment Summary')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f8fafc 0%, #e3effd 100%);
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    .bssc-header {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(44,104,162,0.11);
      padding: 14px 20px;
      margin-bottom: 1.5rem;
    }
    .bssc-header img {
      height: 100px;
      width: 100px;
      object-fit: contain;
      margin-right: 20px;
    }
    .notice-board {
      background: #16467f;
      color: #fff;
      font-weight: bold;
      padding: 12px 0;
      letter-spacing: 1px;
      font-size: 1.05rem;
      border-bottom: 2px solid #0d2d53;
      margin-bottom: 0.7rem;
    }
    .marquee { white-space: nowrap; overflow: hidden; box-sizing: border-box; }
    .marquee span {
      display: inline-block; padding-left: 100%;
      animation: marquee 16s linear infinite;
    }
    @keyframes marquee {
      0%   { transform: translate(0, 0); }
      100% { transform: translate(-100%, 0); }
    }
    .summary-card {
      background: #fff;
      box-shadow: 0 2px 32px rgba(44,104,162,0.10), 0 1.5px 8px rgba(44,73,104,0.10);
      border-radius: 15px;
      padding: 2rem 2.5rem;
      max-width: 720px;
      margin: 2rem auto;
    }
    .summary-title { color: #16467f; font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; }
    .btn-primary { background-color: #16467f; border-color: #16467f; }
    .btn-primary:hover { background-color: #11365f; }
    .row-label { font-weight: 600; color: #2a2a2a; }
    .amount { font-weight: 600; color: #16467f; }
  </style>
</head>
<body>
  @yield('content')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
