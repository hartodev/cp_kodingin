@extends('frontend.layouts.app')

@section('title', 'Blog & Panduan')

@section('content')

    <section style="padding:5rem 3rem 3rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div class="reveal">
                <span class="section-eyebrow">Blog & Panduan</span>
                <h1 class="section-title">Artikel Terbaru</h1>
                <p class="section-sub">Tips, tutorial, dan panduan dari para expert</p>
            </div>
        </div>
    </section>

    {{-- Filter --}}
    <section style="padding:0 3rem 2rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <form method="GET" action="{{ url('/blog') }}"
                style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
                <input type="text" name="search" class="form-control" style="max-width:300px;"
                    placeholder="🔍 Cari artikel..." value="{{ request('search') }}">
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    <a href="{{ url('/blog') }}" class="{{ !request('category') ? 'btn-gold' : 'btn-ghost' }}"
                        style="padding:0.6rem 1.2rem;font-size:0.85rem;border-radius:50px;">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ url('/blog?category=' . $cat->slug) }}"
                            class="{{ request('category') === $cat->slug ? 'btn-gold' : 'btn-ghost' }}"
                            style="padding:0.6rem 1.2rem;font-size:0.85rem;border-radius:50px;">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
                @if (request('search'))
                    <button type="submit" class="btn-outline" style="padding:0.6rem 1.2rem;font-size:0.85rem;">
                        <i class="fas fa-search"></i> Cari
                    </button>
                @endif
            </form>
        </div>
    </section>

    {{-- Blog Grid --}}
    <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            @if ($blogs->count())

                {{-- Featured — blog pertama lebih besar --}}
                @if ($blogs->currentPage() === 1)
                    @php $featured = $blogs->first(); @endphp
                    <a href="{{ url('/blog/' . $featured->slug) }}"
                        style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;align-items:center;padding:2rem;background:rgba(255,255,255,0.04);border:1px solid rgba(244,196,48,0.15);border-radius:24px;margin-bottom:2rem;text-decoration:none;color:inherit;transition:all 0.4s;"
                        onmouseover="this.style.borderColor='rgba(244,196,48,0.4)';this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.borderColor='rgba(244,196,48,0.15)';this.style.transform=''">
                        <div class="blog-card-img" style="height:260px;border-radius:16px;">
                            @if ($featured->image)
                                <img src="{{ asset('storage/' . $featured->image) }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:16px;">
                            @else
                                <span style="font-size:4rem;">📰</span>
                            @endif
                        </div>
                        <div>
                            <span class="blog-card-category">{{ $featured->category->name ?? 'Blog' }}</span>
                            <h2 style="font-size:1.6rem;font-weight:800;margin-bottom:1rem;line-height:1.3;">
                                {{ $featured->title }}</h2>
                            <p style="color:var(--text-secondary);font-size:0.9rem;line-height:1.7;margin-bottom:1.2rem;">
                                {{ Str::limit(strip_tags($featured->description), 150) }}
                            </p>
                            <div class="blog-card-meta">
                                <span><i class="fas fa-user"
                                        style="margin-right:4px;color:var(--gold-primary);"></i>{{ $featured->user->name ?? '-' }}</span>
                                <span><i class="fas fa-comments"
                                        style="margin-right:4px;color:var(--gold-primary);"></i>{{ $featured->comments_count }}
                                    komentar</span>
                                <span><i class="fas fa-calendar"
                                        style="margin-right:4px;color:var(--gold-primary);"></i>{{ $featured->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- Grid blog lainnya --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
                    @foreach ($blogs->currentPage() === 1 ? $blogs->skip(1) : $blogs as $blog)
                        <a href="{{ url('/blog/' . $blog->slug) }}" class="blog-card reveal">
                            <div class="blog-card-img">
                                @if ($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size:3rem;">📝</span>
                                @endif
                            </div>
                            <div class="blog-card-body">
                                <span class="blog-card-category">{{ $blog->category->name ?? 'Blog' }}</span>
                                <div class="blog-card-title">{{ $blog->title }}</div>
                                <p
                                    style="font-size:0.85rem;color:var(--text-secondary);line-height:1.6;margin-bottom:0.8rem;">
                                    {{ Str::limit(strip_tags($blog->description), 100) }}
                                </p>
                                <div class="blog-card-meta">
                                    <span>{{ $blog->created_at->format('d M Y') }}</span>
                                    <span><i class="fas fa-comments"
                                            style="margin-right:3px;"></i>{{ $blog->comments_count }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($blogs->hasPages())
                    <div class="pagination-wrap">
                        @if ($blogs->onFirstPage())
                            <span style="opacity:0.3;"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $blogs->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                        @endif
                        @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                            @if ($page == $blogs->currentPage())
                                <span class="current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($blogs->hasMorePages())
                            <a href="{{ $blogs->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span style="opacity:0.3;"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                @endif
            @else
                <div style="text-align:center;padding:6rem 2rem;">
                    <div style="font-size:4rem;margin-bottom:1rem;">📭</div>
                    <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Artikel tidak ditemukan</h3>
                    <a href="{{ url('/blog') }}" class="btn-gold" style="margin-top:1rem;">Lihat Semua Artikel</a>
                </div>
            @endif
        </div>
    </section>

@endsection
