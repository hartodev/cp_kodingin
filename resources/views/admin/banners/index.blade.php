@extends('admin.layouts.app')

@section('title', 'Banner')
@section('page_title', 'Banner / Hero')

@section('content')

<div class="data-section" style="margin-bottom:1.5rem;">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-images"></i></div>
            Semua Banner ({{ $banners->count() }})
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Banner
        </a>
    </div>

    @forelse($banners as $banner)
        <div style="padding:1.2rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.07);display:flex;gap:1rem;align-items:center;">
            @if($banner->image)
                <img src="{{ asset('storage/'.$banner->image) }}"
                    style="width:100px;height:56px;border-radius:8px;object-fit:cover;flex-shrink:0;border:1px solid rgba(244,196,48,0.15);">
            @else
                <div style="width:100px;height:56px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--black-void);flex-shrink:0;">
                    <i class="fas fa-images" style="font-size:1.2rem;"></i>
                </div>
            @endif
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;margin-bottom:0.2rem;">{{ $banner->title }}</div>
                @if($banner->subtitle)
                    <div style="font-size:0.8rem;color:var(--text-muted);">{{ Str::limit($banner->subtitle, 60) }}</div>
                @endif
                @if($banner->button_text)
                    <span style="font-size:0.75rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 8px;border-radius:10px;margin-top:0.3rem;display:inline-block;">
                        {{ $banner->button_text }} → {{ $banner->button_url }}
                    </span>
                @endif
            </div>
            <div style="display:flex;align-items:center;gap:0.8rem;flex-shrink:0;">
                <span style="color:var(--gold-pure);font-weight:700;font-size:0.85rem;">#{{ $banner->order }}</span>
                @if($banner->status)
                    <span class="status active">Aktif</span>
                @else
                    <span class="status inactive">Nonaktif</span>
                @endif
                <a href="{{ route('admin.banners.edit', $banner) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="action-btn danger" data-confirm="Hapus banner ini?"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state" style="padding:3rem;">
            <i class="fas fa-images"></i>
            <p>Belum ada banner. <a href="{{ route('admin.banners.create') }}" style="color:var(--gold-pure);">Tambah sekarang</a></p>
        </div>
    @endforelse
</div>

@endsection
