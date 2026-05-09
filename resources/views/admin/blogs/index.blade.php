@extends('admin.layouts.app')

@section('title', 'Manajemen Blog')
@section('page_title', 'Manajemen Blog')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.blogs.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari judul blog..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="category" class="form-control" style="max-width:180px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
            <select name="status" class="form-control" style="max-width:140px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Publish</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('admin.blogs.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-newspaper"></i></div>
            Semua Blog
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $blogs->total() }})</span>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tulis Blog
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr>
                    <td style="color:var(--text-muted);">{{ $blogs->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.8rem;">
                            @if($blog->image)
                            <img src="{{ asset('storage/'.$blog->image) }}"
                                style="width:40px;height:40px;border-radius:8px;object-fit:cover;flex-shrink:0;">
                            @else
                            <div
                                style="width:40px;height:40px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--black-void);font-size:0.8rem;flex-shrink:0;">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            @endif
                            <div>
                                <div
                                    style="font-weight:600;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $blog->title }}
                                </div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">{{ $blog->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:0.85rem;color:var(--text-muted);">
                        {{ $blog->category->name ?? '-' }}
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--gold-pure);">{{ $blog->comments_count }}</span>
                    </td>
                    <td>
                        @if($blog->status)
                        <span class="status active">Publish</span>
                        @else
                        <span class="status draft">Draft</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $blog->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.blogs.show', $blog) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Hapus blog {{ $blog->title }}?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-newspaper"></i>
                            <p>Belum ada blog. <a href="{{ route('admin.blogs.create') }}"
                                    style="color:var(--gold-pure);">Tulis sekarang</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
    <div class="pagination">{{ $blogs->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection