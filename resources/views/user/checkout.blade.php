@extends('user.layouts.app')
@section('title', 'Checkout — ' . $order->invoice_id)
@section('page_title', 'Checkout')

@section('content')

    <div style="max-width:720px;">

        {{-- Status Badge --}}
        <div style="margin-bottom:1.5rem;">
            @if ($order->status === 'pending')
                <div class="alert alert-info">
                    <i class="fas fa-info-circle" style="flex-shrink:0;"></i>
                    <span>Order berhasil dibuat! Sekarang kamu perlu submit bukti subscribe YouTube untuk mendapat akses
                        kursus.</span>
                </div>
            @elseif($order->status === 'waiting_verification')
                <div class="alert"
                    style="background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.3);color:#60A5FA;">
                    <i class="fas fa-clock" style="flex-shrink:0;"></i>
                    <span>Bukti subscribe sudah dikirim. Menunggu verifikasi admin (maks. 1x24 jam).</span>
                </div>
            @elseif($order->status === 'verified')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="flex-shrink:0;"></i>
                    <span>Verifikasi disetujui! Kamu sudah punya akses ke semua kursus dalam order ini.</span>
                </div>
            @endif
        </div>

        {{-- Info Order --}}
        <div class="dash-card" style="margin-bottom:1.5rem;">
            <div style="font-weight:700;margin-bottom:1rem;font-size:1rem;">
                <i class="fas fa-receipt" style="color:var(--gold);margin-right:0.5rem;"></i>
                Order {{ $order->invoice_id }}
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.2rem;">
                <div style="padding:0.8rem;background:rgba(255,255,255,0.03);border-radius:10px;">
                    <div
                        style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.2rem;">
                        Status</div>
                    @php
                        $statusMap = [
                            'pending' => ['badge-orange', 'Pending'],
                            'waiting_verification' => ['badge-blue', 'Menunggu Verifikasi'],
                            'verified' => ['badge-green', 'Verified'],
                            'failed' => ['badge-red', 'Gagal'],
                            'cancelled' => ['badge-red', 'Dibatalkan'],
                        ];
                        [$badgeClass, $statusLabel] = $statusMap[$order->status] ?? ['badge-orange', 'Pending'];
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                </div>
                <div style="padding:0.8rem;background:rgba(255,255,255,0.03);border-radius:10px;">
                    <div
                        style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.2rem;">
                        Tanggal</div>
                    <div style="font-weight:600;font-size:0.88rem;">{{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>

            <div
                style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:0.8rem;">
                Kursus dalam Order</div>
            @foreach ($order->items as $item)
                <div
                    style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem;background:rgba(255,255,255,0.03);border-radius:10px;margin-bottom:0.5rem;">
                    <i class="fas fa-book" style="color:var(--gold);flex-shrink:0;"></i>
                    <span style="font-size:0.88rem;">{{ $item->course_title }}</span>
                    @if ($item->course && $order->status === 'verified')
                        <a href="{{ route('user.learn', $item->course) }}" class="btn-primary"
                            style="margin-left:auto;font-size:0.75rem;padding:0.35rem 0.9rem;">
                            <i class="fas fa-play"></i> Mulai
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Form Verifikasi YouTube --}}
        @if ($order->status === 'pending' && !$order->youtubeVerification)
            <div class="dash-card">
                <div style="font-weight:700;margin-bottom:0.5rem;font-size:1rem;">
                    <i class="fab fa-youtube" style="color:#EF4444;margin-right:0.5rem;"></i>
                    Submit Bukti Subscribe YouTube
                </div>
                <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1.5rem;">
                    Subscribe channel YouTube kami lalu upload screenshot sebagai bukti untuk mendapat akses kursus gratis.
                </p>

                @if ($youtubeSetting)
                    <a href="{{ $youtubeSetting }}" target="_blank" class="btn-primary"
                        style="margin-bottom:1.5rem;display:inline-flex;">
                        <i class="fab fa-youtube"></i> Subscribe Channel Kami
                    </a>
                @endif

                <form method="POST" action="{{ route('user.verification.submit', $order) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Channel YouTube <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="youtube_channel_name"
                            class="form-control @error('youtube_channel_name') is-invalid @enderror"
                            placeholder="Contoh: Channel Aku" value="{{ old('youtube_channel_name') }}">
                        @error('youtube_channel_name')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">URL Channel YouTube <span style="color:#EF4444;">*</span></label>
                        <input type="url" name="youtube_channel_url"
                            class="form-control @error('youtube_channel_url') is-invalid @enderror"
                            placeholder="https://youtube.com/@channelkamu" value="{{ old('youtube_channel_url') }}">
                        @error('youtube_channel_url')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Screenshot Bukti Subscribe <span style="color:#EF4444;">*</span></label>
                        <input type="file" name="proof_image"
                            class="form-control @error('proof_image') is-invalid @enderror" accept="image/*"
                            onchange="previewProof(this)">
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">Format: JPG, PNG, WEBP.
                            Maks 3MB</div>
                        <img id="proofPreview" src=""
                            style="display:none;max-width:100%;border-radius:10px;margin-top:0.8rem;border:1px solid rgba(244,196,48,0.2);">
                        @error('proof_image')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Bukti Verifikasi
                    </button>
                </form>
            </div>
        @elseif($order->youtubeVerification)
            <div class="dash-card">
                <div style="font-weight:700;margin-bottom:1rem;"><i class="fab fa-youtube"
                        style="color:#EF4444;margin-right:0.5rem;"></i>Status Verifikasi</div>
                <div style="padding:1rem;background:rgba(255,255,255,0.03);border-radius:10px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                        <span style="font-size:0.85rem;color:var(--text-muted);">Channel</span>
                        <span
                            style="font-weight:600;font-size:0.88rem;">{{ $order->youtubeVerification->youtube_channel_name }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:0.85rem;color:var(--text-muted);">Status</span>
                        @if ($order->youtubeVerification->status === 'approved')
                            <span class="badge badge-green">Disetujui</span>
                        @elseif($order->youtubeVerification->status === 'rejected')
                            <span class="badge badge-red">Ditolak</span>
                        @else
                            <span class="badge badge-orange">Menunggu Review</span>
                        @endif
                    </div>
                    @if ($order->youtubeVerification->admin_note)
                        <div
                            style="margin-top:0.8rem;padding:0.7rem;background:rgba(244,196,48,0.06);border-radius:8px;font-size:0.82rem;color:var(--text-muted);">
                            <strong>Catatan Admin:</strong> {{ $order->youtubeVerification->admin_note }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>

@endsection

@push('scripts')
    <script>
        function previewProof(input) {
            if (input.files && input.files[0]) {
                const r = new FileReader();
                r.onload = e => {
                    const el = document.getElementById('proofPreview');
                    el.src = e.target.result;
                    el.style.display = 'block';
                };
                r.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
