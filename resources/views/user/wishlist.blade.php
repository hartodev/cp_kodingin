@extends('user.layouts.app')
@section('title', 'Wishlist')
@section('page_title', 'Wishlist')

@section('content')

    @if ($wishlists->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
            @foreach ($wishlists as $wishlist)
                <div class="dash-card" style="display:flex;flex-direction:column;">
                    <div
                        style="height:140px;border-radius:10px;overflow:hidden;margin-bottom:1rem;background:rgba(244,196,48,0.06);display:flex;align-items:center;justify-content:center;">
                        @if ($wishlist->course->thumbnail)
                            <img src="{{ asset('storage/' . $wishlist->course->thumbnail) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fas fa-book" style="font-size:2rem;color:rgba(244,196,48,0.3);"></i>
                        @endif
                    </div>
                    <div style="flex:1;">
                        <span
                            style="font-size:0.7rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--gold);">
                            {{ $wishlist->course->category->name ?? 'Kursus' }}
                        </span>
                        <h3 style="font-size:0.9rem;font-weight:700;margin:0.4rem 0 0.8rem;line-height:1.3;">
                            {{ $wishlist->course->title }}
                        </h3>
                    </div>
                    <div style="display:flex;gap:0.5rem;">
                        <a href="{{ url('/courses/' . $wishlist->course->slug) }}" class="btn-primary"
                            style="flex:1;justify-content:center;font-size:0.82rem;">
                            Lihat Kursus
                        </a>
                        <form method="POST" action="{{ route('user.wishlist.toggle', $wishlist->course) }}">
                            @csrf
                            <button type="submit" class="btn-danger" style="padding:0.6rem 0.9rem;"
                                title="Hapus dari wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($wishlists->hasPages())
            <div style="display:flex;justify-content:center;gap:0.5rem;margin-top:2rem;">
                @if (!$wishlists->onFirstPage())
                    <a href="{{ $wishlists->previousPageUrl() }}" class="btn-secondary"
                        style="padding:0.5rem 1rem;font-size:0.85rem;">← Prev</a>
                @endif
                @if ($wishlists->hasMorePages())
                    <a href="{{ $wishlists->nextPageUrl() }}" class="btn-secondary"
                        style="padding:0.5rem 1rem;font-size:0.85rem;">Next →</a>
                @endif
            </div>
        @endif
    @else
        <div style="text-align:center;padding:5rem 2rem;">
            <i class="far fa-heart" style="font-size:4rem;color:rgba(244,196,48,0.2);margin-bottom:1rem;display:block;"></i>
            <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Wishlist kosong</h3>
            <p style="color:var(--text-muted);margin-bottom:2rem;">Simpan kursus yang kamu minati.</p>
            <a href="{{ url('/courses') }}" class="btn-primary"><i class="fas fa-search"></i> Cari Kursus</a>
        </div>
    @endif

@endsection
