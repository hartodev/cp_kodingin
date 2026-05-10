@extends('user.layouts.app')
@section('title', 'Belajar — ' . $course->title)
@section('page_title', $course->title)

@section('content')

    {{-- Kalau tidak ada lesson sama sekali --}}
    <div style="max-width:700px;margin:0 auto;text-align:center;padding:5rem 2rem;">

        <div
            style="width:80px;height:80px;background:rgba(244,196,48,0.1);border:1px solid rgba(244,196,48,0.25);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2rem;">
            📚
        </div>

        <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:0.5rem;">{{ $course->title }}</h2>
        <p style="color:var(--text-muted);margin-bottom:2rem;">
            @if ($course->chapters->flatMap->lessons->count() === 0)
                Materi kursus ini belum tersedia. Pantau terus ya!
            @else
                Memuat materi kursus...
            @endif
        </p>

        <a href="{{ route('user.my-courses') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Kursus Saya
        </a>
    </div>

@endsection
