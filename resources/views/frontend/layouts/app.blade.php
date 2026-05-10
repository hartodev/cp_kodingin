<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PanduanFlow')) — @yield('title_suffix', 'Next Gen Learning')</title>

    {{-- SEO --}}
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', 'Platform belajar online terbaik'))">
    <meta name="keywords"    content="@yield('meta_keywords', \App\Models\Setting::get('meta_keywords', 'belajar coding, kursus online'))">
    <meta property="og:title"       content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', ''))">
    <meta property="og:image"       content="@yield('og_image', asset('frontend/assets/img/og.jpg'))">
    <meta property="og:type"        content="website">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Frontend CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/frontend.css') }}">

    {{-- Google Analytics --}}
    @php $gaId = \App\Models\Setting::get('google_analytics_id'); @endphp
    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif

    @stack('styles')
</head>
<body>

    {{-- Particles Background — persis seperti index.html --}}
    <div class="particles" id="particles"></div>

    {{-- Navbar --}}
    @include('frontend.layouts.header')

    {{-- Flash Alert --}}
    @include('frontend.layouts.alert')

    {{-- Konten --}}
    <main style="position:relative;z-index:2;min-height:70vh;">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- Frontend JS --}}
    <script src="{{ asset('frontend/assets/js/frontend.js') }}"></script>

    @stack('scripts')

</body>
</html>
