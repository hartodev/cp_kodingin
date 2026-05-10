@extends('user.layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

    {{-- Welcome --}}
    <div style="margin-bottom:2rem;">
        <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.3rem;">
            Hai, {{ Str::limit(auth()->user()->name, 20) }}! 👋
        </h2>
        <p style="color:var(--text-muted);font-size:0.9rem;">Semangat belajar hari ini!</p>
    </div>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;margin-bottom:2rem;">
        <div class="stat-card">
            <i class="fas fa-book-open" style="color:var(--gold);font-size:1.3rem;margin-bottom:0.5rem;display:block;"></i>
            <div class="stat-number">{{ $stats['total_courses'] }}</div>
            <div class="stat-label">Kursus Diikuti</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-shopping-cart"
                style="color:var(--gold);font-size:1.3rem;margin-bottom:0.5rem;display:block;"></i>
            <div class="stat-number">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">Total Order</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-certificate"
                style="color:var(--gold);font-size:1.3rem;margin-bottom:0.5rem;display:block;"></i>
            <div class="stat-number">{{ $stats['total_cert'] }}</div>
            <div class="stat-label">Sertifikat</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-bell"
                style="color:{{ $stats['unread_notif'] > 0 ? '#EF4444' : 'var(--gold)' }};font-size:1.3rem;margin-bottom:0.5rem;display:block;"></i>
            <div class="stat-number"
                style="{{ $stats['unread_notif'] > 0 ? 'background:none;-webkit-text-fill-color:#EF4444;' : '' }}">
                {{ $stats['unread_notif'] }}</div>
            <div class="stat-label">Notif Belum Dibaca</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

        {{-- Kursus Aktif --}}
        <div class="dash-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;">
                <div style="font-weight:700;font-size:0.95rem;"><i class="fas fa-book-open"
                        style="color:var(--gold);margin-right:0.5rem;"></i>Kursus Saya</div>
                <a href="{{ route('user.my-courses') }}" class="btn-secondary"
                    style="font-size:0.78rem;padding:0.4rem 0.9rem;">Lihat Semua</a>
            </div>
            @forelse($enrollments as $enrollment)
                <a href="{{ route('user.learn', $enrollment->course) }}"
                    style="display:flex;gap:0.8rem;align-items:center;padding:0.8rem;border-radius:10px;background:rgba(255,255,255,0.03);margin-bottom:0.5rem;text-decoration:none;color:inherit;transition:background 0.2s;"
                    onmouseover="this.style.background='rgba(244,196,48,0.06)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                    <div
                        style="width:42px;height:42px;border-radius:10px;background:rgba(244,196,48,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                        @if ($enrollment->course->thumbnail)
                            <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fas fa-book" style="color:var(--gold);"></i>
                        @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div
                            style="font-size:0.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $enrollment->course->title }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">
                            {{ $enrollment->course->category->name ?? '-' }}</div>
                    </div>
                    <i class="fas fa-play-circle" style="color:var(--gold);flex-shrink:0;"></i>
                </a>
            @empty
                <div style="text-align:center;padding:2rem;color:var(--text-muted);">
                    <i class="fas fa-book" style="font-size:2rem;margin-bottom:0.5rem;display:block;opacity:0.3;"></i>
                    <p style="font-size:0.85rem;">Belum ada kursus.</p>
                    <a href="{{ url('/courses') }}" class="btn-primary"
                        style="font-size:0.82rem;padding:0.5rem 1rem;margin-top:0.8rem;">Cari Kursus</a>
                </div>
            @endforelse
        </div>

        {{-- Order Pending --}}
        <div class="dash-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;">
                <div style="font-weight:700;font-size:0.95rem;"><i class="fas fa-clock"
                        style="color:var(--gold);margin-right:0.5rem;"></i>Order Pending</div>
            </div>
            @forelse($pendingOrders as $order)
                <div
                    style="padding:0.9rem;border-radius:10px;background:rgba(255,255,255,0.03);margin-bottom:0.5rem;border:1px solid rgba(244,196,48,0.08);">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                        <span
                            style="font-size:0.82rem;font-weight:700;font-family:monospace;">{{ $order->invoice_id }}</span>
                        @if ($order->status === 'pending')
                            <span class="badge badge-orange">Pending</span>
                        @else
                            <span class="badge badge-blue">Menunggu Verifikasi</span>
                        @endif
                    </div>
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.7rem;">
                        {{ $order->items->count() }} kursus · {{ $order->created_at->diffForHumans() }}
                    </div>
                    @if ($order->status === 'pending')
                        <a href="{{ route('user.verification.status', $order) }}" class="btn-primary"
                            style="font-size:0.78rem;padding:0.4rem 0.9rem;">
                            <i class="fab fa-youtube"></i> Submit Verifikasi
                        </a>
                    @else
                        <a href="{{ route('user.verification.status', $order) }}" class="btn-secondary"
                            style="font-size:0.78rem;padding:0.4rem 0.9rem;">
                            Cek Status
                        </a>
                    @endif
                </div>
            @empty
                <div style="text-align:center;padding:2rem;color:var(--text-muted);">
                    <i class="fas fa-check-circle"
                        style="font-size:2rem;margin-bottom:0.5rem;display:block;color:rgba(16,185,129,0.4);"></i>
                    <p style="font-size:0.85rem;">Tidak ada order pending.</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- Notifikasi Terbaru --}}
    @if ($unreadNotifications->count())
        <div class="dash-card" style="margin-top:1.5rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;">
                <div style="font-weight:700;font-size:0.95rem;"><i class="fas fa-bell"
                        style="color:var(--gold);margin-right:0.5rem;"></i>Notifikasi Terbaru</div>
                <a href="{{ route('user.notifications') }}" class="btn-secondary"
                    style="font-size:0.78rem;padding:0.4rem 0.9rem;">Lihat Semua</a>
            </div>
            @foreach ($unreadNotifications as $notif)
                <div
                    style="display:flex;gap:0.8rem;align-items:flex-start;padding:0.8rem;border-radius:10px;background:rgba(244,196,48,0.04);border-left:3px solid var(--gold);margin-bottom:0.5rem;">
                    <i class="fas fa-bell" style="color:var(--gold);margin-top:2px;flex-shrink:0;"></i>
                    <div>
                        <div style="font-size:0.85rem;font-weight:600;margin-bottom:0.2rem;">
                            {{ $notif->title ?? 'Notifikasi' }}</div>
                        <div style="font-size:0.8rem;color:var(--text-muted);">{{ $notif->body ?? $notif->message }}</div>
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.3rem;">
                            {{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
