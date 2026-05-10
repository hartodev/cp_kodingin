@extends('user.layouts.app')
@section('title', 'Notifikasi')
@section('page_title', 'Notifikasi')

@section('content')

    <div style="max-width:700px;">
        @if ($notifications->count())
            <div class="dash-card">
                @foreach ($notifications as $notif)
                    <div
                        style="display:flex;gap:1rem;padding:1rem;border-bottom:1px solid rgba(244,196,48,0.05);{{ !$notif->is_read ? 'background:rgba(244,196,48,0.03);' : '' }}">
                        <div
                            style="width:40px;height:40px;border-radius:50%;background:{{ !$notif->is_read ? 'rgba(244,196,48,0.15)' : 'rgba(255,255,255,0.06)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--gold);">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div style="flex:1;">
                            <div
                                style="font-weight:{{ !$notif->is_read ? '700' : '500' }};font-size:0.88rem;margin-bottom:0.2rem;">
                                {{ $notif->title ?? 'Notifikasi' }}
                                @if (!$notif->is_read)
                                    <span
                                        style="width:6px;height:6px;background:#EF4444;border-radius:50%;display:inline-block;margin-left:5px;vertical-align:middle;"></span>
                                @endif
                            </div>
                            <div style="font-size:0.82rem;color:var(--text-muted);line-height:1.5;">
                                {{ $notif->body ?? $notif->message }}</div>
                            <div style="font-size:0.72rem;color:rgba(255,255,255,0.25);margin-top:0.3rem;">
                                {{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($notifications->hasPages())
                <div style="display:flex;justify-content:center;gap:0.5rem;margin-top:1.5rem;">
                    @if (!$notifications->onFirstPage())
                        <a href="{{ $notifications->previousPageUrl() }}" class="btn-secondary"
                            style="padding:0.5rem 1rem;font-size:0.85rem;">← Prev</a>
                    @endif
                    @if ($notifications->hasMorePages())
                        <a href="{{ $notifications->nextPageUrl() }}" class="btn-secondary"
                            style="padding:0.5rem 1rem;font-size:0.85rem;">Next →</a>
                    @endif
                </div>
            @endif
        @else
            <div style="text-align:center;padding:5rem 2rem;">
                <i class="fas fa-bell-slash"
                    style="font-size:4rem;color:rgba(244,196,48,0.2);margin-bottom:1rem;display:block;"></i>
                <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Tidak ada notifikasi</h3>
                <p style="color:var(--text-muted);">Semua notifikasi sudah terbaca.</p>
            </div>
        @endif
    </div>

@endsection
