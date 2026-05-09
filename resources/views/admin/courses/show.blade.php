@extends('admin.layouts.app')

@section('title', $course->title)
@section('page_title', 'Detail Kursus')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    {{-- Kolom Kiri --}}
    <div>
        {{-- Header Kursus --}}
        <div class="card" style="margin-bottom:1.5rem;">
            <div style="display:flex;gap:1.2rem;align-items:flex-start;">
                @if($course->thumbnail)
                <img src="{{ asset('storage/'.$course->thumbnail) }}"
                    style="width:100px;height:100px;border-radius:16px;object-fit:cover;flex-shrink:0;border:1px solid rgba(244,196,48,0.15);">
                @else
                <div
                    style="width:100px;height:100px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:16px;display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--black-void);font-size:1.8rem;flex-shrink:0;">
                    {{ strtoupper(substr($course->title, 0, 2)) }}
                </div>
                @endif
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;gap:0.8rem;margin-bottom:0.5rem;flex-wrap:wrap;">
                        <span class="status {{ $course->status }}">{{ ucfirst($course->status) }}</span>
                        @if($course->category)
                        <span
                            style="font-size:0.75rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 10px;border-radius:20px;">
                            {{ $course->category->name }}
                        </span>
                        @endif
                        @if($course->level)
                        <span
                            style="font-size:0.75rem;color:var(--text-muted);background:rgba(255,255,255,0.05);padding:2px 10px;border-radius:20px;">
                            {{ $course->level->name }}
                        </span>
                        @endif
                    </div>
                    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">{{ $course->title }}</h2>
                    <div style="font-size:0.85rem;color:var(--text-muted);">{{ $course->description }}</div>
                </div>
            </div>

            <div
                style="display:flex;gap:0.8rem;margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid rgba(244,196,48,0.1);flex-wrap:wrap;">
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn-primary" style="font-size:0.85rem;">
                    <i class="fas fa-edit"></i> Edit Kursus
                </a>
                <a href="{{ route('admin.courses.chapters.index', $course) }}" class="btn-secondary"
                    style="font-size:0.85rem;">
                    <i class="fas fa-list"></i> Kelola Chapters
                </a>
                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="font-size:0.85rem;"
                        data-confirm="Yakin ingin menghapus kursus ini?">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Chapters & Lessons --}}
        <div class="data-section" style="margin-bottom:1.5rem;">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-list"></i></div>
                    Chapters & Lessons
                </div>
                <a href="{{ route('admin.courses.chapters.index', $course) }}" class="btn-secondary"
                    style="font-size:0.8rem;padding:0.5rem 1rem;">
                    Kelola
                </a>
            </div>
            @forelse($course->chapters as $chapter)
            <div style="padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div style="font-weight:600;margin-bottom:0.5rem;display:flex;align-items:center;gap:0.5rem;">
                    <span style="color:var(--gold-pure);font-size:0.8rem;">BAB {{ $chapter->order }}</span>
                    {{ $chapter->title }}
                    <span
                        style="margin-left:auto;font-size:0.75rem;color:var(--text-muted);">{{ $chapter->lessons->count() }}
                        lesson</span>
                </div>
                @foreach($chapter->lessons as $lesson)
                <div
                    style="display:flex;align-items:center;gap:0.6rem;padding:0.4rem 0 0.4rem 1rem;font-size:0.85rem;color:var(--text-muted);">
                    <i class="fas fa-play-circle" style="color:var(--gold-pure);font-size:0.75rem;"></i>
                    {{ $lesson->title }}
                    @if($lesson->is_preview)
                    <span
                        style="font-size:0.7rem;color:#10B981;background:rgba(16,185,129,0.1);padding:1px 6px;border-radius:10px;">Preview</span>
                    @endif
                    <span style="margin-left:auto;">{{ $lesson->duration ?? '-' }}</span>
                </div>
                @endforeach
            </div>
            @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-list"></i>
                <p>Belum ada chapter. <a href="{{ route('admin.courses.chapters.index', $course) }}"
                        style="color:var(--gold-pure);">Tambah sekarang</a></p>
            </div>
            @endforelse
        </div>

        {{-- Reviews --}}
        <div class="data-section">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-star"></i></div>
                    Reviews ({{ $course->reviews->count() }})
                </div>
            </div>
            @forelse($course->reviews as $review)
            <div style="padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                    <span style="font-weight:600;font-size:0.9rem;">{{ $review->user->name ?? '-' }}</span>
                    <span style="color:var(--gold-pure);font-size:0.85rem;">
                        @for($i=1;$i<=5;$i++) <i class="fas fa-star"
                            style="{{ $i <= $review->rating ? '' : 'opacity:0.2;' }}"></i>
                            @endfor
                    </span>
                </div>
                <div style="font-size:0.85rem;color:var(--text-muted);">{{ $review->review }}</div>
            </div>
            @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-star"></i>
                <p>Belum ada review</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Kolom Kanan: Stats --}}
    <div>
        <div class="card" style="margin-bottom:1.5rem;">
            <div class="card-header"><i class="fas fa-chart-bar"></i> Statistik</div>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                @foreach([
                ['icon'=>'fa-users','label'=>'Total Siswa','value'=>$course->student_count.' siswa'],
                ['icon'=>'fa-star','label'=>'Rating Rata-rata','value'=>$course->average_rating.' / 5'],
                ['icon'=>'fa-clock','label'=>'Durasi','value'=>$course->duration ?? '-'],
                ['icon'=>'fa-list','label'=>'Total Lesson','value'=>$course->lesson_count.' lesson'],
                ['icon'=>'fa-certificate','label'=>'Sertifikat','value'=>$course->certificate ? 'Ya' : 'Tidak'],
                ['icon'=>'fa-comments','label'=>'Forum QnA','value'=>$course->qna ? 'Aktif' : 'Nonaktif'],
                ] as $stat)
                <div
                    style="display:flex;align-items:center;gap:0.8rem;padding:0.7rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    <div
                        style="width:34px;height:34px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--black-void);font-size:0.85rem;flex-shrink:0;">
                        <i class="fas {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:var(--text-muted);">{{ $stat['label'] }}</div>
                        <div style="font-weight:600;font-size:0.9rem;">{{ $stat['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tags --}}
        @if($course->tags->count())
        <div class="card">
            <div class="card-header"><i class="fas fa-hashtag"></i> Tags</div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                @foreach($course->tags as $tag)
                <span
                    style="padding:0.3rem 0.8rem;background:rgba(244,196,48,0.1);border:1px solid rgba(244,196,48,0.2);border-radius:20px;font-size:0.8rem;color:var(--gold-pure);">
                    {{ $tag->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

@endsection