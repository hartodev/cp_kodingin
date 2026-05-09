@extends('admin.layouts.app')

@section('title', 'Verifikasi YouTube')
@section('page_title', 'Verifikasi YouTube')

@section('content')

{{-- Stats bar --}}
@if($pendingCount > 0)
<div class="alert alert-warning" style="margin-bottom:1.5rem;">
    <i class="fab fa-youtube"></i>
    <strong>{{ $pendingCount }} verifikasi</strong> sedang menunggu review kamu.
</div>
@endif

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.verifications.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="status" class="form-control" style="max-width:180px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.verifications.index') }}" class="btn-secondary"><i class="fas fa-times"></i>
                Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fab fa-youtube"></i></div>
            Semua Verifikasi
            <span
                style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $verifications->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Channel YouTube</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Diajukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verifications as $verif)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $verifications->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $verif->user->name ?? '-' }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted);">{{ $verif->user->email ?? '' }}</div>
                    </td>
                    <td>
                        @if($verif->youtube_channel_url)
                        <a href="{{ $verif->youtube_channel_url }}" target="_blank"
                            style="color:var(--gold-pure);text-decoration:none;font-size:0.88rem;">
                            <i class="fab fa-youtube" style="margin-right:4px;"></i>
                            {{ $verif->youtube_channel_name ?? $verif->youtube_channel_url }}
                        </a>
                        @else
                        <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td style="font-size:0.85rem;">
                        {{ $verif->order->invoice_id ?? '-' }}
                    </td>
                    <td>
                        @if($verif->status === 'pending')
                        <span class="status pending">Pending</span>
                        @elseif($verif->status === 'approved')
                        <span class="status verified">Approved</span>
                        @else
                        <span class="status inactive">Rejected</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $verif->created_at->format('d M Y H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.verifications.show', $verif) }}" class="action-btn" title="Review">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($verif->status === 'pending')
                        <form method="POST" action="{{ route('admin.verifications.approve', $verif) }}"
                            style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn success" title="Approve"
                                data-confirm="Approve verifikasi ini? Akses kursus akan dibuka otomatis.">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fab fa-youtube"></i>
                            <p>Tidak ada verifikasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($verifications->hasPages())
    <div class="pagination">
        {{ $verifications->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection