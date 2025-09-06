<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="sidebar">
        @include('partials.admin_sidebar')
    </div>

    <div class="main-content">
        @include('partials.admin_header')
        
        <div class="content">
            @yield('content')
        </div>
    </div>

    <footer>
        @include('partials.admin_footer')
    </footer>
</body>
</html>
