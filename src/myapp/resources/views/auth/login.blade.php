{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    {{-- HEADER --}}
    <div class="bssc-header d-flex align-items-center mb-3" style="background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(44,104,162,.11); padding:14px 20px;">
        <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="Logo" style="height:80px;width:80px;object-fit:contain;margin-right:20px;">
        <div class="flex-grow-1 text-center">
            <div style="font-size:1.1rem;font-weight:700;color:#1b3869;">Jharkhand Public Service Commission</div>
            <div style="font-size:.95rem;color:#313131;">Circular Road, Ranchi - 834001</div>
            <div style="font-size:.9rem;color:#38406f;">Graduate Level Competitive Examination</div>
        </div>
    </div>

    {{-- NOTICE --}}
    <div class="notice-board mb-4" style="background:#16467f; color:#fff; font-weight:700; padding:8px 0; font-size:1rem;">
        <div class="marquee" style="white-space:nowrap; overflow:hidden; box-sizing:border-box;">
            <span style="display:inline-block; padding-left:100%; animation:marquee 16s linear infinite;">
                ऑनलाइन आवेदन प्रक्रिया 15 अक्टूबर 2025 तक खुली रहेगी | For assistance email support@jpsc.gov.in
            </span>
        </div>
    </div>

    {{-- CUSTOM MARQUEE ANIMATION --}}
    <style>
        @keyframes marquee {0% {transform:translate(0,0);} 100% {transform:translate(-100%,0);}}
    </style>

    {{-- SESSION STATUS --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- LOGIN FORM --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Candidate login link --}}
    <div class="mt-6 text-center">
        <a href="http://localhost:8000/candidate/login" class="underline text-sm text-blue-600 hover:text-blue-800">
            Candidate Login
        </a>
    </div>
</x-guest-layout>
