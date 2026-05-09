@extends('admin.layouts.app')

@section('title', 'Manajemen Enrollment')
@section('page_title', 'Manajemen Enrollment')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.enrollments.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email user..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="access" class="form-control" style="max-width:160px;">
                <option value="">Semua Akses</option>
                <option value="yes" {{ request('access') === 'yes' ? 'selected' : '' }}>Punya Akses</option>
                <option value="no" {{ request('access') === 'no'  ? 'selected' : '' }}>Dicabut</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','access']))
            <a href="{{ route('admin.enrollments.index') }}" class="btn-secondary"><i class="fas fa-times"></i>
                Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-graduation-cap"></i></div>
            Semua Enrollment
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $enrollments->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Kursus</th>
                    <th>Akses</th>
                    <th>Enrolled</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $enrollments->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $enrollment->user->name ?? '-' }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted);">{{ $enrollment->user->email ?? '' }}
                        </div>
                    </td>
                    <td>
                        <div
                            style="font-weight:500;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $enrollment->course->title ?? '-' }}
                        </div>
                    </td>
                    <td>
                        @if($enrollment->have_access)
                        <span class="status active">Aktif</span>
                        @else
                        <span class="status inactive">Dicabut</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $enrollment->enrolled_at?->format('d M Y') ?? '-' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.enrollments.toggleAccess', $enrollment) }}"
                            style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="action-btn {{ $enrollment->have_access ? 'danger' : 'success' }}"
                                title="{{ $enrollment->have_access ? 'Cabut Akses' : 'Buka Akses' }}"
                                data-confirm="{{ $enrollment->have_access ? 'Yakin ingin mencabut akses kursus ini?' : 'Yakin ingin membuka akses kursus ini?' }}">
                                <i class="fas {{ $enrollment->have_access ? 'fa-ban' : 'fa-check' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Yakin ingin menghapus enrollment ini?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-graduation-cap"></i>
                            <p>Belum ada enrollment.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($enrollments->hasPages())
    <div class="pagination">
        {{ $enrollments->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection