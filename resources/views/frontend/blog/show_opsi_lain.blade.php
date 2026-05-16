{{-- INI BISA DI GANTI DENGAN SHOW.BLADE.PHP TAMPILANNYA  --}}
@extends('frontend.layouts.app')

@section('title', $blog->title)
@section('meta_description', $blog->seo_description ?? Str::limit(strip_tags($blog->description), 155))

@section('content')

    <section class="blog-detail-section">
        <div class="blog-detail-container">
            <div class="blog-detail-grid">

                {{-- Konten Blog --}}
                <article>

                    {{-- Breadcrumb --}}
                    <div class="blog-breadcrumb">
                        <a href="{{ url('/blog') }}">Blog</a>
                        <span>/</span>

                        @if ($blog->category)
                            <a href="{{ url('/blog?category=' . $blog->category->slug) }}">
                                {{ $blog->category->name }}
                            </a>
                            <span>/</span>
                        @endif

                        <small>{{ Str::limit($blog->title, 45) }}</small>
                    </div>

                    {{-- Header --}}
                    <header class="blog-detail-header">
                        <div class="blog-detail-category">
                            {{ $blog->category->name ?? 'Blog' }}
                        </div>

                        <h1 class="blog-detail-title">
                            {{ $blog->title }}
                        </h1>

                        <p class="blog-detail-excerpt">
                            {{ $blog->seo_description ?? Str::limit(strip_tags($blog->description), 180) }}
                        </p>

                        <div class="blog-detail-meta">
                            <span>
                                <i class="fas fa-user"></i>
                                {{ $blog->user->name ?? '-' }}
                            </span>

                            <span>
                                <i class="fas fa-calendar"></i>
                                {{ $blog->created_at->format('d M Y') }}
                            </span>

                            <span>
                                <i class="fas fa-comments"></i>
                                {{ $blog->comments->count() }} komentar
                            </span>
                        </div>
                    </header>

                    {{-- Cover Image --}}
                    @if ($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                            class="blog-detail-cover">
                    @endif

                    {{-- Daftar Isi --}}
                    <div class="blog-toc">
                        <h3>Daftar Isi</h3>
                        <a href="#content">Mulai Pembahasan</a>
                        <a href="#comments">Komentar Pembaca</a>
                        <a href="#comment-form">Tulis Komentar</a>
                    </div>

                    {{-- Konten --}}
                    <div id="content" class="blog-detail-content">
                        {!! $blog->description !!}
                    </div>

                    {{-- Komentar --}}
                    <div id="comments" class="blog-comments">
                        <h3 class="blog-comments-title">
                            Komentar ({{ $blog->comments->count() }})
                        </h3>

                        @forelse($blog->comments as $comment)
                            <div class="blog-comment-card">
                                <div class="blog-comment-avatar">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 2)) }}
                                </div>

                                <div class="blog-comment-body">
                                    <div class="blog-comment-head">
                                        <span class="blog-comment-name">
                                            {{ $comment->user->name ?? '-' }}
                                        </span>

                                        <span class="blog-comment-date">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="blog-comment-text">
                                        {{ $comment->comment }}
                                    </p>

                                    @auth
                                        @if ($comment->user_id === auth()->id())
                                            <form method="POST" action="{{ route('user.blog.comments.destroy', $comment) }}"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="blog-comment-delete"
                                                    onclick="return confirm('Hapus komentar ini?')">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="blog-comment-empty">
                                Belum ada komentar. Jadilah yang pertama!
                            </div>
                        @endforelse
                    </div>

                    {{-- Form Komentar --}}
                    <div id="comment-form">
                        @auth
                            <div class="blog-comment-form">
                                <h4>Tulis Komentar</h4>

                                <form method="POST" action="{{ route('user.blog.comments.store', $blog) }}">
                                    @csrf

                                    <div class="form-group">
                                        <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4"
                                            placeholder="Tulis komentar kamu...">{{ old('comment') }}</textarea>

                                        @error('comment')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn-gold">
                                        <i class="fas fa-paper-plane"></i>
                                        Kirim Komentar
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="blog-comment-form" style="text-align:center;">
                                <p style="color:var(--text-secondary);margin-bottom:1rem;">
                                    Login untuk meninggalkan komentar.
                                </p>

                                <a href="{{ route('auth.login') }}" class="btn-gold">
                                    Masuk
                                </a>
                            </div>
                        @endauth
                    </div>

                </article>

                {{-- Sidebar --}}
                <aside class="blog-sidebar">

                    {{-- CTA --}}
                    <div class="sidebar-card sidebar-cta">
                        <div class="sidebar-cta-icon">🚀</div>

                        <h3>Tingkatkan Skill Coding Kamu</h3>

                        <p>
                            Belajar Flutter, Laravel, UI/UX, dan Web Development
                            dari nol sampai bisa bareng Kodingin.
                        </p>

                        <a href="{{ url('/kursus') }}" class="btn-gold">
                            Mulai Belajar
                        </a>
                    </div>

                    {{-- Artikel Terkait --}}
                    @if ($relatedBlogs->count())
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">Artikel Terkait</h3>

                            <div class="sidebar-blog-list">
                                @foreach ($relatedBlogs as $related)
                                    <a href="{{ url('/blog/' . $related->slug) }}" class="sidebar-blog-card">
                                        <div class="sidebar-blog-thumb">
                                            @if ($related->image)
                                                <img src="{{ asset('storage/' . $related->image) }}"
                                                    alt="{{ $related->title }}">
                                            @else
                                                <span class="sidebar-blog-icon">📝</span>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="sidebar-blog-title">
                                                {{ Str::limit($related->title, 50) }}
                                            </div>

                                            <div class="sidebar-blog-date">
                                                {{ $related->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Artikel Terbaru --}}
                    @if ($recentBlogs->count())
                        <div class="sidebar-card">
                            <h3 class="sidebar-title">Artikel Terbaru</h3>

                            @foreach ($recentBlogs as $recent)
                                <a href="{{ url('/blog/' . $recent->slug) }}" class="sidebar-recent-link">
                                    <i class="fas fa-angle-right"></i>
                                    {{ Str::limit($recent->title, 48) }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                </aside>

            </div>
        </div>
    </section>

@endsection
