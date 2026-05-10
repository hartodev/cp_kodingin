@extends('admin.layouts.app')

@section('title', 'Detail Verifikasi YouTube')
@section('page_title', 'Detail Verifikasi YouTube')

@section('content')

<div style="max-width:760px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">

        {{-- Info User --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-user"></i> Info User</div>
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.2rem;">
                <div
                    style="width:50px;height:50px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:0.95rem;flex-shrink:0;">
                    {{ strtoupper(substr($verification->user->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-weight:700;">{{ $verification->user->name }}</div>
                    <div style="font-size:0.83rem;color:var(--text-muted);">{{ $verification->user->email }}</div>
                </div>
            </div>
            <a href="{{ route('admin.users.show', $verification->user) }}" class="btn-secondary"
                style="font-size:0.8rem;width:100%;justify-content:center;">
                <i class="fas fa-external-link-alt"></i> Lihat Profil User
            </a>
        </div>

        {{-- Info Channel --}}
        <div class="card">
            <div class="card-header"><i class="fab fa-youtube" style="color:#EF4444;"></i> Channel YouTube</div>
            <div style="margin-bottom:0.8rem;">
                <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.3rem;">Nama Channel</div>
                <div style="font-weight:600;">{{ $verification->youtube_channel_name ?? '-' }}</div>
            </div>
            @if($verification->youtube_channel_url)
            <a href="{{ $verification->youtube_channel_url }}" target="_blank" class="btn-secondary"
                style="font-size:0.8rem;width:100%;justify-content:center;">
                <i class="fab fa-youtube"></i> Buka Channel di YouTube
            </a>
            @endif
        </div>
    </div>

    {{-- Bukti Screenshot --}}
    @if($verification->proof_image)
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header"><i class="fas fa-image"></i> Bukti Screenshot Subscribe</div>
        <img src="{{ asset('storage/' . $verification->proof_image) }}" alt="Bukti Subscribe"
            style="width:100%;border-radius:12px;border:1px solid rgba(244,196,48,0.15);">
    </div>
    @endif

    {{-- Kursus dalam Order --}}
    <div class="data-section" style="margin-bottom:1.5rem;">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-shopping-cart"></i></div>
                Kursus dalam Order {{ $verification->order->invoice_id ?? '' }}
            </div>
            <span
                class="status {{ $verification->order->status === 'verified' ? 'verified' : ($verification->order->status === 'waiting_verification' ? 'waiting' : $verification->order->status) }}">
                {{ ucfirst(str_replace('_', ' ', $verification->order->status ?? '')) }}
            </span>
        </div>
        @foreach($verification->order->items ?? [] as $item)
        <div style="padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);font-weight:500;">
            <i class="fas fa-book" style="color:var(--gold-pure);margin-right:0.5rem;"></i>
            {{ $item->course_title }}
        </div>
        @endforeach
    </div>

    {{-- Status & Aksi --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-check-circle"></i> Keputusan Verifikasi</div>

        @if($verification->status === 'pending')
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

            {{-- Approve --}}
            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Catatan (opsional)</label>
                    <textarea name="admin_note" class="form-control" rows="3"
                        placeholder="Catatan untuk user..."></textarea>
                </div>
                <button type="submit" class="btn-primary" style="width:100%;"
                    data-confirm="Approve verifikasi ini? Akses kursus akan dibuka otomatis untuk user.">
                    <i class="fas fa-check"></i> Approve — Buka Akses Kursus
                </button>
            </form>

            {{-- Reject --}}
            <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Alasan Penolakan <span style="color:#EF4444;">*</span></label>
                    <textarea name="admin_note" class="form-control @error('admin_note') is-invalid @enderror" rows="3"
                        placeholder="Jelaskan alasan penolakan..." required></textarea>
                    @error('admin_note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn-danger" style="width:100%;"
                    data-confirm="Tolak verifikasi ini? User akan mendapat notifikasi.">
                    <i class="fas fa-times"></i> Tolak Verifikasi
                </button>
            </form>

        </div>

        @else
        {{-- Sudah diproses --}}
        <div style="text-align:center;padding:1.5rem;">
            @if($verification->status === 'approved')
            <i class="fas fa-check-circle"
                style="font-size:2.5rem;color:#10B981;margin-bottom:0.8rem;display:block;"></i>
            <div style="font-weight:700;color:#10B981;font-size:1.1rem;">Verifikasi Disetujui</div>
            @else
            <i class="fas fa-times-circle"
                style="font-size:2.5rem;color:#EF4444;margin-bottom:0.8rem;display:block;"></i>
            <div style="font-weight:700;color:#EF4444;font-size:1.1rem;">Verifikasi Ditolak</div>
            @endif

            @if($verification->admin_note)
            <div
                style="margin-top:0.8rem;padding:0.8rem;background:rgba(244,196,48,0.06);border-radius:10px;font-size:0.88rem;color:var(--text-muted);">
                {{ $verification->admin_note }}
            </div>
            @endif

            @if($verification->verifiedBy)
            <div style="margin-top:0.8rem;font-size:0.8rem;color:var(--text-muted);">
                Diproses oleh <strong>{{ $verification->verifiedBy->name }}</strong>
                {{-- pada {{ $verification->verified_at?->format('d M Y H:i') }} --}}
                pada {{ $verification->verified_at ? \Carbon\Carbon::parse($verification->verified_at)->format('d M Y H:i') : '-' }}

            </div>
            @endif
        </div>
        @endif

        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(244,196,48,0.1);">
            <a href="{{ route('admin.verifications.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

</div>

@endsection
