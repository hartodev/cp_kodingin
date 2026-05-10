@extends('frontend.layouts.app')

@section('title', $course->title)
@section('meta_description', $course->seo_description ?? Str::limit($course->description, 155))

@section('content')

    <section style="padding:5rem 3rem 0;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div style="display:grid;grid-template-columns:1fr 360px;gap:3rem;align-items:start;">

                {{-- Kiri: Detail Kursus --}}
                <div>
                    {{-- Breadcrumb --}}
                    <div style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                        <a href="{{ url('/courses') }}" style="color:var(--gold-primary);text-decoration:none;">Kursus</a>
                        <span style="margin:0 0.5rem;">/</span>
                        @if ($course->category)
                            <a href="{{ url('/courses?category=' . $course->category->slug) }}"
                                style="color:var(--gold-primary);text-decoration:none;">{{ $course->category->name }}</a>
                            <span style="margin:0 0.5rem;">/</span>
                        @endif
                        <span>{{ Str::limit($course->title, 40) }}</span>
                    </div>

                    {{-- Tags & Level --}}
                    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1rem;">
                        @if ($course->category)
                            <span class="badge badge-gold">{{ $course->category->name }}</span>
                        @endif
                        @if ($course->level)
                            <span class="badge"
                                style="background:rgba(139,92,246,0.1);color:#A78BFA;">{{ $course->level->name }}</span>
                        @endif
                        @foreach ($course->tags->take(3) as $tag)
                            <span class="badge"
                                style="background:rgba(255,255,255,0.06);color:var(--text-secondary);">{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <h1
                        style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;line-height:1.2;margin-bottom:1rem;background:linear-gradient(135deg,#fff,var(--gold-primary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        {{ $course->title }}
                    </h1>

                    {{-- Stats --}}
                    <div
                        style="display:flex;gap:1.5rem;flex-wrap:wrap;margin-bottom:1.5rem;font-size:0.88rem;color:var(--text-secondary);">
                        <span><i class="fas fa-users"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ number_format($course->enrollments_count) }}
                            siswa</span>
                        <span><i class="fas fa-star"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ number_format($course->reviews_avg_rating ?? 0, 1) }}
                            ({{ $course->reviews->count() }} review)</span>
                        @if ($course->duration)
                            <span><i class="fas fa-clock"
                                    style="color:var(--gold-primary);margin-right:4px;"></i>{{ $course->duration }}</span>
                        @endif
                        <span><i class="fas fa-film"
                                style="color:var(--gold-primary);margin-right:4px;"></i>{{ $totalLessons }} lesson</span>
                    </div>

                    {{-- Deskripsi --}}
                    @if ($course->description)
                        <div style="font-size:0.95rem;color:var(--text-secondary);line-height:1.8;margin-bottom:2rem;">
                            {{ $course->description }}
                        </div>
                    @endif

                    {{-- Preview Lessons --}}
                    @if ($previewLessons->count())
                        <div
                            style="margin-bottom:2rem;padding:1.5rem;background:rgba(244,196,48,0.05);border:1px solid rgba(244,196,48,0.15);border-radius:16px;">
                            <div style="font-weight:700;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                                <i class="fas fa-play-circle" style="color:var(--gold-primary);"></i>
                                Preview Gratis ({{ $previewLessons->count() }} lesson)
                            </div>
                            @foreach ($previewLessons->take(3) as $lesson)
                                <div
                                    style="display:flex;align-items:center;gap:0.8rem;padding:0.6rem 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                                    <i class="fas fa-play-circle" style="color:var(--gold-primary);font-size:0.85rem;"></i>
                                    <span style="font-size:0.88rem;">{{ $lesson->title }}</span>
                                    @if ($lesson->duration)
                                        <span
                                            style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);">{{ $lesson->duration }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Kurikulum --}}
                    <div style="margin-bottom:3rem;">
                        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;">
                            Kurikulum
                            <span
                                style="font-size:0.85rem;font-weight:400;color:var(--text-secondary);margin-left:0.5rem;">{{ $totalLessons }}
                                lesson</span>
                        </h2>

                        @foreach ($course->chapters as $chapter)
                            <div
                                style="border:1px solid rgba(244,196,48,0.1);border-radius:14px;overflow:hidden;margin-bottom:0.8rem;">
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;background:rgba(255,255,255,0.03);cursor:pointer;font-weight:600;"
                                    onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'block':'none'">
                                    <span>{{ $chapter->title }}</span>
                                    <span
                                        style="font-size:0.78rem;color:var(--text-secondary);">{{ $chapter->lessons->count() }}
                                        lesson</span>
                                </div>
                                <div style="{{ $loop->first ? '' : 'display:none;' }}">
                                    @foreach ($chapter->lessons as $lesson)
                                        <div
                                            style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem 1.5rem;border-top:1px solid rgba(255,255,255,0.04);">
                                            @if ($lesson->is_preview)
                                                <i class="fas fa-play-circle"
                                                    style="color:var(--gold-primary);font-size:0.85rem;"></i>
                                            @else
                                                <i class="fas fa-lock"
                                                    style="color:rgba(255,255,255,0.2);font-size:0.85rem;"></i>
                                            @endif
                                            <span
                                                style="font-size:0.88rem;color:var(--text-secondary);">{{ $lesson->title }}</span>
                                            @if ($lesson->is_preview)
                                                <span
                                                    style="font-size:0.7rem;color:var(--gold-primary);background:rgba(244,196,48,0.1);padding:1px 8px;border-radius:10px;margin-left:4px;">Preview</span>
                                            @endif
                                            @if ($lesson->duration)
                                                <span
                                                    style="margin-left:auto;font-size:0.78rem;color:var(--text-secondary);">{{ $lesson->duration }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Reviews --}}
                    @if ($course->reviews->count())
                        <div>
                            <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;">
                                Review
                                <span
                                    style="font-size:0.85rem;font-weight:400;color:var(--text-secondary);margin-left:0.5rem;">
                                    <i class="fas fa-star" style="color:var(--gold-primary);"></i>
                                    {{ number_format($course->reviews_avg_rating ?? 0, 1) }}/5
                                </span>
                            </h2>
                            @foreach ($course->reviews->take(5) as $review)
                                <div
                                    style="padding:1.2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.08);border-radius:14px;margin-bottom:0.8rem;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
                                        <span
                                            style="font-weight:600;font-size:0.9rem;">{{ $review->user->name ?? '-' }}</span>
                                        <div>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star"
                                                    style="color:{{ $i <= $review->rating ? 'var(--gold-primary)' : 'rgba(255,255,255,0.1)' }};font-size:0.75rem;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p style="font-size:0.88rem;color:var(--text-secondary);line-height:1.6;">
                                        {{ $review->review }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Kanan: CTA Card --}}
                <div style="position:sticky;top:90px;">
                    <div
                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(244,196,48,0.2);border-radius:24px;overflow:hidden;">

                        @if ($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                style="width:100%;height:200px;object-fit:cover;">
                        @else
                            <div
                                style="width:100%;height:200px;background:linear-gradient(135deg,rgba(244,196,48,0.1),rgba(244,196,48,0.05));display:flex;align-items:center;justify-content:center;font-size:4rem;">
                                📚
                            </div>
                        @endif

                        <div style="padding:1.8rem;">
                            <div
                                style="font-size:2rem;font-weight:900;margin-bottom:0.3rem;background:linear-gradient(135deg,var(--gold-primary),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                                GRATIS
                            </div>
                            <div style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;">
                                Subscribe YouTube kami untuk akses penuh
                            </div>

                            @auth
                                @if ($isEnrolled)
                                    <a href="{{ route('user.learn', $course) }}" class="btn-gold"
                                        style="width:100%;text-align:center;display:block;margin-bottom:0.8rem;">
                                        <i class="fas fa-play"></i> Lanjut Belajar
                                    </a>
                                @elseif($isInCart)
                                    <a href="{{ route('user.cart') }}" class="btn-outline"
                                        style="width:100%;text-align:center;display:block;margin-bottom:0.8rem;">
                                        <i class="fas fa-shopping-cart"></i> Lihat Keranjang
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('user.cart.store', $course) }}"
                                        style="margin-bottom:0.8rem;">
                                        @csrf
                                        <button type="submit" class="btn-gold" style="width:100%;">
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @endif

                                <button data-wishlist="{{ $course->id }}"
                                    style="width:100%;padding:0.8rem;background:transparent;border:1px solid rgba(244,196,48,0.2);border-radius:50px;color:{{ $isWishlisted ? '#EF4444' : 'var(--text-secondary)' }};cursor:pointer;font-family:'Inter',sans-serif;font-size:0.9rem;transition:all 0.3s;">
                                    <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart" style="margin-right:0.4rem;"></i>
                                    {{ $isWishlisted ? 'Tersimpan' : 'Simpan ke Wishlist' }}
                                </button>
                            @else
                                <a href="{{ route('auth.register') }}" class="btn-gold"
                                    style="width:100%;text-align:center;display:block;margin-bottom:0.8rem;">
                                    <i class="fas fa-rocket"></i> Daftar & Akses Gratis
                                </a>
                                <a href="{{ route('auth.login') }}" class="btn-outline"
                                    style="width:100%;text-align:center;display:block;">
                                    Sudah punya akun? Masuk
                                </a>
                            @endauth

                            {{-- Info Kursus --}}
                            <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,0.06);">
                                @foreach ([['icon' => 'fa-film', 'label' => $totalLessons . ' Lesson'], ['icon' => 'fa-clock', 'label' => $course->duration ?? 'Self-paced'], ['icon' => 'fa-signal', 'label' => $course->level->name ?? 'Semua Level'], ['icon' => 'fa-certificate', 'label' => $course->certificate ? 'Sertifikat' : 'Tanpa Sertifikat'], ['icon' => 'fa-infinity', 'label' => 'Akses Selamanya']] as $info)
                                    <div
                                        style="display:flex;align-items:center;gap:0.8rem;padding:0.5rem 0;font-size:0.85rem;color:var(--text-secondary);">
                                        <i class="fas {{ $info['icon'] }}"
                                            style="color:var(--gold-primary);width:16px;text-align:center;"></i>
                                        {{ $info['label'] }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Kursus Terkait --}}
    @if ($relatedCourses->count())
        <section style="padding:5rem 3rem 8rem;position:relative;z-index:2;">
            <div style="max-width:1200px;margin:0 auto;">
                <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:2rem;">Kursus Terkait</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
                    @foreach ($relatedCourses as $related)
                        <a href="{{ url('/courses/' . $related->slug) }}" class="course-card reveal">
                            <div class="course-card-img">
                                @if ($related->thumbnail)
                                    <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                        style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size:2.5rem;">📚</span>
                                @endif
                            </div>
                            <div class="course-card-body">
                                <span class="course-card-category">{{ $related->category->name ?? '' }}</span>
                                <div class="course-card-title">{{ $related->title }}</div>
                            </div>
                            <div class="course-card-footer">
                                <span style="font-size:0.82rem;color:var(--text-secondary);"><i class="fas fa-users"
                                        style="color:var(--gold-primary);margin-right:4px;"></i>{{ $related->enrollments_count }}
                                    siswa</span>
                                <span style="font-size:0.82rem;font-weight:700;color:var(--gold-primary);">GRATIS</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
