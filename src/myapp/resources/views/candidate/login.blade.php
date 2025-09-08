<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidate Login (Email + OTP)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { display: flex; max-width: 1100px; margin: 0 auto; min-height: 100vh; }
        .info-pane { flex: 7; padding: 40px; background: #f9f9f9; border-right: 1px solid #ddd; }
        .login-pane { flex: 3; padding: 40px; }
        h1, h2, h3 { margin-top: 0; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 6px; margin-bottom: 16px; background: #fff; }
        label { display: block; margin-bottom: 4px; font-weight: bold; }
        input[type="email"], input[type="text"] { width: 100%; padding: 8px; margin-bottom: 12px; box-sizing: border-box; }
        button { padding: 8px 14px; cursor: pointer; }
        .notice { margin: 10px 0; color: #007700; }
        .error { margin: 10px 0; color: #cc0000; }
        #otp-section { display: none; }
        .admin-link { margin-top: 20px; display: block; }
        ol { padding-left: 20px; }
    </style>
</head>
<body>
<div class="container">
    {{-- LEFT 70% : Instructions --}}
    <div class="info-pane">
        <h2>Jharkhand Public Service Commission (JPSC) – Registration Instructions</h2>
        <p>
            To register with the Jharkhand Public Service Commission (JPSC), visit the official website 
            <a href="https://www.jpsc.gov.in" target="_blank">www.jpsc.gov.in</a>, find the link for the specific job 
            notification, and then follow the online registration steps which include creating an account, 
            filling out the application form, uploading your photograph and signature, and paying the application fee.
        </p>
        <h3>Step-by-Step Registration Process</h3>
        <ol>
            <li>Visit the Official Website: Go to <strong>www.jpsc.gov.in</strong> to access the JPSC portal.</li>
            <li>Find the Relevant Advertisement: On the homepage, click "Apply Online" then select your post’s link.</li>
            <li>Register/Login: Register using a valid email ID and mobile number to create your account.</li>
            <li>Fill in Personal Details: Complete the form with name, address, date of birth, etc.</li>
            <li>Upload Photograph and Signature: Upload recent passport photo & signature as per instructions.</li>
            <li>Fill the Application Form: Provide your educational and other required details.</li>
            <li>Pay the Application Fee: Pay online via net banking, debit card, or credit card.</li>
            <li>Preview and Submit: Review all information carefully before submitting.</li>
            <li>Download and Save: Keep a copy of your application and registration slip for future reference.</li>
        </ol>
    </div>

    {{-- RIGHT 30% : Candidate Login --}}
    <div class="login-pane">
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

        <a href="{{ url('/login') }}" class="admin-link">Admin Login</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const requestForm = document.getElementById('request-otp-form');
    const otpForm = document.getElementById('otp-section');
    const msg = document.getElementById('message');

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
                otpForm.style.display = 'block';
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
                window.location.href = "{{ route('candidate.dashboard') }}";
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
