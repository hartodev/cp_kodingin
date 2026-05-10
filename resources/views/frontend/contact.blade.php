@extends('frontend.layouts.app')

@section('title', 'Kontak')

@section('content')

    <section style="padding:5rem 3rem 8rem;position:relative;z-index:2;">
        <div style="max-width:1100px;margin:0 auto;">

            <div class="reveal" style="text-align:center;margin-bottom:4rem;">
                <span class="section-eyebrow">Kontak</span>
                <h1 class="section-title">Hubungi Kami</h1>
                <p class="section-sub" style="margin:0 auto;">Ada pertanyaan? Kami siap membantu kamu.</p>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start;">

                {{-- Form Kontak --}}
                <div class="reveal">
                    <div
                        style="padding:2.5rem;background:rgba(255,255,255,0.04);border:1px solid rgba(244,196,48,0.15);border-radius:24px;">
                        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:0.5rem;">Kirim Pesan</h2>
                        <p style="font-size:0.88rem;color:var(--text-secondary);margin-bottom:2rem;">Kami akan membalas
                            dalam 1x24 jam.</p>

                        @if (session('success'))
                            <div class="alert alert-success" style="margin-bottom:1.5rem;">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                                <div class="form-group">
                                    <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama kamu"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email <span style="color:#EF4444;">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="kamu@email.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subjek</label>
                                <input type="text" name="subject" class="form-control" placeholder="Topik pesan"
                                    value="{{ old('subject') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pesan <span style="color:#EF4444;">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                                    placeholder="Tulis pesanmu di sini...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-gold" style="width:100%;">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Info Kontak --}}
                <div class="reveal">
                    {{-- Info Cards --}}
                    <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:2rem;">
                        @if ($contactInfo['email'])
                            <div
                                style="display:flex;align-items:center;gap:1rem;padding:1.2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;">
                                <div
                                    style="width:44px;height:44px;background:rgba(244,196,48,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--gold-primary);font-size:1.1rem;flex-shrink:0;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div
                                        style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-secondary);margin-bottom:0.2rem;">
                                        Email</div>
                                    <a href="mailto:{{ $contactInfo['email'] }}"
                                        style="font-weight:600;color:inherit;text-decoration:none;">{{ $contactInfo['email'] }}</a>
                                </div>
                            </div>
                        @endif

                        @if ($contactInfo['phone'])
                            <div
                                style="display:flex;align-items:center;gap:1rem;padding:1.2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;">
                                <div
                                    style="width:44px;height:44px;background:rgba(244,196,48,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--gold-primary);font-size:1.1rem;flex-shrink:0;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <div
                                        style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-secondary);margin-bottom:0.2rem;">
                                        Telepon</div>
                                    <a href="tel:{{ $contactInfo['phone'] }}"
                                        style="font-weight:600;color:inherit;text-decoration:none;">{{ $contactInfo['phone'] }}</a>
                                </div>
                            </div>
                        @endif

                        @if ($contactInfo['address'])
                            <div
                                style="display:flex;align-items:center;gap:1rem;padding:1.2rem;background:rgba(255,255,255,0.03);border:1px solid rgba(244,196,48,0.1);border-radius:16px;">
                                <div
                                    style="width:44px;height:44px;background:rgba(244,196,48,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--gold-primary);font-size:1.1rem;flex-shrink:0;">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <div
                                        style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-secondary);margin-bottom:0.2rem;">
                                        Alamat</div>
                                    <span style="font-weight:600;">{{ $contactInfo['address'] }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Social Links --}}
                    @if ($socialLinks->count())
                        <div style="margin-bottom:2rem;">
                            <div
                                style="font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--gold-primary);font-weight:700;margin-bottom:1rem;">
                                Ikuti Kami</div>
                            <div style="display:flex;gap:0.7rem;flex-wrap:wrap;">
                                @foreach ($socialLinks as $social)
                                    <a href="{{ $social->url }}" target="_blank" rel="noopener"
                                        style="display:flex;align-items:center;gap:0.5rem;padding:0.6rem 1rem;background:rgba(255,255,255,0.04);border:1px solid rgba(244,196,48,0.15);border-radius:50px;text-decoration:none;color:var(--text-secondary);font-size:0.85rem;transition:all 0.3s;"
                                        onmouseover="this.style.color='var(--gold-primary)';this.style.borderColor='var(--gold-primary)'"
                                        onmouseout="this.style.color='var(--text-secondary)';this.style.borderColor='rgba(244,196,48,0.15)'">
                                        <i class="fab {{ $social->icon }}"></i>
                                        {{ $social->platform }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- FAQ --}}
                    @if ($faqs->count())
                        <div>
                            <div
                                style="font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--gold-primary);font-weight:700;margin-bottom:1rem;">
                                Pertanyaan Umum</div>
                            @foreach ($faqs->take(4) as $i => $faq)
                                <div style="border-bottom:1px solid rgba(255,255,255,0.06);padding:0.8rem 0;">
                                    <button
                                        onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='block'?'none':'block'"
                                        style="background:none;border:none;color:var(--text-primary);font-family:'Inter',sans-serif;font-size:0.88rem;font-weight:600;cursor:pointer;text-align:left;width:100%;display:flex;justify-content:space-between;align-items:center;">
                                        {{ $faq->question }}
                                        <i class="fas fa-plus"
                                            style="color:var(--gold-primary);flex-shrink:0;margin-left:0.5rem;font-size:0.75rem;"></i>
                                    </button>
                                    <div
                                        style="display:none;font-size:0.85rem;color:var(--text-secondary);line-height:1.6;padding-top:0.5rem;">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@endsection
