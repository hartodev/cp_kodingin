@extends('frontend.layouts.app')

@section('title', 'Home')
@section('title_suffix', \App\Models\Setting::get('site_tagline', 'Next Gen Learning'))

@section('content')

    {{-- ═══════════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════════════ --}}
    <section class="hero">
        <div class="hero-container">

            {{-- Kiri: Text --}}
            <div class="hero-content reveal">
                <div class="hero-eyebrow">Next-gen learning platform</div>
                <h1>Master Skills<br>Next Level</h1>
                <p class="hero-subtitle">
                    Platform belajar paling modern dengan kurikulum terbaik.
                    Transformasi karir kamu dalam hitungan minggu — gratis dengan subscribe YouTube kami.
                </p>
                <div class="hero-buttons">
                    <a href="{{ url('/courses') }}" class="btn-gold">🚀 Mulai Sekarang</a>
                    <a href="{{ url('/courses') }}" class="btn-outline">📚 Lihat Kursus</a>
                </div>
            </div>

            {{-- Kanan: Infinite scroll cards — persis index.html --}}
            <div class="hero-visual reveal">
                <div class="cards-track">
                    @php
                        $heroCards = [
                            [
                                'icon' => '💻',
                                'title' => 'Web Development',
                                'text' => 'HTML, CSS, JS, React, Laravel<br>dari nol sampai mahir',
                            ],
                            [
                                'icon' => '🤖',
                                'title' => 'AI & Machine Learning',
                                'text' => 'Python · TensorFlow · Deploy<br>Build real-world AI projects',
                            ],
                            [
                                'icon' => '🎨',
                                'title' => 'UI/UX Design',
                                'text' => 'Figma · Prototyping · Research<br>Design responsif semua device',
                            ],
                            [
                                'icon' => '📱',
                                'title' => 'Mobile Development',
                                'text' => 'Flutter · React Native<br>Apps untuk iOS & Android',
                            ],
                            [
                                'icon' => '☁️',
                                'title' => 'Cloud & DevOps',
                                'text' => 'AWS · Docker · CI/CD<br>Infrastructure skala enterprise',
                            ],
                        ];
                    @endphp

                    {{-- Set 1 --}}
                    @foreach ($heroCards as $card)
                        <div class="floating-card">
                            <span class="card-icon">{{ $card['icon'] }}</span>
                            <div class="card-title">{{ $card['title'] }}</div>
                            <div class="card-text">{!! $card['text'] !!}</div>
                        </div>
                    @endforeach

                    {{-- Set 2 — seamless duplicate --}}
                    @foreach ($heroCards as $card)
                        <div class="floating-card">
                            <span class="card-icon">{{ $card['icon'] }}</span>
                            <div class="card-title">{{ $card['title'] }}</div>
                            <div class="card-text">{!! $card['text'] !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     STATS
══════════════════════════════════════════════════════════════ --}}
    <section class="stats">
        <div class="stats-container">
            <div class="stat-card reveal">
                <span class="stat-number">{{ number_format($stats['total_enrollments']) }}+</span>
                <div class="stat-label">Active Learners</div>
            </div>
            <div class="stat-card reveal">
                <span class="stat-number">{{ $stats['total_courses'] }}+</span>
                <div class="stat-label">Total Kursus</div>
            </div>
            <div class="stat-card reveal">
                <span class="stat-number">4.9★</span>
                <div class="stat-label">Rating</div>
            </div>
            <div class="stat-card reveal">
                <span class="stat-number">100%</span>
                <div class="stat-label">Gratis Akses</div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     KURSUS UNGGULAN — sama persis layout index.html
══════════════════════════════════════════════════════════════ --}}
    <section class="courses">
        <div class="section-header reveal">
            <h2 class="section-title">Kursus Unggulan</h2>
            <p class="section-sub">Belajar dari materi berkualitas, akses gratis dengan subscribe YouTube kami</p>
        </div>

        <div class="courses-grid">
            @foreach ($featuredCourses->take(3) as $i => $course)
                <div class="course-row reveal {{ $i % 2 !== 0 ? 'style=direction:rtl;' : '' }}">

                    <div class="course-main {{ $i % 2 !== 0 ? 'style=direction:ltr;' : '' }}">
                        <div class="course-tag">{{ $course->category->name ?? 'Kursus' }}</div>
                        <h3 class="course-title">{{ $course->title }}</h3>

                        <div class="course-features">
                            @if ($course->duration)
                                <div class="feature">
                                    <div class="feature-icon"><i class="fas fa-clock"></i></div>
                                    <span>{{ $course->duration }}</span>
                                </div>
                            @endif
                            <div class="feature">
                                <div class="feature-icon"><i class="fas fa-users"></i></div>
                                <span>{{ number_format($course->enrollments_count) }} siswa terdaftar</span>
                            </div>
                            @if ($course->certificate)
                                <div class="feature">
                                    <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                                    <span>Sertifikat Kelulusan</span>
                                </div>
                            @endif
                            <div class="feature">
                                <div class="feature-icon"><i class="fab fa-youtube" style="color:#EF4444;"></i></div>
                                <span>Gratis — Subscribe YouTube kami</span>
                            </div>
                        </div>

                        <div class="course-price">GRATIS</div>

                        <a href="{{ url('/courses/' . $course->slug) }}" class="btn-gold">
                            Lihat Kursus <i class="fas fa-arrow-right" style="margin-left:0.4rem;"></i>
                        </a>
                    </div>

                    <div class="course-image {{ $i % 2 !== 0 ? 'style=direction:ltr;' : '' }}">
                        @if ($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:24px;">
                        @else
                            {{ ['💻', '🤖', '🎨', '📱', '☁️'][$i % 5] }}
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:4rem;">
            <a href="{{ url('/courses') }}" class="btn-outline">
                Lihat Semua Kursus <i class="fas fa-arrow-right" style="margin-left:0.4rem;"></i>
            </a>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     CARA KERJA
══════════════════════════════════════════════════════════════ --}}
    <section style="padding:8rem 3rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div class="section-header reveal">
                <span class="section-eyebrow">Cara Kerja</span>
                <h2 class="section-title">Semudah 3 Langkah</h2>
                <p class="section-sub">Akses semua kursus premium secara gratis</p>
            </div>

            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;" class="reveal">
                @foreach ([['num' => '01', 'icon' => 'fa-book', 'title' => 'Pilih Kursus', 'desc' => 'Browse semua kursus yang tersedia dan pilih sesuai minatmu.'], ['num' => '02', 'icon' => 'fab fa-youtube', 'title' => 'Subscribe YouTube', 'desc' => 'Subscribe channel YouTube kami dan upload screenshot sebagai bukti.'], ['num' => '03', 'icon' => 'fa-graduation-cap', 'title' => 'Belajar Gratis', 'desc' => 'Setelah verifikasi, akses penuh ke semua materi kursus pilihanmu.']] as $step)
                    <div style="text-align:center;padding:2.5rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:24px;transition:transform 0.3s,border-color 0.3s;"
                        onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='rgba(244,196,48,0.3)'"
                        onmouseout="this.style.transform='';this.style.borderColor='rgba(244,196,48,0.1)'">
                        <div
                            style="font-size:0.7rem;font-weight:800;letter-spacing:2px;color:rgba(244,196,48,0.5);margin-bottom:1rem;">
                            {{ $step['num'] }}</div>
                        <div
                            style="width:60px;height:60px;background:rgba(244,196,48,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;font-size:1.4rem;color:var(--gold-primary);">
                            <i
                                class="{{ str_starts_with($step['icon'], 'fab') ? $step['icon'] : 'fas ' . $step['icon'] }}"></i>
                        </div>
                        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.8rem;">{{ $step['title'] }}</h3>
                        <p style="font-size:0.88rem;color:var(--text-secondary);line-height:1.6;">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
     KATEGORI
══════════════════════════════════════════════════════════════ --}}
    @if ($categories->count())
        <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
            <div style="max-width:1200px;margin:0 auto;">
                <div class="section-header reveal">
                    <span class="section-eyebrow">Topik Belajar</span>
                    <h2 class="section-title">Kategori Kursus</h2>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;"
                    class="reveal">
                    @foreach ($categories as $cat)
                        <a href="{{ url('/courses?category=' . $cat->slug) }}"
                            style="display:block;text-align:center;padding:1.5rem 1rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;text-decoration:none;color:inherit;transition:all 0.3s;"
                            onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='rgba(244,196,48,0.3)';this.style.background='rgba(244,196,48,0.06)'"
                            onmouseout="this.style.transform='';this.style.borderColor='rgba(244,196,48,0.1)';this.style.background='rgba(255,255,255,0.03)'">
                            @if ($cat->icon)
                                <i class="fas {{ $cat->icon }}"
                                    style="font-size:1.8rem;color:var(--gold-primary);margin-bottom:0.8rem;display:block;"></i>
                            @else
                                <div style="font-size:1.8rem;margin-bottom:0.8rem;">📚</div>
                            @endif
                            <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.3rem;">{{ $cat->name }}</div>
                            <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $cat->courses_count }} kursus
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
     TESTIMONI
══════════════════════════════════════════════════════════════ --}}
    @if ($testimonials->count())
        <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
            <div style="max-width:1200px;margin:0 auto;">
                <div class="section-header reveal">
                    <span class="section-eyebrow">Testimoni</span>
                    <h2 class="section-title">Kata Mereka</h2>
                    <p class="section-sub">Ribuan siswa sudah membuktikannya</p>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;"
                    class="reveal">
                    @foreach ($testimonials as $t)
                        <div
                            style="padding:2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:20px;">
                            {{-- Bintang --}}
                            <div style="margin-bottom:1rem;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star"
                                        style="color:{{ $i <= $t->rating ? 'var(--gold-primary)' : 'rgba(255,255,255,0.1)' }};font-size:0.85rem;"></i>
                                @endfor
                            </div>
                            <p style="font-size:0.9rem;color:var(--text-secondary);line-height:1.7;margin-bottom:1.2rem;">
                                "{{ $t->review }}"
                            </p>
                            <div style="display:flex;align-items:center;gap:0.8rem;">
                                @if ($t->image)
                                    <img src="{{ asset('storage/' . $t->image) }}"
                                        style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                                @else
                                    <div
                                        style="width:40px;height:40px;background:linear-gradient(135deg,var(--gold-primary),var(--gold-light));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--dark-1);font-size:0.85rem;">
                                        {{ strtoupper(substr($t->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:700;font-size:0.9rem;">{{ $t->name }}</div>
                                    @if ($t->title)
                                        <div style="font-size:0.78rem;color:var(--text-secondary);">{{ $t->title }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════════════════ --}}
    @if ($faqs->count())
        <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
            <div style="max-width:800px;margin:0 auto;">
                <div class="section-header reveal">
                    <span class="section-eyebrow">FAQ</span>
                    <h2 class="section-title">Pertanyaan Umum</h2>
                </div>
                <div class="reveal">
                    @foreach ($faqs as $i => $faq)
                        <div
                            style="border:1px solid rgba(244,196,48,0.1);border-radius:16px;margin-bottom:0.8rem;overflow:hidden;">
                            <button onclick="toggleFaq({{ $i }})"
                                style="width:100%;display:flex;justify-content:space-between;align-items:center;padding:1.3rem 1.5rem;background:rgba(255,255,255,0.03);border:none;color:#fff;font-family:'Inter',sans-serif;font-size:0.95rem;font-weight:600;cursor:pointer;text-align:left;">
                                {{ $faq->question }}
                                <i class="fas fa-chevron-down faq-icon-{{ $i }}"
                                    style="transition:transform 0.3s;flex-shrink:0;margin-left:1rem;color:var(--gold-primary);"></i>
                            </button>
                            <div id="faq-{{ $i }}"
                                style="display:none;padding:0 1.5rem 1.3rem;font-size:0.9rem;color:var(--text-secondary);line-height:1.7;">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════════════════ --}}
    <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:800px;margin:0 auto;text-align:center;padding:5rem 3rem;background:rgba(244,196,48,0.05);border:1px solid rgba(244,196,48,0.15);border-radius:32px;"
            class="reveal">
            <div class="section-eyebrow">Mulai Sekarang</div>
            <h2 class="section-title">Siap Upgrade Skills Kamu?</h2>
            <p class="section-sub" style="margin:0 auto 2.5rem;">
                Daftar gratis, pilih kursus, subscribe YouTube kami, dan mulai belajar hari ini.
            </p>
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-gold">
                    <i class="fas fa-tachometer-alt"></i> Ke Dashboard
                </a>
            @else
                <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                    <a href="{{ route('auth.register') }}" class="btn-gold">
                        <i class="fas fa-rocket"></i> Daftar Gratis
                    </a>
                    <a href="{{ url('/courses') }}" class="btn-outline">
                        Lihat Kursus
                    </a>
                </div>
            @endauth
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function toggleFaq(i) {
            const el = document.getElementById('faq-' + i);
            const icon = document.querySelector('.faq-icon-' + i);
            const open = el.style.display === 'block';
            el.style.display = open ? 'none' : 'block';
            icon.style.transform = open ? '' : 'rotate(180deg)';
        }
    </script>
@endpush
