<div class="sidebar" id="sidebar">

    {{-- Logo --}}
    <div class="logo-section">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <div class="logo-icon">🚀</div>
            <span class="logo-text">PanduanFlow</span>
        </a>
    </div>

    {{-- DASHBOARD --}}
    <div class="menu-group">
        <div class="menu-title">Dashboard</div>
        <a href="{{ route('admin.dashboard') }}"
            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line menu-icon"></i>
            <span>Overview</span>
        </a>
    </div>

    {{-- KURSUS --}}
    <div class="menu-group">
        <div class="menu-title">Kursus</div>
        <a href="{{ route('admin.courses.index') }}"
            class="menu-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <i class="fas fa-book menu-icon"></i>
            <span>Semua Kursus</span>
        </a>
        <a href="{{ route('admin.categories.index') }}"
            class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags menu-icon"></i>
            <span>Kategori</span>
        </a>
        <a href="{{ route('admin.levels.index') }}"
            class="menu-item {{ request()->routeIs('admin.levels.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group menu-icon"></i>
            <span>Level</span>
        </a>
        <a href="{{ route('admin.tags.index') }}"
            class="menu-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
            <i class="fas fa-hashtag menu-icon"></i>
            <span>Tags</span>
        </a>
    </div>

    {{-- USER & ENROLLMENT --}}
    <div class="menu-group">
        <div class="menu-title">User & Enrollment</div>
        <a href="{{ route('admin.users.index') }}"
            class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users menu-icon"></i>
            <span>Semua User</span>
        </a>
        <a href="{{ route('admin.enrollments.index') }}"
            class="menu-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
            <i class="fas fa-graduation-cap menu-icon"></i>
            <span>Enrollment</span>
        </a>
        <a href="{{ route('admin.verifications.index') }}"
            class="menu-item {{ request()->routeIs('admin.verifications.*') ? 'active' : '' }}">
            <i class="fab fa-youtube menu-icon"></i>
            <span>
                Verifikasi YouTube
                @php $pendingCount = \App\Models\YoutubeVerification::where('status','pending')->count(); @endphp
                @if ($pendingCount > 0)
                    <span
                        style="background:#EF4444;color:#fff;border-radius:20px;padding:1px 7px;font-size:0.7rem;margin-left:4px;">{{ $pendingCount }}</span>
                @endif
            </span>
        </a>
        <a href="{{ route('admin.orders.index') }}"
            class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart menu-icon"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.reviews.index') }}"
            class="menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star menu-icon"></i>
            <span>Reviews</span>
        </a>
    </div>

    {{-- BLOG & PANDUAN --}}
    <div class="menu-group">
        <div class="menu-title">Blog & Panduan</div>
        <a href="{{ route('admin.blogs.index') }}"
            class="menu-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper menu-icon"></i>
            <span>Semua Blog</span>
        </a>
        <a href="{{ route('admin.blog-categories.index') }}"
            class="menu-item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
            <i class="fas fa-folder menu-icon"></i>
            <span>Kategori Blog</span>
        </a>
        <a href="{{ route('admin.blog-comments.index') }}"
            class="menu-item {{ request()->routeIs('admin.blog-comments.*') ? 'active' : '' }}">
            <i class="fas fa-comments menu-icon"></i>
            <span>Komentar Blog</span>
        </a>
    </div>

    {{-- KONTEN HALAMAN --}}
    <div class="menu-group">
        <div class="menu-title">Konten Halaman</div>
        <a href="{{ route('admin.portfolios.index') }}"
            class="menu-item {{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
            <i class="fas fa-briefcase menu-icon"></i>
            <span>Portfolio</span>
        </a>
        <a href="{{ route('admin.testimonials.index') }}"
            class="menu-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
            <i class="fas fa-quote-left menu-icon"></i>
            <span>Testimoni</span>
        </a>
        <a href="{{ route('admin.faqs.index') }}"
            class="menu-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle menu-icon"></i>
            <span>FAQ</span>
        </a>
        <a href="{{ route('admin.banners.index') }}"
            class="menu-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-images menu-icon"></i>
            <span>Banner</span>
        </a>
        <a href="{{ route('admin.social-links.index') }}"
            class="menu-item {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
            <i class="fas fa-share-alt menu-icon"></i>
            <span>Social Links</span>
        </a>
    </div>

    {{-- PESAN & NEWSLETTER --}}
    <div class="menu-group">
        <div class="menu-title">Pesan Masuk</div>
        <a href="{{ route('admin.contacts.index') }}"
            class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <i class="fas fa-envelope menu-icon"></i>
            <span>
                Pesan Masuk
                @php $unreadCount = \App\Models\Contact::where('is_read', false)->count(); @endphp
                @if ($unreadCount > 0)
                    <span
                        style="background:#EF4444;color:#fff;border-radius:20px;padding:1px 7px;font-size:0.7rem;margin-left:4px;">{{ $unreadCount }}</span>
                @endif
            </span>
        </a>
        <a href="{{ route('admin.newsletters.index') }}"
            class="menu-item {{ request()->routeIs('admin.newsletters.*') ? 'active' : '' }}">
            <i class="fas fa-paper-plane menu-icon"></i>
            <span>Newsletter</span>
        </a>
    </div>

    {{-- DISKUSI --}}
    <div class="menu-group">
        <div class="menu-title">Diskusi</div>
        <a href="{{ route('admin.discussions.index') }}"
            class="menu-item {{ request()->routeIs('admin.discussions.*') ? 'active' : '' }}">
            <i class="fas fa-comments menu-icon"></i>
            <span>Forum Diskusi</span>
        </a>
    </div>

    {{-- SETTINGS --}}
    <div class="menu-group">
        <div class="menu-title">Settings</div>
        <a href="{{ route('admin.settings.index') }}"
            class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog menu-icon"></i>
            <span>Pengaturan</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="menu-item"
                style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</div>
