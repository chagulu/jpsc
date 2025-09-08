<form method="POST" action="{{ route('2fa.verify') }}">
    @csrf
    <label for="otp">Enter OTP sent to your email</label>
    <input type="text" name="otp" maxlength="6" required>
    <button type="submit">Verify</button>
</form>
