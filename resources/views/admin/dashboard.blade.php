@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-number">{{ number_format($stats['total_users']) }}</div>
        <div class="stat-label">Total User</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-number">{{ number_format($stats['total_courses']) }}</div>
        <div class="stat-label">Total Kursus</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
        <div class="stat-number">{{ number_format($stats['total_enrollments']) }}</div>
        <div class="stat-label">Total Enrollment</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fab fa-youtube"></i></div>
        <div class="stat-number" style="color: #EF4444;">{{ $stats['pending_verif'] }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-number">{{ number_format($stats['total_orders']) }}</div>
        <div class="stat-label">Total Order</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-star"></i></div>
        <div class="stat-number">{{ number_format($stats['total_reviews']) }}</div>
        <div class="stat-label">Total Review</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-envelope"></i></div>
        <div class="stat-number" style="color: #F59E0B;">{{ $stats['unread_contacts'] }}</div>
        <div class="stat-label">Pesan Belum Dibaca</div>
    </div>
</div>

{{-- Row: Pending Verifikasi + Latest Orders --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">

    {{-- Pending Verifikasi YouTube --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fab fa-youtube"></i></div>
                Menunggu Verifikasi
            </div>
            <a href="{{ route('admin.verifications.index') }}" class="btn-secondary"
                style="font-size:0.8rem; padding:0.5rem 1rem;">
                Lihat Semua
            </a>
        </div>
        @forelse($pendingVerifications as $verif)
        <div
            style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid rgba(244,196,48,0.05);">
            <div style="display:flex; align-items:center; gap:0.8rem;">
                <div
                    style="width:38px;height:38px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:0.8rem;">
                    {{ strtoupper(substr($verif->user->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-weight:600;font-size:0.9rem;">{{ $verif->user->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $verif->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.verifications.show', $verif) }}" class="btn-primary"
                style="font-size:0.75rem;padding:0.4rem 0.9rem;">
                Review
            </a>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem;">
            <i class="fas fa-check-circle" style="color:rgba(16,185,129,0.4);"></i>
            <p>Tidak ada verifikasi pending</p>
        </div>
        @endforelse
    </div>

    {{-- Latest Orders --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-shopping-cart"></i></div>
                Order Terbaru
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary"
                style="font-size:0.8rem; padding:0.5rem 1rem;">
                Lihat Semua
            </a>
        </div>
        @forelse($latestOrders as $order)
        <div
            style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid rgba(244,196,48,0.05);">
            <div>
                <div style="font-weight:600;font-size:0.9rem;">{{ $order->invoice_id }}</div>
                <div style="font-size:0.75rem;color:var(--text-muted);">{{ $order->user->name }} ·
                    {{ $order->created_at->diffForHumans() }}</div>
            </div>
            <span
                class="status {{ $order->status === 'verified' ? 'verified' : ($order->status === 'waiting_verification' ? 'waiting' : $order->status) }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem;">
            <i class="fas fa-inbox"></i>
            <p>Belum ada order</p>
        </div>
        @endforelse
    </div>

</div>

{{-- Row: Popular Courses + Latest Users --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

    {{-- Kursus Terpopuler --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-fire"></i></div>
                Kursus Terpopuler
            </div>
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary"
                style="font-size:0.8rem; padding:0.5rem 1rem;">
                Semua Kursus
            </a>
        </div>
        @forelse($popularCourses as $course)
        <div
            style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid rgba(244,196,48,0.05);">
            <div style="display:flex; align-items:center; gap:0.8rem; flex:1; min-width:0;">
                <div
                    style="width:38px;height:38px;background:var(--glass-dark);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-book" style="color:var(--gold-pure);font-size:0.85rem;"></i>
                </div>
                <div style="min-width:0;">
                    <div
                        style="font-weight:600;font-size:0.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $course->title }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $course->enrollments_count }} siswa</div>
                </div>
            </div>
            <span class="status {{ $course->status }}">{{ $course->status }}</span>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem;">
            <i class="fas fa-book"></i>
            <p>Belum ada kursus</p>
        </div>
        @endforelse
    </div>

    {{-- User Terbaru --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-user-plus"></i></div>
                User Terbaru
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary"
                style="font-size:0.8rem; padding:0.5rem 1rem;">
                Semua User
            </a>
        </div>
        @forelse($latestUsers as $user)
        <div
            style="display:flex; align-items:center; justify-content:space-between; padding:1rem 1.5rem; border-bottom:1px solid rgba(244,196,48,0.05);">
            <div style="display:flex; align-items:center; gap:0.8rem;">
                <div
                    style="width:38px;height:38px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:0.8rem;flex-shrink:0;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-weight:600;font-size:0.88rem;">{{ $user->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $user->email }}</div>
                </div>
            </div>
            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $user->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem;">
            <i class="fas fa-users"></i>
            <p>Belum ada user</p>
        </div>
        @endforelse
    </div>

</div>

@endsection