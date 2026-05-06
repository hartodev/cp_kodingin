<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PanduanFlow - Next Gen Learning')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')
</head>
<body>

    {{-- Particles Background --}}
    <div class="particles" id="particles"></div>

    {{-- Header / Navbar --}}
    @include('frontend.layouts.header')

    {{-- Konten Utama --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- Main JS --}}
    <script src="{{ asset('frontend/assets/js/app.js') }}"></script>

    {{-- Stack untuk JS tambahan per halaman --}}
    @stack('scripts')

</body>
</html>