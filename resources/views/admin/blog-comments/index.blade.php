@extends('admin.layouts.app')

@section('title', 'Komentar Blog')
@section('page_title', 'Komentar Blog')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.blog-comments.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari isi komentar..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="status" class="form-control" style="max-width:140px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Tampil</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Hidden</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.blog-comments.index') }}" class="btn-secondary"><i class="fas fa-times"></i>
                Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-comments"></i></div>
            Semua Komentar
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $comments->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Blog</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr>
                    <td style="color:var(--text-muted);">{{ $comments->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="font-weight:600;font-size:0.88rem;">{{ $comment->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $comment->user->email ?? '' }}</div>
                    </td>
                    <td
                        style="font-size:0.82rem;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-muted);">
                        {{ $comment->blog->title ?? '-' }}
                    </td>
                    <td style="font-size:0.85rem;max-width:220px;">
                        {{ Str::limit($comment->comment, 70) }}
                    </td>
                    <td>
                        @if($comment->status)
                        <span class="status active">Tampil</span>
                        @else
                        <span class="status inactive">Hidden</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.82rem;">
                        {{ $comment->created_at->diffForHumans() }}
                    </td>
                    <td>
                        {{-- Toggle: route pakai {comment} sesuai web.php --}}
                        <form method="POST" action="{{ route('admin.blog-comments.toggle', $comment) }}"
                            style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn {{ $comment->status ? 'danger' : 'success' }}"
                                title="{{ $comment->status ? 'Sembunyikan' : 'Tampilkan' }}">
                                <i class="fas {{ $comment->status ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.blog-comments.destroy', $comment) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Yakin ingin menghapus komentar ini?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <p>Belum ada komentar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($comments->hasPages())
    <div class="pagination">{{ $comments->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection