@extends('admin.layouts.app')

@section('title', 'Forum Diskusi')
@section('page_title', 'Forum Diskusi')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.discussions.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control"
                placeholder="Cari judul thread..." value="{{ request('search') }}"
                style="max-width:260px;">
            <select name="is_solved" class="form-control" style="max-width:160px;">
                <option value="">Semua Status</option>
                <option value="0" {{ request('is_solved') === '0' ? 'selected' : '' }}>Belum Terjawab</option>
                <option value="1" {{ request('is_solved') === '1' ? 'selected' : '' }}>Sudah Terjawab</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','is_solved']))
                <a href="{{ route('admin.discussions.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-comments"></i></div>
            Semua Thread Diskusi
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $threads->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Thread</th>
                    <th>User</th>
                    <th>Kursus</th>
                    <th>Balasan</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($threads as $thread)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $threads->firstItem() + $loop->index }}</td>
                        <td style="max-width:220px;">
                            <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $thread->title }}
                            </div>
                            @if($thread->lesson)
                                <div style="font-size:0.75rem;color:var(--text-muted);">
                                    <i class="fas fa-play-circle" style="margin-right:3px;"></i>{{ $thread->lesson->title }}
                                </div>
                            @endif
                        </td>
                        <td style="font-size:0.85rem;">{{ $thread->user->name ?? '-' }}</td>
                        <td style="font-size:0.82rem;color:var(--text-muted);max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $thread->course->title ?? '-' }}
                        </td>
                        <td>
                            <span style="font-weight:600;color:var(--gold-pure);">{{ $thread->replies_count }}</span>
                        </td>
                        <td>
                            @if($thread->is_solved)
                                <span class="status verified">Terjawab</span>
                            @else
                                <span class="status pending">Belum</span>
                            @endif
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">
                            {{ $thread->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <a href="{{ route('admin.discussions.show', $thread) }}" class="action-btn" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.discussions.destroy', $thread) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus"
                                    data-confirm="Hapus thread diskusi ini beserta semua balasannya?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <p>Belum ada diskusi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($threads->hasPages())
        <div class="pagination">{{ $threads->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection
