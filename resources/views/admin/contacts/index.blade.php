@extends('admin.layouts.app')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')

@section('content')

@if($unreadCount > 0)
    <div class="alert alert-info" style="margin-bottom:1.5rem;">
        <i class="fas fa-envelope"></i>
        <strong>{{ $unreadCount }} pesan</strong> belum dibaca.
    </div>
@endif

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.contacts.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control"
                placeholder="Cari nama, email, atau subjek..." value="{{ request('search') }}"
                style="max-width:280px;">
            <select name="is_read" class="form-control" style="max-width:160px;">
                <option value="">Semua Status</option>
                <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','is_read']))
                <a href="{{ route('admin.contacts.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-envelope"></i></div>
            Semua Pesan
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $contacts->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengirim</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr style="{{ ! $contact->is_read ? 'background:rgba(244,196,48,0.03);' : '' }}">
                        <td style="color:var(--text-muted);">{{ $contacts->firstItem() + $loop->index }}</td>
                        <td>
                            <div style="font-weight:{{ $contact->is_read ? '500' : '700' }};">
                                {{ $contact->name }}
                                @if(! $contact->is_read)
                                    <span style="width:7px;height:7px;background:#EF4444;border-radius:50%;display:inline-block;margin-left:4px;vertical-align:middle;"></span>
                                @endif
                            </div>
                            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $contact->email }}</div>
                        </td>
                        <td style="font-size:0.85rem;">{{ $contact->subject ?? '-' }}</td>
                        <td style="font-size:0.85rem;color:var(--text-muted);max-width:200px;">
                            {{ Str::limit($contact->message, 60) }}
                        </td>
                        <td>
                            @if($contact->is_read)
                                <span class="status active">Dibaca</span>
                            @else
                                <span class="status pending">Baru</span>
                            @endif
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">
                            {{ $contact->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="action-btn" title="Baca">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(! $contact->is_read)
                                <form method="POST" action="{{ route('admin.contacts.read', $contact) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="action-btn success" title="Tandai Dibaca">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus"
                                    data-confirm="Hapus pesan dari {{ $contact->name }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Tidak ada pesan masuk.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div class="pagination">{{ $contacts->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection
