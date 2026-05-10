@extends('user.layouts.app')
@section('title', 'Keranjang')
@section('page_title', 'Keranjang')

@section('content')

    @if ($carts->count())
        <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

            {{-- List Kursus --}}
            <div class="dash-card">
                <div style="font-weight:700;margin-bottom:1.2rem;">
                    {{ $carts->count() }} kursus di keranjang
                </div>

                @foreach ($carts as $cart)
                    <div
                        style="display:flex;gap:1rem;align-items:center;padding:1rem;border-radius:12px;background:rgba(255,255,255,0.03);margin-bottom:0.8rem;border:1px solid rgba(244,196,48,0.08);">
                        <div
                            style="width:60px;height:60px;border-radius:10px;overflow:hidden;flex-shrink:0;background:rgba(244,196,48,0.08);display:flex;align-items:center;justify-content:center;">
                            @if ($cart->course->thumbnail)
                                <img src="{{ asset('storage/' . $cart->course->thumbnail) }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <i class="fas fa-book" style="color:var(--gold);"></i>
                            @endif
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div
                                style="font-weight:600;font-size:0.9rem;margin-bottom:0.2rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $cart->course->title }}
                            </div>
                            <div style="font-size:0.78rem;color:var(--text-muted);">
                                {{ $cart->course->category->name ?? '-' }} ·
                                {{ $cart->course->level->name ?? 'Semua Level' }}
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.8rem;flex-shrink:0;">
                            <span style="font-weight:800;color:var(--gold);">GRATIS</span>
                            <form method="POST" action="{{ route('user.cart.destroy', $cart) }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="width:30px;height:30px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:8px;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;"
                                    title="Hapus dari keranjang">
                                    <i class="fas fa-times" style="font-size:0.75rem;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="dash-card" style="position:sticky;top:80px;">
                <div style="font-weight:700;font-size:1rem;margin-bottom:1.2rem;">Ringkasan</div>

                <div style="display:flex;justify-content:space-between;font-size:0.88rem;margin-bottom:0.5rem;">
                    <span style="color:var(--text-muted);">{{ $carts->count() }} kursus</span>
                    <span style="font-weight:700;color:var(--gold);">GRATIS</span>
                </div>

                <div
                    style="padding:1rem;background:rgba(244,196,48,0.06);border:1px solid rgba(244,196,48,0.15);border-radius:10px;margin-bottom:1.2rem;font-size:0.82rem;color:var(--text-muted);line-height:1.6;">
                    <i class="fab fa-youtube" style="color:#EF4444;margin-right:0.4rem;"></i>
                    Setelah checkout, kamu perlu subscribe YouTube channel kami dan upload screenshot sebagai bukti untuk
                    mendapat akses.
                </div>

                <form method="POST" action="{{ route('user.checkout.store') }}">
                    @csrf
                    <button type="submit" class="btn-primary"
                        style="width:100%;justify-content:center;margin-bottom:0.8rem;">
                        <i class="fas fa-check"></i> Checkout Sekarang
                    </button>
                </form>
                <a href="{{ url('/courses') }}" class="btn-secondary"
                    style="width:100%;justify-content:center;font-size:0.85rem;">
                    <i class="fas fa-plus"></i> Tambah Kursus Lagi
                </a>
            </div>
        </div>
    @else
        <div style="text-align:center;padding:5rem 2rem;">
            <i class="fas fa-shopping-cart"
                style="font-size:4rem;color:rgba(244,196,48,0.2);margin-bottom:1rem;display:block;"></i>
            <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Keranjang kosong</h3>
            <p style="color:var(--text-muted);margin-bottom:2rem;">Tambahkan kursus yang kamu inginkan.</p>
            <a href="{{ url('/courses') }}" class="btn-primary"><i class="fas fa-search"></i> Cari Kursus</a>
        </div>
    @endif

@endsection
