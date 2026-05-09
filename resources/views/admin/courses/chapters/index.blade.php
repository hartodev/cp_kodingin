@extends('admin.layouts.app')

@section('title', 'Chapters — ' . $course->title)
@section('page_title', 'Chapters & Lessons')

@section('content')

{{-- Breadcrumb --}}
<div style="margin-bottom:1.5rem;font-size:0.85rem;color:var(--text-muted);">
    <a href="{{ route('admin.courses.index') }}" style="color:var(--gold-pure);text-decoration:none;">Kursus</a>
    <span style="margin:0 0.5rem;">/</span>
    <a href="{{ route('admin.courses.show', $course) }}"
        style="color:var(--gold-pure);text-decoration:none;">{{ Str::limit($course->title, 40) }}</a>
    <span style="margin:0 0.5rem;">/</span>
    <span>Chapters</span>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">

    {{-- Daftar Chapters --}}
    <div>
        <div class="data-section">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-list"></i></div>
                    Chapters ({{ $course->chapters->count() }})
                </div>
                <a href="{{ route('admin.courses.chapters.create', $course) }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Tambah Chapter
                </a>
            </div>

            @forelse($course->chapters->sortBy('order') as $chapter)
            <div style="border-bottom:1px solid rgba(244,196,48,0.08);">
                {{-- Chapter Header --}}
                <div
                    style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;background:rgba(244,196,48,0.04);">
                    <div style="display:flex;align-items:center;gap:0.8rem;">
                        <span
                            style="font-size:0.75rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 8px;border-radius:6px;font-weight:600;">
                            BAB {{ $chapter->order }}
                        </span>
                        <span style="font-weight:600;">{{ $chapter->title }}</span>
                        <span style="font-size:0.75rem;color:var(--text-muted);">({{ $chapter->lessons->count() }}
                            lesson)</span>
                        @if(!$chapter->status)
                        <span class="status inactive" style="font-size:0.7rem;">Hidden</span>
                        @endif
                    </div>
                    <div style="display:flex;gap:0.3rem;">
                        <a href="{{ route('admin.courses.chapters.lessons.create', [$course, $chapter]) }}"
                            class="action-btn success" title="Tambah Lesson">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="{{ route('admin.courses.chapters.edit', [$course, $chapter]) }}" class="action-btn"
                            title="Edit Chapter">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.courses.chapters.destroy', [$course, $chapter]) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus Chapter"
                                data-confirm="Hapus chapter {{ $chapter->title }}? Semua lesson di dalamnya juga akan terhapus.">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Lessons --}}
                @foreach($chapter->lessons->sortBy('order') as $lesson)
                <div
                    style="display:flex;align-items:center;justify-content:space-between;padding:0.8rem 1.5rem 0.8rem 3rem;border-bottom:1px solid rgba(244,196,48,0.04);">
                    <div style="display:flex;align-items:center;gap:0.8rem;">
                        <i class="fas fa-{{ $lesson->file_type === 'video' ? 'play-circle' : ($lesson->file_type === 'pdf' ? 'file-pdf' : 'file') }}"
                            style="color:var(--gold-pure);font-size:0.85rem;"></i>
                        <div>
                            <div style="font-size:0.88rem;">{{ $lesson->title }}</div>
                            <div style="font-size:0.75rem;color:var(--text-muted);">
                                {{ $lesson->duration ?? '-' }}
                                @if($lesson->is_preview)
                                <span style="color:#10B981;margin-left:0.4rem;">• Preview</span>
                                @endif
                                @if(!$lesson->status)
                                <span style="color:#EF4444;margin-left:0.4rem;">• Hidden</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.3rem;">
                        <a href="{{ route('admin.courses.chapters.lessons.edit', [$course, $chapter, $lesson]) }}"
                            class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST"
                            action="{{ route('admin.courses.chapters.lessons.destroy', [$course, $chapter, $lesson]) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Hapus lesson {{ $lesson->title }}?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                @if($chapter->lessons->isEmpty())
                <div style="padding:0.8rem 3rem;font-size:0.82rem;color:var(--text-muted);">
                    Belum ada lesson.
                    <a href="{{ route('admin.courses.chapters.lessons.create', [$course, $chapter]) }}"
                        style="color:var(--gold-pure);">Tambah sekarang</a>
                </div>
                @endif
            </div>
            @empty
            <div class="empty-state" style="padding:3rem;">
                <i class="fas fa-list"></i>
                <p>Belum ada chapter. <a href="{{ route('admin.courses.chapters.create', $course) }}"
                        style="color:var(--gold-pure);">Tambah chapter pertama</a></p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Info Kursus --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-book"></i> Info Kursus</div>
        @if($course->thumbnail)
        <img src="{{ asset('storage/'.$course->thumbnail) }}"
            style="width:100%;border-radius:10px;margin-bottom:1rem;border:1px solid rgba(244,196,48,0.15);">
        @endif
        <div style="font-weight:700;margin-bottom:0.3rem;">{{ $course->title }}</div>
        <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:1rem;">{{ $course->category->name ?? '-' }}
            · {{ $course->level->name ?? '-' }}</div>

        <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.85rem;">
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--text-muted);">Total Chapter</span>
                <span style="font-weight:600;">{{ $course->chapters->count() }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--text-muted);">Total Lesson</span>
                <span style="font-weight:600;">{{ $course->lesson_count }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:var(--text-muted);">Status</span>
                <span class="status {{ $course->status }}">{{ ucfirst($course->status) }}</span>
            </div>
        </div>

        <div
            style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(244,196,48,0.1);display:flex;flex-direction:column;gap:0.5rem;">
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn-secondary"
                style="width:100%;justify-content:center;font-size:0.85rem;">
                <i class="fas fa-edit"></i> Edit Kursus
            </a>
            <a href="{{ route('admin.courses.show', $course) }}" class="btn-secondary"
                style="width:100%;justify-content:center;font-size:0.85rem;">
                <i class="fas fa-eye"></i> Detail Kursus
            </a>
        </div>
    </div>

</div>

@endsection