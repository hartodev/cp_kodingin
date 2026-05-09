@extends('admin.layouts.app')

@section('title', 'Detail Order — ' . $order->invoice_id)
@section('page_title', 'Detail Order')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    {{-- Kiri --}}
    <div>
        {{-- Info Order --}}
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header">
                <i class="fas fa-shopping-cart"></i>
                Order {{ $order->invoice_id }}
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                @foreach([
                ['label'=>'Invoice ID', 'value'=> $order->invoice_id],
                ['label'=>'Status', 'value'=> ucfirst(str_replace('_',' ',$order->status))],
                ['label'=>'Tanggal Order', 'value'=> $order->created_at->format('d M Y H:i')],
                ['label'=>'Verifikasi', 'value'=> $order->verified_at?->format('d M Y H:i') ?? '-'],
                ] as $item)
                <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    <div
                        style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.3rem;">
                        {{ $item['label'] }}</div>
                    <div style="font-weight:600;">{{ $item['value'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Kursus dalam order --}}
            <div style="border-top:1px solid rgba(244,196,48,0.1);padding-top:1rem;">
                <div
                    style="font-size:0.8rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.8rem;">
                    Kursus</div>
                @foreach($order->items as $item)
                <div
                    style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem;background:rgba(244,196,48,0.04);border-radius:10px;margin-bottom:0.5rem;">
                    <i class="fas fa-book" style="color:var(--gold-pure);"></i>
                    <span>{{ $item->course_title }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Verifikasi YouTube --}}
        @if($order->youtubeVerification)
        <div class="card">
            <div class="card-header"><i class="fab fa-youtube" style="color:#EF4444;"></i> Verifikasi YouTube</div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:0.3rem;">Nama Channel</div>
                    <div style="font-weight:600;">{{ $order->youtubeVerification->youtube_channel_name ?? '-' }}</div>
                </div>
                <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:0.3rem;">Status</div>
                    @php $vs = $order->youtubeVerification->status; @endphp
                    <span
                        class="status {{ $vs === 'approved' ? 'verified' : ($vs === 'rejected' ? 'inactive' : 'pending') }}">
                        {{ ucfirst($vs) }}
                    </span>
                </div>
            </div>

            @if($order->youtubeVerification->proof_image)
            <img src="{{ asset('storage/'.$order->youtubeVerification->proof_image) }}"
                style="width:100%;border-radius:10px;border:1px solid rgba(244,196,48,0.15);margin-bottom:1rem;">
            @endif

            @if($order->youtubeVerification->admin_note)
            <div
                style="padding:0.8rem;background:rgba(244,196,48,0.06);border-radius:10px;font-size:0.85rem;color:var(--text-muted);">
                <strong>Catatan Admin:</strong> {{ $order->youtubeVerification->admin_note }}
            </div>
            @endif

            @if($order->youtubeVerification->verifiedBy)
            <div style="margin-top:0.8rem;font-size:0.8rem;color:var(--text-muted);">
                Diproses oleh <strong>{{ $order->youtubeVerification->verifiedBy->name }}</strong>
                pada {{ $order->youtubeVerification->verified_at?->format('d M Y H:i') }}
            </div>
            @endif

            @if($order->youtubeVerification->status === 'pending')
            <div
                style="display:flex;gap:0.8rem;margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(244,196,48,0.1);">
                <a href="{{ route('admin.verifications.show', $order->youtubeVerification) }}" class="btn-primary"
                    style="font-size:0.85rem;">
                    <i class="fas fa-check-circle"></i> Review & Approve/Reject
                </a>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- Kanan: Info User --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-user"></i> Info User</div>
        <div style="text-align:center;margin-bottom:1.2rem;">
            <div
                style="width:56px;height:56px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--black-void);font-size:1.1rem;margin:0 auto 0.8rem;">
                {{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}
            </div>
            <div style="font-weight:700;">{{ $order->user->name ?? '-' }}</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">{{ $order->user->email ?? '' }}</div>
        </div>
        <a href="{{ route('admin.users.show', $order->user) }}" class="btn-secondary"
            style="width:100%;justify-content:center;font-size:0.85rem;">
            <i class="fas fa-external-link-alt"></i> Lihat Profil User
        </a>

        <div style="margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid rgba(244,196,48,0.1);">
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary"
                style="width:100%;justify-content:center;font-size:0.85rem;">
                <i class="fas fa-arrow-left"></i> Kembali ke Orders
            </a>
        </div>
    </div>

</div>

@endsection