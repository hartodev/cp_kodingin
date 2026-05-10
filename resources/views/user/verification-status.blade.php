@extends('user.layouts.app')
@section('title', 'Status Verifikasi')
@section('page_title', 'Status Verifikasi')

@section('content')

    <div style="max-width:680px;">
        <div class="dash-card">
            <div style="font-weight:700;margin-bottom:1rem;font-size:1rem;">
                <i class="fab fa-youtube" style="color:#EF4444;margin-right:0.5rem;"></i>
                Status Verifikasi — {{ $order->invoice_id }}
            </div>

            {{-- Status --}}
            @if ($order->status === 'pending')
                <div class="alert alert-info"><i class="fas fa-info-circle"></i> Belum ada bukti yang dikirim.</div>
            @elseif($order->status === 'waiting_verification')
                <div class="alert"
                    style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.3);color:#60A5FA;">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Bukti sudah dikirim. Menunggu review admin (maks. 1x24 jam).</span>
                </div>
            @elseif($order->status === 'verified')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Verifikasi disetujui! Akses kursus sudah dibuka.</span>
                </div>
            @elseif($order->status === 'failed')
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i>
                    <span>Verifikasi ditolak. Silakan kirim ulang bukti subscribe.</span>
                </div>
            @endif

            {{-- Kursus --}}
            <div style="margin-bottom:1.5rem;">
                <div
                    style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:0.8rem;">
                    Kursus</div>
                @foreach ($order->items as $item)
                    <div
                        style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem;background:rgba(255,255,255,0.03);border-radius:10px;margin-bottom:0.4rem;">
                        <i class="fas fa-book" style="color:var(--gold);"></i>
                        <span style="font-size:0.88rem;">{{ $item->course_title }}</span>
                        @if ($order->status === 'verified' && $item->course)
                            <a href="{{ route('user.learn', $item->course) }}" class="btn-primary"
                                style="margin-left:auto;font-size:0.75rem;padding:0.35rem 0.8rem;">
                                Belajar
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Info Verifikasi --}}
            @if ($order->youtubeVerification)
                <div style="padding:1rem;background:rgba(255,255,255,0.03);border-radius:10px;margin-bottom:1rem;">
                    <div
                        style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:0.8rem;">
                        Detail Verifikasi</div>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.85rem;">
                        <div style="display:flex;justify-content:space-between;">
                            <span style="color:var(--text-muted);">Channel</span>
                            <span style="font-weight:600;">{{ $order->youtubeVerification->youtube_channel_name }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="color:var(--text-muted);">Dikirim</span>
                            <span>{{ $order->youtubeVerification->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                    @if ($order->youtubeVerification->proof_image)
                        <img src="{{ asset('storage/' . $order->youtubeVerification->proof_image) }}"
                            style="width:100%;border-radius:8px;margin-top:0.8rem;border:1px solid rgba(244,196,48,0.15);">
                    @endif
                    @if ($order->youtubeVerification->admin_note)
                        <div
                            style="margin-top:0.8rem;padding:0.7rem;background:rgba(244,196,48,0.06);border-radius:8px;font-size:0.82rem;color:var(--text-muted);">
                            <strong>Catatan Admin:</strong> {{ $order->youtubeVerification->admin_note }}
                        </div>
                    @endif
                </div>
            @endif

            {{-- Tombol --}}
            <div style="display:flex;gap:0.8rem;flex-wrap:wrap;">
                @if ($order->status === 'pending')
                    <a href="{{ route('user.checkout.show', $order) }}" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Verifikasi
                    </a>
                @endif
                <a href="{{ route('user.dashboard') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

@endsection
