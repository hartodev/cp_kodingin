{{-- Navbar — sama persis dengan desain index.html --}}
<nav class="navbar reveal" id="navbar">
    <div class="nav-container">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="nav-logo">
            {{ \App\Models\Setting::get('site_name', 'PanduanFlow') }}
        </a>

        {{-- Menu --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ url('/') }}"           class="nav-link">Home</a></li>
            <li><a href="{{ url('/courses') }}"    class="nav-link">Kursus</a></li>
            <li><a href="{{ url('/blog') }}"       class="nav-link">Blog</a></li>
            <li><a href="{{ url('/portfolio') }}"  class="nav-link">Portfolio</a></li>
            <li><a href="{{ url('/contact') }}"    class="nav-link">Kontak</a></li>
        </ul>

        {{-- Auth Actions --}}
        <div class="nav-actions">
            @auth
                <a href="{{ route('user.dashboard') }}" class="nav-login">
                    <i class="fas fa-user-circle" style="margin-right:0.4rem;color:var(--gold-primary);"></i>
                    {{ Str::limit(auth()->user()->name, 15) }}
                </a>
                <form method="POST" action="{{ route('user.logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="nav-login" style="background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;font-size:0.92rem;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login') }}"    class="nav-login">Masuk</a>
                <a href="{{ route('auth.register') }}" class="nav-cta">
                    Daftar Gratis <i class="fas fa-arrow-right"></i>
                </a>
            @endauth
        </div>

        {{-- Hamburger mobile --}}
        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
            <i class="fas fa-bars"></i>
        </button>

    </div>
</nav>

{{-- Spacer biar konten tidak ketutup navbar fixed --}}
<div style="height:76px;"></div>
