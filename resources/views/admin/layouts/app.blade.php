<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — PanduanFlow Admin</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/admin.css') }}">

    {{-- Stack CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>

    <div class="app-container">

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Wrapper --}}
        <div class="main-wrapper" id="mainWrapper">

            {{-- Header --}}
            @include('admin.layouts.header')

            {{-- Main Content --}}
            <main class="main-content">

                {{-- Alert session --}}
                @include('admin.layouts.alert')

                {{-- Konten halaman --}}
                @yield('content')

            </main>

            {{-- Footer --}}
            @include('admin.layouts.footer')

        </div>
    </div>

    {{-- Admin JS --}}
    <script src="{{ asset('backend/assets/js/admin.js') }}"></script>

    {{-- Stack JS tambahan per halaman --}}
    @stack('scripts')

</body>

</html>
