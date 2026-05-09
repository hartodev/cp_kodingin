@extends('admin.layouts.app')

@section('title', 'Detail Enrollment')
@section('page_title', 'Detail Enrollment')

@section('content')

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-graduation-cap"></i> Detail Enrollment</div>

        {{-- User --}}
        <div
            style="display:flex;align-items:center;gap:1rem;padding:1.2rem;background:rgba(244,196,48,0.04);border-radius:12px;margin-bottom:1.5rem;">
            <div
                style="width:52px;height:52px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:1rem;flex-shrink:0;">
                {{ strtoupper(substr($enrollment->user->name, 0, 2)) }}
            </div>
            <div>
                <div style="font-weight:700;font-size:1rem;">{{ $enrollment->user->name }}</div>
                <div style="color:var(--text-muted);font-size:0.85rem;">{{ $enrollment->user->email }}</div>
            </div>
            <a href="{{ route('admin.users.show', $enrollment->user) }}" class="btn-secondary"
                style="margin-left:auto;font-size:0.8rem;padding:0.5rem 1rem;">
                <i class="fas fa-external-link-alt"></i> Lihat User
            </a>
        </div>

        {{-- Info Grid --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div
                    style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;">
                    Kursus</div>
                <div style="font-weight:600;">{{ $enrollment->course->title ?? '-' }}</div>
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div
                    style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;">
                    Status Akses</div>
                @if($enrollment->have_access)
                <span class="status active">Aktif</span>
                @else
                <span class="status inactive">Dicabut</span>
                @endif
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div
                    style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;">
                    Tanggal Enrollment</div>
                <div style="font-weight:600;">{{ $enrollment->enrolled_at?->format('d M Y H:i') ?? '-' }}</div>
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div
                    style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.4rem;">
                    Invoice Order</div>
                <div style="font-weight:600;">{{ $enrollment->order->invoice_id ?? '-' }}</div>
            </div>
        </div>

        {{-- Aksi --}}
        <div style="display:flex;gap:1rem;">
            <form method="POST" action="{{ route('admin.enrollments.toggleAccess', $enrollment) }}">
                @csrf @method('PATCH')
                <button type="submit" class="{{ $enrollment->have_access ? 'btn-danger' : 'btn-primary' }}"
                    data-confirm="{{ $enrollment->have_access ? 'Yakin ingin mencabut akses?' : 'Yakin ingin membuka akses?' }}">
                    <i class="fas {{ $enrollment->have_access ? 'fa-ban' : 'fa-check' }}"></i>
                    {{ $enrollment->have_access ? 'Cabut Akses' : 'Buka Akses' }}
                </button>
            </form>
            <a href="{{ route('admin.enrollments.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection