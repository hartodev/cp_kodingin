<div class="main-header">

    {{-- Kiri: toggle + judul halaman --}}
    <div style="display:flex; align-items:center; gap:1rem;">
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="header-left">
            <h1>@yield('page_title', 'Dashboard')</h1>
        </div>
    </div>

    {{-- Kanan: search + notif + profil --}}
    <div class="header-right">

        {{-- Search --}}
        <input type="text" class="search-bar" placeholder="Cari kursus, user...">

        {{-- Notifikasi --}}
        <button class="notif-btn" title="Notifikasi">
            <i class="fas fa-bell"></i>
            @php $notifCount = \App\Models\YoutubeVerification::where('status','pending')->count() + \App\Models\Contact::where('is_read',false)->count(); @endphp
            @if ($notifCount > 0)
                <span class="notif-badge">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
            @endif
        </button>

        {{-- User profile --}}
        <div class="user-profile">
            <div class="user-avatar">
                @if (auth()->user()->image && auth()->user()->image !== '/default-files/avatar.png')
                    <img src="{{ asset(auth()->user()->image) }}" alt="{{ auth()->user()->name }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                @endif
            </div>
            <span style="font-weight:500; font-size:0.9rem;">{{ auth()->user()->name }}</span>
            <i class="fas fa-chevron-down" style="font-size:0.8rem; color:var(--text-muted);"></i>
        </div>

    </div>
</div>
