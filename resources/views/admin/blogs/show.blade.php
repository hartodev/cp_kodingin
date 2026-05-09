@extends('admin.layouts.app')

@section('title', $blog->title)
@section('page_title', 'Detail Blog')

@section('content')

<div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

    {{-- Kiri: Konten Blog --}}
    <div>
        <div class="card" style="margin-bottom:1.5rem;">
            {{-- Cover --}}
            @if($blog->image)
            <img src="{{ asset('storage/'.$blog->image) }}"
                style="width:100%;border-radius:12px;margin-bottom:1.5rem;max-height:300px;object-fit:cover;border:1px solid rgba(244,196,48,0.15);">
            @endif

            {{-- Meta --}}
            <div style="display:flex;align-items:center;gap:0.8rem;margin-bottom:1rem;flex-wrap:wrap;">
                @if($blog->status)
                <span class="status active">Publish</span>
                @else
                <span class="status draft">Draft</span>
                @endif
                @if($blog->category)
                <span
                    style="font-size:0.78rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 10px;border-radius:20px;">
                    {{ $blog->category->name }}
                </span>
                @endif
                <span style="font-size:0.78rem;color:var(--text-muted);">
                    <i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $blog->created_at->format('d M Y') }}
                </span>
            </div>

            <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:1rem;line-height:1.4;">{{ $blog->title }}</h2>

            <div style="font-size:0.9rem;color:var(--text-muted);line-height:1.8;white-space:pre-line;">
                {{ $blog->description }}
            </div>
        </div>

        {{-- Komentar --}}
        <div class="data-section">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-comments"></i></div>
                    Komentar ({{ $blog->comments->count() }})
                </div>
                <a href="{{ route('admin.blog-comments.index') }}" class="btn-secondary"
                    style="font-size:0.8rem;padding:0.5rem 1rem;">
                    Kelola Semua
                </a>
            </div>
            @forelse($blog->comments as $comment)
            <div style="padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                    <span style="font-weight:600;font-size:0.88rem;">{{ $comment->user->name ?? '-' }}</span>
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <span
                            style="font-size:0.75rem;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                        @if(!$comment->status)
                        <span class="status inactive" style="font-size:0.7rem;">Hidden</span>
                        @endif
                    </div>
                </div>
                <div style="font-size:0.85rem;color:var(--text-muted);">{{ $comment->comment }}</div>
            </div>
            @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-comments"></i>
                <p>Belum ada komentar</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Kanan --}}
    <div>
        <div class="card">
            <div class="card-header"><i class="fas fa-cog"></i> Aksi</div>
            <div style="display:flex;flex-direction:column;gap:0.6rem;">
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-primary"
                    style="width:100%;justify-content:center;">
                    <i class="fas fa-edit"></i> Edit Blog
                </a>
                <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="width:100%;justify-content:center;"
                        data-confirm="Yakin ingin menghapus blog ini?">
                        <i class="fas fa-trash"></i> Hapus Blog
                    </button>
                </form>
                <a href="{{ route('admin.blogs.index') }}" class="btn-secondary"
                    style="width:100%;justify-content:center;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if($blog->seo_description)
        <div class="card" style="margin-top:1.5rem;">
            <div class="card-header"><i class="fas fa-search"></i> SEO</div>
            <div style="font-size:0.85rem;color:var(--text-muted);">{{ $blog->seo_description }}</div>
        </div>
        @endif
    </div>

</div>

@endsection