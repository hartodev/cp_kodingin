@extends('admin.layouts.app')

@section('title', 'Manajemen Review')
@section('page_title', 'Manajemen Review')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.reviews.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama user..."
                value="{{ request('search') }}" style="max-width:240px;">
            <select name="rating" class="form-control" style="max-width:140px;">
                <option value="">Semua Rating</option>
                @for($r=5;$r>=1;$r--)
                <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>
                    {{ $r }} Bintang
                </option>
                @endfor
            </select>
            <select name="status" class="form-control" style="max-width:140px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Tampil</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Disembunyikan</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','rating','status']))
            <a href="{{ route('admin.reviews.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-star"></i></div>
            Semua Review
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $reviews->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Kursus</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td style="color:var(--text-muted);">{{ $reviews->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-weight:600;font-size:0.88rem;">{{ $review->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">
                            {{ $review->created_at->format('d M Y') }}</div>
                    </td>
                    <td
                        style="font-size:0.85rem;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $review->course->title ?? '-' }}
                    </td>
                    <td>
                        <div style="color:var(--gold-pure);font-size:0.85rem;white-space:nowrap;">
                            @for($i=1;$i<=5;$i++) <i class="fas fa-star"
                                style="{{ $i <= $review->rating ? '' : 'opacity:0.2;' }}"></i>
                                @endfor
                        </div>
                    </td>
                    <td style="font-size:0.85rem;max-width:220px;">
                        {{ Str::limit($review->review, 60) }}
                    </td>
                    <td>
                        @if($review->status)
                        <span class="status active">Tampil</span>
                        @else
                        <span class="status inactive">Hidden</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}"
                            style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn {{ $review->status ? 'danger' : 'success' }}"
                                title="{{ $review->status ? 'Sembunyikan' : 'Tampilkan' }}">
                                <i class="fas {{ $review->status ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Yakin ingin menghapus review ini?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <p>Belum ada review.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="pagination">{{ $reviews->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection