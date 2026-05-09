@extends('admin.layouts.app')

@section('title', 'Detail Diskusi')
@section('page_title', 'Detail Diskusi')

@section('content')

<div style="max-width:760px;">

    {{-- Thread --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;gap:1rem;">
            <div style="flex:1;">
                <div style="display:flex;gap:0.6rem;margin-bottom:0.6rem;flex-wrap:wrap;">
                    @if($discussion->is_solved)
                        <span class="status verified"><i class="fas fa-check" style="margin-right:4px;"></i>Terjawab</span>
                    @else
                        <span class="status pending">Belum Terjawab</span>
                    @endif
                    @if($discussion->course)
                        <span style="font-size:0.75rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 10px;border-radius:20px;">
                            {{ $discussion->course->title }}
                        </span>
                    @endif
                    @if($discussion->lesson)
                        <span style="font-size:0.75rem;color:var(--text-muted);background:rgba(255,255,255,0.05);padding:2px 10px;border-radius:20px;">
                            <i class="fas fa-play-circle" style="margin-right:3px;"></i>{{ $discussion->lesson->title }}
                        </span>
                    @endif
                </div>
                <h3 style="font-size:1.2rem;font-weight:700;margin-bottom:0.5rem;">{{ $discussion->title }}</h3>
                <div style="font-size:0.85rem;color:var(--text-muted);">
                    Oleh <strong style="color:var(--text-main);">{{ $discussion->user->name ?? '-' }}</strong>
                    · {{ $discussion->created_at->format('d M Y H:i') }}
                </div>
            </div>
            <form method="POST" action="{{ route('admin.discussions.destroy', $discussion) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="font-size:0.82rem;"
                    data-confirm="Hapus thread ini beserta semua balasannya?">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>

        <div style="padding:1.2rem;background:rgba(244,196,48,0.04);border-radius:10px;line-height:1.7;white-space:pre-line;">
            {{ $discussion->body }}
        </div>
    </div>

    {{-- Replies --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-reply"></i></div>
                Balasan ({{ $discussion->replies->count() }})
            </div>
        </div>

        @forelse($discussion->replies as $reply)
            <div style="padding:1.2rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);
                {{ $reply->is_answer ? 'background:rgba(16,185,129,0.04);border-left:3px solid #10B981;' : '' }}">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.6rem;">
                    <div style="display:flex;align-items:center;gap:0.7rem;">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:0.8rem;flex-shrink:0;">
                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:0.88rem;">{{ $reply->user->name ?? '-' }}</div>
                            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $reply->created_at->diffForHumans() }}</div>
                        </div>
                        @if($reply->is_answer)
                            <span style="font-size:0.72rem;color:#10B981;background:rgba(16,185,129,0.1);padding:2px 8px;border-radius:10px;font-weight:600;">
                                <i class="fas fa-check" style="margin-right:3px;"></i>Jawaban Terbaik
                            </span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.discussion-replies.destroy', $reply) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn danger" title="Hapus Balasan"
                            data-confirm="Hapus balasan ini?">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <div style="font-size:0.88rem;color:var(--text-muted);line-height:1.6;white-space:pre-line;">
                    {{ $reply->body }}
                </div>
            </div>
        @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-reply"></i>
                <p>Belum ada balasan.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top:1rem;">
        <a href="{{ route('admin.discussions.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

</div>

@endsection
