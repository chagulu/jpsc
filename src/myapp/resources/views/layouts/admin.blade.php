<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Kaiadmin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: { families: ["Font Awesome 5 Solid","Font Awesome 5 Regular","Font Awesome 5 Brands","simple-line-icons"], urls: ["{{ asset('assets/css/fonts.min.css') }}"] },
        active: function () { sessionStorage.fonts = true; },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
</head>
<body>
    <div class="wrapper">
        {{-- Sidebar --}}
        @include('partials.admin_sidebar')

        <div class="main-panel">
            {{-- Header --}}
            @include('partials.admin_header')

            {{-- Content --}}
            <div class="container">
                @yield('content')
            </div>

            {{-- Footer --}}
            @include('partials.admin_footer')
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugin/chart.min.js') }}"></script>
    <script src="{{ asset('js/plugin/chart.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    @stack('scripts')
</body>
</html>
