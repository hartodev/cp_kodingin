@extends('user.layouts.app')
@section('title', 'Kursus Saya')
@section('page_title', 'Kursus Saya')

@section('content')

    @if ($enrollments->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
            @foreach ($enrollments as $enrollment)
                @php $progress = $progressData[$enrollment->course_id] ?? 0; @endphp
                <div class="dash-card" style="display:flex;flex-direction:column;">
                    {{-- Thumbnail --}}
                    <div
                        style="height:150px;border-radius:10px;overflow:hidden;margin-bottom:1rem;background:rgba(244,196,48,0.06);display:flex;align-items:center;justify-content:center;">
                        @if ($enrollment->course->thumbnail)
                            <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fas fa-book" style="font-size:2.5rem;color:rgba(244,196,48,0.3);"></i>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="flex:1;">
                        <span
                            style="font-size:0.7rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--gold);">
                            {{ $enrollment->course->category->name ?? 'Kursus' }}
                        </span>
                        <h3 style="font-size:0.95rem;font-weight:700;margin:0.4rem 0;line-height:1.3;">
                            {{ $enrollment->course->title }}
                        </h3>
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.8rem;">
                            {{ $enrollment->course->chapters->count() }} chapter ·
                            {{ $enrollment->course->chapters->flatMap->lessons->count() }} lesson
                        </div>

                        {{-- Progress --}}
                        <div style="margin-bottom:1rem;">
                            <div
                                style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--text-muted);margin-bottom:0.4rem;">
                                <span>Progress</span>
                                <span style="color:var(--gold);font-weight:700;">{{ $progress }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ $progress }}%;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <a href="{{ route('user.learn', $enrollment->course) }}" class="btn-primary"
                        style="width:100%;justify-content:center;">
                        @if ($progress >= 100)
                            <i class="fas fa-check-circle"></i> Selesai — Lihat Lagi
                        @elseif($progress > 0)
                            <i class="fas fa-play"></i> Lanjut Belajar
                        @else
                            <i class="fas fa-play"></i> Mulai Belajar
                        @endif
                    </a>

                    @if ($progress >= 100)
                        <a href="{{ route('user.learn.certificate', $enrollment->course) }}" class="btn-secondary"
                            style="width:100%;justify-content:center;margin-top:0.5rem;font-size:0.82rem;">
                            <i class="fas fa-certificate"></i> Ambil Sertifikat
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($enrollments->hasPages())
            <div style="display:flex;justify-content:center;gap:0.5rem;margin-top:2rem;">
                @if (!$enrollments->onFirstPage())
                    <a href="{{ $enrollments->previousPageUrl() }}" class="btn-secondary"
                        style="padding:0.5rem 1rem;font-size:0.85rem;">← Prev</a>
                @endif
                @if ($enrollments->hasMorePages())
                    <a href="{{ $enrollments->nextPageUrl() }}" class="btn-secondary"
                        style="padding:0.5rem 1rem;font-size:0.85rem;">Next →</a>
                @endif
            </div>
        @endif
    @else
        <div style="text-align:center;padding:5rem 2rem;">
            <i class="fas fa-book-open"
                style="font-size:4rem;color:rgba(244,196,48,0.2);margin-bottom:1rem;display:block;"></i>
            <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Belum ada kursus</h3>
            <p style="color:var(--text-muted);margin-bottom:2rem;">Tambahkan kursus ke keranjang dan lakukan verifikasi
                YouTube.</p>
            <a href="{{ url('/courses') }}" class="btn-primary">
                <i class="fas fa-search"></i> Cari Kursus
            </a>
        </div>
    @endif

@endsection
