@extends('admin.layouts.app')

@section('title', 'Detail User — ' . $user->name)
@section('page_title', 'Detail User')

@section('content')

<div style="display:grid;grid-template-columns:320px 1fr;gap:1.5rem;align-items:start;">

    {{-- Kolom Kiri: Profil --}}
    <div>
        {{-- Card Profil --}}
        <div class="card" style="text-align:center;margin-bottom:1.5rem;">
            <div
                style="width:80px;height:80px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--black-void);font-size:1.6rem;margin:0 auto 1rem;">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div style="font-size:1.2rem;font-weight:700;margin-bottom:0.3rem;">{{ $user->name }}</div>
            @if($user->headline)
            <div style="font-size:0.85rem;color:var(--text-muted);margin-bottom:0.8rem;">{{ $user->headline }}</div>
            @endif
            <div style="font-size:0.85rem;color:var(--text-muted);">{{ $user->email }}</div>

            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(244,196,48,0.1);">
                @if($user->is_youtube_verified)
                <span class="status verified"><i class="fab fa-youtube" style="margin-right:4px;"></i>YouTube
                    Verified</span>
                @else
                <span class="status inactive">YouTube Belum Verified</span>
                @endif
            </div>

            <div style="margin-top:1rem;display:flex;gap:0.5rem;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary"
                    style="font-size:0.85rem;padding:0.6rem 1.2rem;">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="font-size:0.85rem;padding:0.6rem 1.2rem;"
                        data-confirm="Yakin ingin menghapus user ini?">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Card Info --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-info-circle"></i> Informasi</div>
            <div style="display:flex;flex-direction:column;gap:0.8rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Gender</span>
                    <span>{{ $user->gender ? ucfirst($user->gender) : '-' }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Bergabung</span>
                    <span>{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Email Verified</span>
                    <span>{{ $user->email_verified_at ? 'Ya' : 'Belum' }}</span>
                </div>
            </div>

            @if($user->github || $user->linkedin || $user->instagram || $user->website)
            <div
                style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(244,196,48,0.1);display:flex;gap:0.8rem;flex-wrap:wrap;">
                @if($user->github)
                <a href="{{ $user->github }}" target="_blank" class="action-btn" title="GitHub"><i
                        class="fab fa-github"></i></a>
                @endif
                @if($user->linkedin)
                <a href="{{ $user->linkedin }}" target="_blank" class="action-btn" title="LinkedIn"><i
                        class="fab fa-linkedin"></i></a>
                @endif
                @if($user->instagram)
                <a href="{{ $user->instagram }}" target="_blank" class="action-btn" title="Instagram"><i
                        class="fab fa-instagram"></i></a>
                @endif
                @if($user->website)
                <a href="{{ $user->website }}" target="_blank" class="action-btn" title="Website"><i
                        class="fas fa-globe"></i></a>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div>
        {{-- Enrollment --}}
        <div class="data-section" style="margin-bottom:1.5rem;">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-graduation-cap"></i></div>
                    Kursus yang Diikuti ({{ $user->enrollments->count() }})
                </div>
            </div>
            @forelse($user->enrollments as $enrollment)
            <div
                style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div>
                    <div style="font-weight:600;font-size:0.9rem;">{{ $enrollment->course->title ?? '-' }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">
                        {{ $enrollment->enrolled_at?->format('d M Y') }}</div>
                </div>
                @if($enrollment->have_access)
                <span class="status active">Aktif</span>
                @else
                <span class="status inactive">Dicabut</span>
                @endif
            </div>
            @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-graduation-cap"></i>
                <p>Belum ada enrollment</p>
            </div>
            @endforelse
        </div>

        {{-- Orders --}}
        <div class="data-section" style="margin-bottom:1.5rem;">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-shopping-cart"></i></div>
                    Riwayat Order ({{ $user->orders->count() }})
                </div>
            </div>
            @forelse($user->orders as $order)
            <div
                style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div>
                    <div style="font-weight:600;font-size:0.9rem;">{{ $order->invoice_id }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">
                        {{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
                <span
                    class="status {{ $order->status === 'verified' ? 'verified' : ($order->status === 'waiting_verification' ? 'waiting' : $order->status) }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
            @empty
            <div class="empty-state" style="padding:2rem;">
                <i class="fas fa-shopping-cart"></i>
                <p>Belum ada order</p>
            </div>
            @endforelse
        </div>

        {{-- Reviews --}}
        <div class="data-section">
            <div class="section-header">
                <div class="section-title">
                    <div class="section-icon"><i class="fas fa-star"></i></div>
                    Review Diberikan ({{ $user->reviews->count() }})
                </div>
            </div>
            @forelse($user->reviews as $review)
            <div style="padding:1rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.05);">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.3rem;">
                    <span style="font-weight:600;font-size:0.9rem;">{{ $review->course->title ?? '-' }}</span>
                    <span style="color:var(--gold-pure);">
                        @for($i = 1; $i <= 5; $i++) <i class="fas fa-star"
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

</div>

@endsection