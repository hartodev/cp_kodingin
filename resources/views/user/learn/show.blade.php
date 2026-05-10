<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $lesson->title }} — {{ $course->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #F4C430;
            --gold-light: #F7D154;
            --dark-1: #0F0F23;
            --dark-2: #1A1A2E;
            --dark-3: #16213E;
            --sidebar-w: 320px;
            --text: rgba(255, 255, 255, 0.95);
            --text-muted: rgba(255, 255, 255, 0.45);
            --border: rgba(244, 196, 48, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-1);
            color: var(--text);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ── TOP BAR ── */
        .learn-topbar {
            height: 56px;
            background: rgba(10, 10, 20, 0.95);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            flex-shrink: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .course-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--gold);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }

        /* ── MAIN AREA ── */
        .learn-body {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        /* ── CONTENT ── */
        .learn-content {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .video-area {
            background: #000;
            position: relative;
        }

        .video-area iframe,
        .video-area video {
            width: 100%;
            aspect-ratio: 16/9;
            display: block;
        }

        .video-placeholder {
            width: 100%;
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, rgba(244, 196, 48, 0.05), rgba(15, 15, 35, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .video-placeholder i {
            font-size: 3rem;
        }

        .lesson-info {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border);
        }

        .lesson-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .lesson-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            flex-wrap: wrap;
        }

        .lesson-body {
            padding: 1.5rem 2rem;
        }

        /* ── SIDEBAR ── */
        .learn-sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            border-left: 1px solid var(--border);
            background: rgba(10, 10, 20, 0.85);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: rgba(10, 10, 20, 0.95);
            z-index: 10;
        }

        .chapter-item {
            border-bottom: 1px solid rgba(244, 196, 48, 0.06);
        }

        .chapter-header {
            padding: 0.8rem 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.02);
            transition: background 0.2s;
        }

        .chapter-header:hover {
            background: rgba(244, 196, 48, 0.04);
        }

        .lesson-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 1.2rem 0.65rem 2rem;
            cursor: pointer;
            font-size: 0.82rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .lesson-item:hover {
            background: rgba(244, 196, 48, 0.04);
            color: var(--text);
        }

        .lesson-item.active {
            background: rgba(244, 196, 48, 0.08);
            color: var(--gold);
        }

        .lesson-item.completed {
            color: rgba(16, 185, 129, 0.8);
        }

        .lesson-item.completed .lesson-check {
            color: #10B981;
        }

        .lesson-check {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.6rem;
        }

        .lesson-item.completed .lesson-check {
            background: rgba(16, 185, 129, 0.2);
            border-color: #10B981;
        }

        .lesson-item.active .lesson-check {
            border-color: var(--gold);
        }

        /* ── PROGRESS ── */
        .progress-bar {
            height: 3px;
            background: rgba(255, 255, 255, 0.08);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            transition: width 0.5s ease;
        }

        /* ── COMPLETE BTN ── */
        .btn-complete {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            background: rgba(16, 185, 129, 0.12);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.25);
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s;
        }

        .btn-complete:hover {
            background: rgba(16, 185, 129, 0.2);
        }

        .btn-complete.done {
            background: rgba(16, 185, 129, 0.2);
        }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-nav:hover {
            background: rgba(244, 196, 48, 0.08);
            border-color: rgba(244, 196, 48, 0.3);
        }

        .btn-nav.gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: var(--dark-1);
            border-color: transparent;
        }

        .btn-nav.gold:hover {
            opacity: 0.9;
        }

        /* ── TABS ── */
        .lesson-tabs {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
        }

        .tab-btn {
            padding: 0.8rem 1.5rem;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--text-muted);
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-btn.active {
            color: var(--gold);
            border-bottom-color: var(--gold);
        }

        .tab-content {
            display: none;
            padding: 1.5rem 2rem;
        }

        .tab-content.active {
            display: block;
        }

        /* Diskusi */
        .discussion-item {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(244, 196, 48, 0.08);
            border-radius: 12px;
            margin-bottom: 0.8rem;
        }

        .discussion-form textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.8rem;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            resize: vertical;
            min-height: 80px;
            outline: none;
        }

        .discussion-form textarea:focus {
            border-color: rgba(244, 196, 48, 0.4);
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 900px) {
            .learn-sidebar {
                position: fixed;
                right: 0;
                top: 56px;
                bottom: 0;
                z-index: 200;
                transform: translateX(100%);
                transition: transform 0.3s;
            }

            .learn-sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: flex;
            }
        }
    </style>
</head>

<body>

    {{-- Top Bar --}}
    <div class="learn-topbar">
        <div class="topbar-left">
            <a href="{{ route('user.my-courses') }}"
                style="width:34px;height:34px;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);text-decoration:none;transition:all 0.2s;"
                title="Kembali">
                <i class="fas fa-arrow-left" style="font-size:0.85rem;"></i>
            </a>
            <span class="course-name">{{ $course->title }}</span>
        </div>

        {{-- Progress bar di tengah --}}
        @php
            $totalL = $course->chapters->flatMap->lessons->count();
            $completedL = collect($progress)->filter()->count();
            $pct = $totalL > 0 ? round(($completedL / $totalL) * 100) : 0;
        @endphp
        <div style="flex:1;max-width:300px;margin:0 2rem;display:flex;align-items:center;gap:0.8rem;">
            <div style="flex:1;height:5px;background:rgba(255,255,255,0.08);border-radius:5px;overflow:hidden;">
                <div id="topProgressFill"
                    style="height:100%;background:linear-gradient(90deg,var(--gold),var(--gold-light));border-radius:5px;transition:width 0.5s;width:{{ $pct }}%;">
                </div>
            </div>
            <span id="topProgressPct"
                style="font-size:0.75rem;font-weight:700;color:var(--gold);white-space:nowrap;">{{ $pct }}%</span>
        </div>

        <div class="topbar-right">
            @if ($canGetCert)
                <a href="{{ route('user.learn.certificate', $course) }}"
                    style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1rem;background:rgba(244,196,48,0.12);border:1px solid rgba(244,196,48,0.3);border-radius:50px;color:var(--gold);font-size:0.8rem;font-weight:700;text-decoration:none;">
                    <i class="fas fa-certificate"></i> Ambil Sertifikat
                </a>
            @endif
            <button class="sidebar-toggle btn-nav"
                onclick="document.querySelector('.learn-sidebar').classList.toggle('open')"
                style="padding:0.5rem 0.9rem;font-size:0.82rem;">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>

    {{-- Body --}}
    <div class="learn-body">

        {{-- Main Content --}}
        <div class="learn-content">

            {{-- Video / Media --}}
            <div class="video-area">
                @if ($lesson->file_path && in_array($lesson->storage, ['youtube', 'vimeo', 'external_link']))
                    @php
                        $embedUrl = $lesson->file_path;
                        if ($lesson->storage === 'youtube') {
                            preg_match('/(?:v=|youtu\.be\/)([^&\?]+)/', $lesson->file_path, $m);
                            $embedUrl = isset($m[1])
                                ? 'https://www.youtube.com/embed/' . $m[1] . '?rel=0'
                                : $lesson->file_path;
                        } elseif ($lesson->storage === 'vimeo') {
                            preg_match('/vimeo\.com\/(\d+)/', $lesson->file_path, $m);
                            $embedUrl = isset($m[1]) ? 'https://player.vimeo.com/video/' . $m[1] : $lesson->file_path;
                        }
                    @endphp
                    <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                @elseif($lesson->file_path && $lesson->storage === 'upload' && $lesson->file_type === 'video')
                    <video controls style="width:100%;aspect-ratio:16/9;">
                        <source src="{{ asset('storage/' . $lesson->file_path) }}">
                    </video>
                @else
                    <div class="video-placeholder">
                        <i
                            class="fas {{ $lesson->file_type === 'pdf' ? 'fa-file-pdf' : ($lesson->file_type === 'audio' ? 'fa-music' : 'fa-book') }}"></i>
                        <span style="font-size:0.9rem;">Materi {{ ucfirst($lesson->file_type ?? 'teks') }}</span>
                        @if ($lesson->file_path)
                            <a href="{{ asset('storage/' . $lesson->file_path) }}" target="_blank"
                                style="padding:0.6rem 1.2rem;background:rgba(244,196,48,0.12);border:1px solid rgba(244,196,48,0.3);border-radius:50px;color:var(--gold);text-decoration:none;font-size:0.85rem;font-weight:600;">
                                <i class="fas fa-external-link-alt" style="margin-right:0.3rem;"></i> Buka Materi
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Lesson Info --}}
            <div class="lesson-info">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
                    <div>
                        <h1 class="lesson-title">{{ $lesson->title }}</h1>
                        <div class="lesson-meta">
                            @if ($lesson->duration)
                                <span><i class="fas fa-clock"
                                        style="color:var(--gold);margin-right:4px;"></i>{{ $lesson->duration }}</span>
                            @endif
                            <span><i class="fas fa-{{ $lesson->file_type === 'video' ? 'play-circle' : 'file' }}"
                                    style="color:var(--gold);margin-right:4px;"></i>{{ ucfirst($lesson->file_type ?? 'materi') }}</span>
                            @if ($lesson->downloadable && $lesson->file_path)
                                <a href="{{ asset('storage/' . $lesson->file_path) }}" download
                                    style="color:var(--gold);text-decoration:none;font-weight:600;">
                                    <i class="fas fa-download" style="margin-right:3px;"></i> Download
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Complete --}}
                    <button id="completeBtn" class="btn-complete {{ $progress[$lesson->id] ?? false ? 'done' : '' }}"
                        onclick="toggleComplete()" data-course="{{ $course->id }}" data-lesson="{{ $lesson->id }}"
                        data-completed="{{ $progress[$lesson->id] ?? false ? '1' : '0' }}">
                        @if ($progress[$lesson->id] ?? false)
                            <i class="fas fa-check-circle"></i> Selesai
                        @else
                            <i class="far fa-circle"></i> Tandai Selesai
                        @endif
                    </button>
                </div>
            </div>

            {{-- Tabs: Deskripsi, Diskusi --}}
            <div>
                <div class="lesson-tabs">
                    <button class="tab-btn active" onclick="showLearnTab('desc')">Deskripsi</button>
                    <button class="tab-btn" onclick="showLearnTab('discuss')">
                        Diskusi ({{ $discussions->count() }})
                    </button>
                    @if ($lesson->downloadable && $lesson->file_path)
                        <button class="tab-btn" onclick="showLearnTab('files')">File</button>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="tab-content active" id="tab-desc">
                    @if ($lesson->description)
                        <div style="font-size:0.9rem;color:var(--text-muted);line-height:1.8;white-space:pre-line;">
                            {{ $lesson->description }}
                        </div>
                    @else
                        <p style="color:var(--text-muted);font-size:0.88rem;">Tidak ada deskripsi untuk materi ini.</p>
                    @endif
                </div>

                {{-- Diskusi --}}
                <div class="tab-content" id="tab-discuss">
                    {{-- Form Tanya --}}
                    <div class="discussion-form"
                        style="margin-bottom:1.5rem;padding:1rem;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:12px;">
                        <div style="font-weight:700;font-size:0.88rem;margin-bottom:0.8rem;">Tulis Pertanyaan</div>
                        <form method="POST" action="{{ route('user.discussions.store', $course) }}">
                            @csrf
                            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                            <div style="margin-bottom:0.8rem;">
                                <input type="text" name="title" placeholder="Judul pertanyaan..."
                                    style="width:100%;background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:8px;padding:0.7rem;color:var(--text);font-family:'Inter',sans-serif;font-size:0.85rem;outline:none;margin-bottom:0.5rem;">
                                <textarea name="body" placeholder="Deskripsikan pertanyaanmu..."></textarea>
                            </div>
                            <button type="submit"
                                style="padding:0.5rem 1.2rem;background:var(--gold);color:var(--dark-1);border:none;border-radius:50px;font-weight:700;font-size:0.82rem;cursor:pointer;font-family:'Inter',sans-serif;">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </form>
                    </div>

                    {{-- List Diskusi --}}
                    @forelse($discussions as $thread)
                        <div class="discussion-item">
                            <div style="display:flex;align-items:center;gap:0.7rem;margin-bottom:0.5rem;">
                                <div
                                    style="width:32px;height:32px;background:linear-gradient(135deg,var(--gold),var(--gold-light));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--dark-1);font-size:0.75rem;flex-shrink:0;">
                                    {{ strtoupper(substr($thread->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <span
                                        style="font-weight:600;font-size:0.85rem;">{{ $thread->user->name ?? '-' }}</span>
                                    <span
                                        style="font-size:0.72rem;color:var(--text-muted);margin-left:0.5rem;">{{ $thread->created_at->diffForHumans() }}</span>
                                </div>
                                @if ($thread->is_solved)
                                    <span
                                        style="margin-left:auto;font-size:0.7rem;color:#10B981;background:rgba(16,185,129,0.1);padding:1px 8px;border-radius:10px;font-weight:700;">Terjawab</span>
                                @endif
                            </div>
                            <div style="font-weight:600;font-size:0.85rem;margin-bottom:0.3rem;">{{ $thread->title }}
                            </div>
                            <div
                                style="font-size:0.82rem;color:var(--text-muted);line-height:1.5;margin-bottom:0.8rem;">
                                {{ Str::limit($thread->body, 150) }}</div>

                            {{-- Replies --}}
                            @if ($thread->replies->count())
                                <div
                                    style="margin-left:1rem;border-left:2px solid rgba(244,196,48,0.2);padding-left:0.8rem;">
                                    @foreach ($thread->replies->take(2) as $reply)
                                        <div
                                            style="padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.04);font-size:0.82rem;">
                                            <span
                                                style="font-weight:600;color:var(--gold);">{{ $reply->user->name ?? '-' }}</span>
                                            <span
                                                style="color:var(--text-muted);margin-left:0.4rem;">{{ $reply->created_at->diffForHumans() }}</span>
                                            @if ($reply->is_answer)
                                                <span
                                                    style="font-size:0.68rem;color:#10B981;background:rgba(16,185,129,0.1);padding:1px 6px;border-radius:8px;margin-left:0.3rem;">Terbaik</span>
                                            @endif
                                            <div style="color:var(--text-muted);margin-top:0.2rem;">
                                                {{ Str::limit($reply->body, 120) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Form Balas --}}
                            <form method="POST" action="{{ route('user.discussions.replies.store', $thread) }}"
                                style="margin-top:0.8rem;display:flex;gap:0.5rem;">
                                @csrf
                                <input type="text" name="body" placeholder="Tulis balasan..."
                                    style="flex:1;background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:50px;padding:0.5rem 1rem;color:var(--text);font-family:'Inter',sans-serif;font-size:0.82rem;outline:none;">
                                <button type="submit"
                                    style="padding:0.5rem 1rem;background:rgba(244,196,48,0.12);border:1px solid rgba(244,196,48,0.2);border-radius:50px;color:var(--gold);font-size:0.78rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;">
                                    Balas
                                </button>
                            </form>
                        </div>
                    @empty
                        <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:0.88rem;">
                            Belum ada diskusi untuk materi ini.
                        </div>
                    @endforelse
                </div>

                {{-- Files --}}
                @if ($lesson->downloadable && $lesson->file_path)
                    <div class="tab-content" id="tab-files">
                        <div
                            style="display:flex;align-items:center;gap:1rem;padding:1rem;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:12px;">
                            <i class="fas fa-file-download" style="font-size:1.5rem;color:var(--gold);"></i>
                            <div style="flex:1;">
                                <div style="font-weight:600;font-size:0.88rem;margin-bottom:0.2rem;">
                                    {{ $lesson->title }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted);">
                                    {{ strtoupper($lesson->file_type) }}</div>
                            </div>
                            <a href="{{ asset('storage/' . $lesson->file_path) }}" download
                                style="padding:0.5rem 1.2rem;background:var(--gold);color:var(--dark-1);border-radius:50px;font-weight:700;font-size:0.82rem;text-decoration:none;">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Nav Prev / Next --}}
            <div
                style="padding:1.5rem 2rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-top:auto;">
                @if ($prevLesson)
                    <a href="{{ route('user.learn.show', [$course, $prevLesson]) }}" class="btn-nav">
                        <i class="fas fa-chevron-left"></i> {{ Str::limit($prevLesson->title, 30) }}
                    </a>
                @else
                    <div></div>
                @endif

                @if ($nextLesson)
                    <a href="{{ route('user.learn.show', [$course, $nextLesson]) }}" class="btn-nav gold">
                        {{ Str::limit($nextLesson->title, 30) }} <i class="fas fa-chevron-right"></i>
                    </a>
                @elseif($canGetCert)
                    <a href="{{ route('user.learn.certificate', $course) }}" class="btn-nav gold">
                        <i class="fas fa-certificate"></i> Ambil Sertifikat
                    </a>
                @endif
            </div>

        </div>

        {{-- Sidebar Kurikulum --}}
        <div class="learn-sidebar" id="learnSidebar">
            <div class="sidebar-header">
                <span>Kurikulum</span>
                <span style="font-size:0.72rem;color:var(--text-muted);" id="sideProgressText">
                    {{ $completedL ?? 0 }}/{{ $totalL ?? 0 }} selesai
                </span>
            </div>

            @foreach ($course->chapters as $chapter)
                <div class="chapter-item">
                    <div class="chapter-header" onclick="toggleChapter('ch-{{ $chapter->id }}')">
                        <span style="font-size:0.82rem;">{{ $chapter->title }}</span>
                        <span
                            style="font-size:0.75rem;color:var(--text-muted);">{{ $chapter->lessons->count() }}</span>
                    </div>
                    <div id="ch-{{ $chapter->id }}"
                        style="{{ $chapter->lessons->contains('id', $lesson->id) ? '' : 'display:none;' }}">
                        @foreach ($chapter->lessons as $l)
                            <a href="{{ route('user.learn.show', [$course, $l]) }}"
                                class="lesson-item {{ $l->id === $lesson->id ? 'active' : '' }} {{ $progress[$l->id] ?? false ? 'completed' : '' }}"
                                id="lesson-item-{{ $l->id }}">
                                <div class="lesson-check" id="check-{{ $l->id }}">
                                    @if ($progress[$l->id] ?? false)
                                        <i class="fas fa-check"></i>
                                    @endif
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $l->title }}</div>
                                    @if ($l->duration)
                                        <div style="font-size:0.72rem;opacity:0.6;margin-top:1px;">{{ $l->duration }}
                                        </div>
                                    @endif
                                </div>
                                @if ($l->is_preview)
                                    <span
                                        style="font-size:0.65rem;color:var(--gold);background:rgba(244,196,48,0.1);padding:1px 6px;border-radius:8px;flex-shrink:0;">P</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;
        const courseId = {{ $course->id }};
        const lessonId = {{ $lesson->id }};
        let isCompleted = {{ $progress[$lesson->id] ?? false ? 'true' : 'false' }};

        // ── Toggle selesai ──────────────────────────────────────────
        function toggleComplete() {
            isCompleted = !isCompleted;
            updateCompleteUI(isCompleted);

            fetch(`/dashboard/learn/${courseId}/${lessonId}/progress`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF
                    },
                    body: JSON.stringify({
                        is_completed: isCompleted
                    }),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        updateProgress(data.percentage);
                    }
                });
        }

        function updateCompleteUI(done) {
            const btn = document.getElementById('completeBtn');
            const checkEl = document.getElementById('check-{{ $lesson->id }}');
            const itemEl = document.getElementById('lesson-item-{{ $lesson->id }}');

            if (done) {
                btn.classList.add('done');
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Selesai';
                if (checkEl) {
                    checkEl.innerHTML = '<i class="fas fa-check"></i>';
                }
                if (itemEl) {
                    itemEl.classList.add('completed');
                }
            } else {
                btn.classList.remove('done');
                btn.innerHTML = '<i class="far fa-circle"></i> Tandai Selesai';
                if (checkEl) {
                    checkEl.innerHTML = '';
                }
                if (itemEl) {
                    itemEl.classList.remove('completed');
                }
            }
        }

        function updateProgress(pct) {
            document.getElementById('topProgressFill').style.width = pct + '%';
            document.getElementById('topProgressPct').textContent = pct + '%';
        }

        // ── Tab ─────────────────────────────────────────────────────
        function showLearnTab(id) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            const content = document.getElementById('tab-' + id);
            if (content) content.classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // ── Toggle chapter ───────────────────────────────────────────
        function toggleChapter(id) {
            const el = document.getElementById(id);
            if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }
    </script>

</body>

</html>
