@extends('frontend.layouts.app')

@section('title', 'Portfolio')

@section('content')

    <section style="padding:5rem 3rem 3rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            <div class="reveal">
                <span class="section-eyebrow">Portfolio</span>
                <h1 class="section-title">Karya & Proyek</h1>
                <p class="section-sub">Koleksi proyek yang telah dikerjakan dengan penuh dedikasi</p>
            </div>
        </div>
    </section>

    {{-- Filter Tipe --}}
    @if ($types->count() > 1)
        <section style="padding:0 3rem 2rem;position:relative;z-index:2;">
            <div style="max-width:1200px;margin:0 auto;display:flex;gap:0.5rem;flex-wrap:wrap;">
                <a href="{{ url('/portfolio') }}" class="{{ !request('type') ? 'btn-gold' : 'btn-ghost' }}"
                    style="padding:0.5rem 1.2rem;font-size:0.85rem;border-radius:50px;">
                    Semua
                </a>
                @foreach ($types as $type)
                    <a href="{{ url('/portfolio?type=' . $type) }}"
                        class="{{ request('type') === $type ? 'btn-gold' : 'btn-ghost' }}"
                        style="padding:0.5rem 1.2rem;font-size:0.85rem;border-radius:50px;">
                        {{ ucfirst($type) }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Portfolio Grid --}}
    <section style="padding:0 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:1200px;margin:0 auto;">
            @if ($portfolios->count())
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.5rem;">
                    @foreach ($portfolios as $portfolio)
                        <div class="reveal"
                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(244,196,48,0.1);border-radius:20px;overflow:hidden;transition:all 0.4s;"
                            onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='rgba(244,196,48,0.3)';this.style.boxShadow='0 20px 50px rgba(244,196,48,0.1)'"
                            onmouseout="this.style.transform='';this.style.borderColor='rgba(244,196,48,0.1)';this.style.boxShadow=''">

                            {{-- Thumbnail --}}
                            <div style="height:200px;overflow:hidden;position:relative;">
                                @if ($portfolio->thumbnail)
                                    <img src="{{ asset('storage/' . $portfolio->thumbnail) }}"
                                        style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform=''">
                                @else
                                    <div
                                        style="width:100%;height:100%;background:linear-gradient(135deg,rgba(244,196,48,0.1),rgba(244,196,48,0.05));display:flex;align-items:center;justify-content:center;font-size:4rem;">
                                        {{ ['💻', '📱', '🎨', '⚙️'][array_search($portfolio->type, ['web', 'mobile', 'design', 'other'])] ?? '💻' }}
                                    </div>
                                @endif

                                {{-- Type Badge --}}
                                <span
                                    style="position:absolute;top:1rem;left:1rem;padding:3px 10px;background:rgba(15,15,35,0.8);backdrop-filter:blur(10px);border:1px solid rgba(244,196,48,0.3);border-radius:20px;font-size:0.72rem;font-weight:700;color:var(--gold-primary);text-transform:uppercase;letter-spacing:0.5px;">
                                    {{ ucfirst($portfolio->type) }}
                                </span>
                            </div>

                            {{-- Info --}}
                            <div style="padding:1.5rem;">
                                <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;">{{ $portfolio->title }}
                                </h3>
                                @if ($portfolio->description)
                                    <p
                                        style="font-size:0.85rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1.2rem;">
                                        {{ Str::limit($portfolio->description, 100) }}
                                    </p>
                                @endif

                                <div style="display:flex;gap:0.7rem;flex-wrap:wrap;">
                                    @if ($portfolio->project_url)
                                        <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener"
                                            class="btn-gold" style="padding:0.5rem 1rem;font-size:0.82rem;">
                                            <i class="fas fa-external-link-alt"></i> Demo
                                        </a>
                                    @endif
                                    @if ($portfolio->github_url)
                                        <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener"
                                            class="btn-outline" style="padding:0.5rem 1rem;font-size:0.82rem;">
                                            <i class="fab fa-github"></i> GitHub
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center;padding:6rem 2rem;">
                    <div style="font-size:4rem;margin-bottom:1rem;">🎨</div>
                    <h3 style="font-size:1.3rem;font-weight:700;">Belum ada portfolio</h3>
                </div>
            @endif
        </div>
    </section>

@endsection
