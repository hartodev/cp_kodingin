@extends('admin.layouts.app')

@section('title', 'Manajemen Kursus')
@section('page_title', 'Manajemen Kursus')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.courses.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari judul kursus..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="status" class="form-control" style="max-width:160px;">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="draft" {{ request('status') === 'draft'    ? 'selected' : '' }}>Draft</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <select name="category" class="form-control" style="max-width:180px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','status','category']))
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-book"></i></div>
            Semua Kursus
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $courses->total() }})</span>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Kursus
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kursus</th>
                    <th>Kategori</th>
                    <th>Level</th>
                    <th>Siswa</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $courses->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.8rem;">
                            @if($course->thumbnail)
                            <img src="{{ asset('storage/'.$course->thumbnail) }}"
                                style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                            @else
                            <div
                                style="width:44px;height:44px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--black-void);font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($course->title, 0, 2)) }}
                            </div>
                            @endif
                            <div>
                                <div
                                    style="font-weight:600;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $course->title }}
                                </div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">
                                    {{ $course->duration ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:0.85rem;color:var(--text-muted);">
                        {{ $course->category->name ?? '-' }}
                    </td>
                    <td style="font-size:0.85rem;color:var(--text-muted);">
                        {{ $course->level->name ?? '-' }}
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--gold-pure);">{{ $course->enrollments_count }}</span>
                    </td>
                    <td style="font-size:0.85rem;">
                        <i class="fas fa-star" style="color:var(--gold-pure);font-size:0.75rem;"></i>
                        {{ number_format($course->reviews_avg_rating ?? 0, 1) }}
                        <span style="color:var(--text-muted);">({{ $course->reviews_count }})</span>
                    </td>
                    <td>
                        <span class="status {{ $course->status }}">{{ ucfirst($course->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.courses.show', $course) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.courses.chapters.index', $course) }}" class="action-btn"
                            title="Chapters & Lessons">
                            <i class="fas fa-list"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Yakin ingin menghapus kursus {{ $course->title }}?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-book"></i>
                            <p>Belum ada kursus. <a href="{{ route('admin.courses.create') }}"
                                    style="color:var(--gold-pure);">Buat sekarang</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($courses->hasPages())
    <div class="pagination">
        {{ $courses->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection