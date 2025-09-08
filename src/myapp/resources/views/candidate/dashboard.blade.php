{{-- resources/views/candidate/dashboard.blade.php --}}
<h1>Welcome, Candidate</h1>
<form method="POST" action="{{ route('candidate.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
