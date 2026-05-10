@extends('frontend.layouts.app')

@section('title', 'Semua Kursus')
@section('title_suffix', 'Belajar Gratis')

@section('content')

    {{-- Page Header --}}
    <section style="padding:5rem 3rem 3rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div class="reveal">
                <span class="section-eyebrow">Katalog Kursus</span>
                <h1 class="section-title">Semua Kursus</h1>
                <p class="section-sub">
                    Akses semua kursus secara gratis — cukup subscribe YouTube channel kami.
                </p>
            </div>
        </div>
    </section>

    {{-- Filter & Search --}}
    <section style="padding:0 3rem 2rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <form method="GET" action="{{ url('/courses') }}"
                style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;padding:1.5rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:20px;">

                <input type="text" name="search" class="form-control" style="max-width:280px;"
                    placeholder="🔍 Cari kursus..." value="{{ request('search') }}">

                <select name="category" class="form-control" style="max-width:180px;">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="level" class="form-control" style="max-width:150px;">
                    <option value="">Semua Level</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->slug }}" {{ request('level') === $level->slug ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort" class="form-control" style="max-width:160px;">
                    <option value="">Terbaru</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>

                <button type="submit" class="btn-gold" style="padding:0.8rem 1.5rem;font-size:0.9rem;">
                    <i class="fas fa-search"></i> Cari
                </button>

                @if (request()->hasAny(['search', 'category', 'level', 'sort']))
                    <a href="{{ url('/courses') }}" class="btn-outline" style="padding:0.8rem 1.5rem;font-size:0.9rem;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- Course Grid --}}
    <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">

            @if ($courses->count())
                <div style="margin-bottom:1rem;font-size:0.88rem;color:var(--text-secondary);">
                    Menampilkan {{ $courses->firstItem() }}–{{ $courses->lastItem() }} dari {{ $courses->total() }}
                    kursus
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
                    @foreach ($courses as $course)
                        <a href="{{ url('/courses/' . $course->slug) }}" class="course-card reveal">
                            {{-- Thumbnail --}}
                            <div class="course-card-img">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size:3rem;">📚</span>
                                @endif
                            </div>

                            <div class="course-card-body">
                                <span class="course-card-category">{{ $course->category->name ?? 'Kursus' }}</span>
                                <div class="course-card-title">{{ $course->title }}</div>
                                <div class="course-card-meta">
                                    @if ($course->level)
                                        <span><i class="fas fa-signal"
                                                style="margin-right:4px;color:var(--gold-primary);"></i>{{ $course->level->name }}</span>
                                    @endif
                                    @if ($course->duration)
                                        <span><i class="fas fa-clock"
                                                style="margin-right:4px;color:var(--gold-primary);"></i>{{ $course->duration }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="course-card-footer">
                                <div
                                    style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-secondary);">
                                    <i class="fas fa-users" style="color:var(--gold-primary);"></i>
                                    {{ number_format($course->enrollments_count) }} siswa
                                </div>
                                <div style="display:flex;align-items:center;gap:0.3rem;font-size:0.82rem;">
                                    <i class="fas fa-star" style="color:var(--gold-primary);font-size:0.75rem;"></i>
                                    {{ number_format($course->reviews_avg_rating ?? 0, 1) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($courses->hasPages())
                    <div class="pagination-wrap">
                        {{-- Previous --}}
                        @if ($courses->onFirstPage())
                            <span style="opacity:0.3;"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $courses->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        {{-- Pages --}}
                        @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                            @if ($page == $courses->currentPage())
                                <span class="current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($courses->hasMorePages())
                            <a href="{{ $courses->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span style="opacity:0.3;"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                @endif
            @else
                <div style="text-align:center;padding:6rem 2rem;">
                    <div style="font-size:4rem;margin-bottom:1rem;">📭</div>
                    <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Kursus tidak ditemukan</h3>
                    <p style="color:var(--text-secondary);margin-bottom:2rem;">Coba ubah filter pencarian kamu.</p>
                    <a href="{{ url('/courses') }}" class="btn-gold">Lihat Semua Kursus</a>
                </div>
            @endif

        </div>
    </section>

@endsection
