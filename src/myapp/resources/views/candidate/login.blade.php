{{-- resources/views/candidate/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Candidate Login (Email/Mobile/OTR + OTP)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
      body{background:linear-gradient(135deg,#f8fafc 0%,#e3effd 100%);font-family:'Segoe UI','Roboto',Arial,sans-serif;margin:0;padding:0;}
      .bssc-header{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(44,104,162,.11);padding:14px 20px;margin-bottom:.8rem;}
      .bssc-header img{height:80px;width:80px;object-fit:contain;margin-right:20px;}
      .notice-board{background:#16467f;color:#fff;font-weight:700;padding:8px 0;font-size:1rem;margin-bottom:.8rem;}
      .marquee{white-space:nowrap;overflow:hidden;box-sizing:border-box;}
      .marquee span{display:inline-block;padding-left:100%;animation:marquee 16s linear infinite;}
      @keyframes marquee{0%{transform:translate(0,0);}100%{transform:translate(-100%,0);}}
      .container-flex{display:flex;max-width:1200px;margin:0 auto;min-height:calc(100vh - 150px);}
      .info-pane{flex:7;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(44,104,162,.10);padding:2rem;margin-right:1rem;}
      .login-pane{flex:3;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(44,104,162,.10);padding:2rem;}
      form{border:1px solid #dcdcdc;border-radius:6px;padding:1rem;background:#fff;}
      label{font-weight:600;margin-top:.4rem;}
      input[type="email"],input[type="text"]{width:100%;padding:.55rem;margin:.3rem 0 1rem 0;border:1px solid #ccc;border-radius:4px;}
      button{background:#16467f;color:#fff;border:none;border-radius:4px;padding:.5rem 1.2rem;cursor:pointer;}
      button:hover{background:#11365f;}
      .notice{margin-top:.6rem;color:#007700;}
      .error{margin-top:.6rem;color:#cc0000;}
      #otp-section{display:none;}
      .register-link{display:none;margin-top:.6rem;}
      .admin-link{display:block;margin-top:1.2rem;text-align:center;}
      ol{padding-left:1.3rem;}
  </style>
</head>
<body>

<div class="container mt-3">
  {{-- HEADER --}}
  <div class="bssc-header d-flex align-items-center">
    <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="Logo">
    <div class="flex-grow-1 text-center">
      <div style="font-size:1.1rem;font-weight:700;color:#1b3869;">Jharkhand Public Service Commission</div>
      <div style="font-size:.95rem;color:#313131;">Circular Road, Ranchi - 834001</div>
      <div style="font-size:.9rem;color:#38406f;">Graduate Level Competitive Examination</div>
    </div>
  </div>

  {{-- NOTICE --}}
  <div class="notice-board">
    <div class="marquee">
      <span>ऑनलाइन आवेदन प्रक्रिया 15 अक्टूबर 2025 तक खुली रहेगी | For assistance email support@jpsc.gov.in</span>
    </div>
  </div>

  {{-- MAIN FLEX --}}
  <div class="container-flex">
    {{-- LEFT 70% : Info --}}
    <div class="info-pane">
      <h2>Registration & Application Instructions</h2>
      <p>Follow the steps carefully before logging in to apply for any JPSC recruitment.</p>
      <h5>Step-by-Step:</h5>
      <ol>
        <li>Visit the official website <a href="https://www.jpsc.gov.in" target="_blank">www.jpsc.gov.in</a></li>
        <li>Find the advertisement & click <strong>Apply Online</strong>.</li>
        <li>Register using your valid email, mobile number, or OTR number.</li>
        <li>Fill the online form, upload photo & signature.</li>
        <li>Pay the application fee online and save the receipt.</li>
        <li>Keep a copy of the application for future reference.</li>
      </ol>
    </div>

    {{-- RIGHT 30% : Candidate Login --}}
    <div class="login-pane">
      <h3 class="mb-3">Candidate Login</h3>

      {{-- Request OTP --}}
      <form id="request-otp-form">
        <label for="identifier">Email / Mobile / OTR No</label>
        <input id="identifier" name="identifier" type="text" required>
        <button type="submit">Request OTP</button>
      </form>

      {{-- Register link if candidate not found --}}
      <a id="register-link" href="{{ route('jet.application.form') }}" class="register-link">Candidate not found? Register here</a>

      {{-- Verify OTP --}}
      <div id="otp-section" class="mt-3">
        <form id="verify-otp-form">
          <label for="verify_identifier">Email / Mobile / OTR No</label>
          <input id="verify_identifier" name="identifier" type="text" readonly>

          <label for="otp">Enter OTP</label>
          <input id="otp" name="otp" type="text" maxlength="6" required>

          <button type="submit">Verify & Login</button>
        </form>
      </div>

      <div id="message"></div>

      <a href="{{ url('/login') }}" class="admin-link">Admin Login</a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const requestForm = document.getElementById('request-otp-form');
  const otpSection = document.getElementById('otp-section');
  const verifyForm = document.getElementById('verify-otp-form');
  const msg = document.getElementById('message');
  const registerLink = document.getElementById('register-link');

  function flash(text, isError = false) {
    msg.textContent = text;
    msg.className = isError ? 'error' : 'notice';
  }

  // Request OTP
  requestForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const identifier = document.getElementById('identifier').value;

    fetch("{{ route('candidate.requestOtp') }}", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify({ identifier })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        flash(data.message || 'OTP sent!');
        document.getElementById('verify_identifier').value = identifier;
        otpSection.style.display = 'block';
        registerLink.style.display = 'none';
      } else if (data.register_link) {
        flash(data.message || 'Candidate not found.', true);
        registerLink.href = data.register_link;
        registerLink.style.display = 'block';
      } else {
        flash(data.message || 'Unable to send OTP', true);
      }
    })
    .catch(() => flash('Server error', true));
  });

  // Verify OTP
  verifyForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const identifier = document.getElementById('verify_identifier').value;
    const otp = document.getElementById('otp').value;

    fetch("{{ route('candidate.verifyOtp') }}", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify({ identifier, otp })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        flash('Login successful!');
        window.location.href = "{{ route('candidate.dashboard') }}";
      } else {
        flash(data.message || 'Invalid OTP', true);
      }
    })
    .catch(() => flash('Server error', true));
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
