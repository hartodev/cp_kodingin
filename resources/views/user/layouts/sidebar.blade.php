@php
    $unreadNotif = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();
    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
    $currentRoute = request()->route()->getName();
@endphp

<aside class="user-sidebar" id="userSidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div>
            <a href="{{ url('/') }}">{{ \App\Models\Setting::get('site_name', 'PanduanFlow') }}</a>
            <span>Student Dashboard</span>
        </div>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            @if (auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}"
                    style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            @endif
        </div>
        <div style="min-width:0;">
            <div class="user-name">{{ Str::limit(auth()->user()->name, 18) }}</div>
            <div class="user-role"><i class="fas fa-graduation-cap" style="margin-right:3px;"></i>Siswa</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">

        {{-- Utama --}}
        <div class="nav-group">
            <div class="nav-group-label">Utama</div>
            <a href="{{ route('user.dashboard') }}"
                class="nav-item {{ $currentRoute === 'user.dashboard' ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt nav-icon"></i> Dashboard
            </a>
            <a href="{{ route('user.my-courses') }}"
                class="nav-item {{ $currentRoute === 'user.my-courses' ? 'active' : '' }}">
                <i class="fas fa-book-open nav-icon"></i> Kursus Saya
            </a>
            <a href="{{ route('user.certificates') }}"
                class="nav-item {{ $currentRoute === 'user.certificates' ? 'active' : '' }}">
                <i class="fas fa-certificate nav-icon"></i> Sertifikat
            </a>
        </div>

        {{-- Belanja --}}
        <div class="nav-group">
            <div class="nav-group-label">Belanja</div>
            <a href="{{ route('user.cart') }}" class="nav-item {{ $currentRoute === 'user.cart' ? 'active' : '' }}">
                <i class="fas fa-shopping-cart nav-icon"></i> Keranjang
                @if ($cartCount > 0)
                    <span class="nav-badge">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('user.wishlist') }}"
                class="nav-item {{ $currentRoute === 'user.wishlist' ? 'active' : '' }}">
                <i class="fas fa-heart nav-icon"></i> Wishlist
            </a>
        </div>

        {{-- Akun --}}
        <div class="nav-group">
            <div class="nav-group-label">Akun</div>
            <a href="{{ route('user.notifications') }}"
                class="nav-item {{ $currentRoute === 'user.notifications' ? 'active' : '' }}">
                <i class="fas fa-bell nav-icon"></i> Notifikasi
                @if ($unreadNotif > 0)
                    <span class="nav-badge">{{ $unreadNotif > 9 ? '9+' : $unreadNotif }}</span>
                @endif
            </a>
            <a href="{{ route('user.profile') }}"
                class="nav-item {{ $currentRoute === 'user.profile' ? 'active' : '' }}">
                <i class="fas fa-user-circle nav-icon"></i> Profil
            </a>
        </div>

        {{-- Jelajahi --}}
        <div class="nav-group">
            <div class="nav-group-label">Jelajahi</div>
            <a href="{{ url('/courses') }}" class="nav-item">
                <i class="fas fa-search nav-icon"></i> Cari Kursus
            </a>
            <a href="{{ url('/blog') }}" class="nav-item">
                <i class="fas fa-newspaper nav-icon"></i> Blog
            </a>
        </div>

    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('user.logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

</aside>
