{{-- resources/views/candidate/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidate Login (Email + OTP)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 30px auto; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 6px; margin-bottom: 16px; }
        label { display: block; margin-bottom: 4px; }
        input[type="email"], input[type="text"] { width: 100%; padding: 8px; margin-bottom: 12px; }
        button { padding: 8px 14px; }
        .notice { margin: 10px 0; color: #007700; }
        .error { margin: 10px 0; color: #cc0000; }
        #otp-section { display: none; }
    </style>
</head>
<body>
<h2>Candidate Login</h2>

{{-- Request OTP --}}
<form id="request-otp-form">
    <label for="email">Email address</label>
    <input id="email" name="email" type="email" required>
    <button type="submit">Request OTP</button>
</form>

{{-- Verify OTP --}}
<form id="otp-section">
    <label for="verify_email">Email</label>
    <input id="verify_email" name="email" type="email" readonly>

    <label for="otp">Enter OTP</label>
    <input id="otp" name="otp" type="text" maxlength="6" required>

    <button type="submit">Verify & Login</button>
</form>

<div id="message"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const requestForm = document.getElementById('request-otp-form');
    const otpForm = document.getElementById('otp-section');
    const msg = document.getElementById('message');

    // Helper
    function flash(text, isError = false) {
        msg.textContent = text;
        msg.className = isError ? 'error' : 'notice';
    }

    // Request OTP
    requestForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value;

        fetch("{{ route('candidate.requestOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                flash(data.message || 'OTP sent!');
                document.getElementById('verify_email').value = email;
                otpForm.style.display = 'block';      // enable OTP form
            } else {
                flash(data.message || 'Unable to send OTP', true);
            }
        })
        .catch(() => flash('Server error', true));
    });

    // Verify OTP
    otpForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = document.getElementById('verify_email').value;
        const otp = document.getElementById('otp').value;

        fetch("{{ route('candidate.verifyOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ email, otp })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                flash('Login successful!');
                window.location.href = "{{ route('candidate.dashboard') }}"; // redirect
            } else {
                flash(data.message || 'Invalid OTP', true);
            }
        })
        .catch(() => flash('Server error', true));
    });
});
</script>
</body>
</html>
