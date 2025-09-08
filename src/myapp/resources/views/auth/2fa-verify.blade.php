<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Two-Factor Authentication</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body {
          background: linear-gradient(135deg,#f8fafc 0%,#e3effd 100%);
          font-family: 'Segoe UI','Roboto',Arial,sans-serif;
      }
      .card {
          box-shadow: 0 2px 12px rgba(0,0,0,0.1);
          border-radius: 10px;
      }
  </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4" style="max-width: 400px; margin:auto;">
        <h4 class="mb-3 text-center">Two-Factor Authentication</h4>

        {{-- Session message --}}
        @if(session('message'))
            <div class="alert alert-info text-center">{{ session('message') }}</div>
        @endif

        {{-- Display errors --}}
        @if($errors->any())
            <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
        @endif

        {{-- Testing OTP display (optional) --}}
        @if(session('otp'))
            <div class="alert alert-warning text-center">
                <strong>Test OTP:</strong> {{ session('otp') }}
            </div>
        @endif

        <p class="text-center">Enter the 6-digit OTP sent to your email.</p>

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input type="text" class="form-control text-center" name="otp" id="otp" required maxlength="6" autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
