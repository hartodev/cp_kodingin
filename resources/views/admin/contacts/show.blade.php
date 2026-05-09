@extends('admin.layouts.app')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan')

@section('content')

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-envelope"></i> Pesan dari {{ $contact->name }}
        </div>

        {{-- Info Pengirim --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.3rem;">Nama</div>
                <div style="font-weight:600;">{{ $contact->name }}</div>
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.3rem;">Email</div>
                <a href="mailto:{{ $contact->email }}" style="font-weight:600;color:var(--gold-pure);text-decoration:none;">
                    {{ $contact->email }}
                </a>
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.3rem;">Subjek</div>
                <div style="font-weight:600;">{{ $contact->subject ?? '-' }}</div>
            </div>
            <div style="padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                <div style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.3rem;">Dikirim</div>
                <div style="font-weight:600;">{{ $contact->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        {{-- Isi Pesan --}}
        <div style="padding:1.5rem;background:rgba(244,196,48,0.04);border-radius:12px;border-left:4px solid var(--gold-pure);margin-bottom:1.5rem;">
            <div style="font-size:0.8rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:0.8rem;">Isi Pesan</div>
            <div style="line-height:1.8;white-space:pre-line;">{{ $contact->message }}</div>
        </div>

        {{-- Aksi --}}
        <div style="display:flex;gap:0.8rem;flex-wrap:wrap;">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn-primary">
                <i class="fas fa-reply"></i> Balas via Email
            </a>
            @if(! $contact->is_read)
                <form method="POST" action="{{ route('admin.contacts.read', $contact) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-check"></i> Tandai Dibaca
                    </button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" data-confirm="Hapus pesan ini?">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
            <a href="{{ route('admin.contacts.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
