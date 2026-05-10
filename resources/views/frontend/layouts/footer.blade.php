{{-- Footer — sama persis dengan desain index.html tapi dinamis dari Setting & SocialLink --}}
@php
    $siteName   = \App\Models\Setting::get('site_name', 'PanduanFlow');
    $footerDesc = \App\Models\Setting::get('footer_description', 'Future of learning. Designed for the next generation of professionals.');
    $footerCopy = \App\Models\Setting::get('footer_copyright', '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.');
    $ytUrl      = \App\Models\Setting::get('youtube_channel_url');
    $socials    = \App\Models\SocialLink::where('status', true)->orderBy('order')->get();
@endphp

<footer class="footer reveal">

    <div class="footer-grid">

        {{-- Brand --}}
        <div>
            <div class="footer-logo">{{ $siteName }}</div>
            <p class="footer-desc">{{ $footerDesc }}</p>

            {{-- Social links dinamis --}}
            @if($socials->count())
                <div class="footer-social">
                    @foreach($socials as $s)
                        <a href="{{ $s->url }}" target="_blank" rel="noopener" title="{{ $s->platform }}">
                            <i class="fab {{ $s->icon }}"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Platform --}}
        <div>
            <div class="footer-heading">Platform</div>
            <ul class="footer-links">
                <li><a href="{{ url('/courses') }}">Kursus</a></li>
                <li><a href="{{ url('/blog') }}">Blog & Panduan</a></li>
                <li><a href="{{ url('/portfolio') }}">Portfolio</a></li>
                <li><a href="{{ url('/contact') }}">Kontak</a></li>
            </ul>
        </div>

        {{-- Akun --}}
        <div>
            <div class="footer-heading">Akun</div>
            <ul class="footer-links">
                @auth
                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('user.my-courses') }}">Kursus Saya</a></li>
                    <li><a href="{{ route('user.profile') }}">Profil</a></li>
                    <li><a href="{{ route('user.certificates') }}">Sertifikat</a></li>
                @else
                    <li><a href="{{ route('auth.login') }}">Masuk</a></li>
                    <li><a href="{{ route('auth.register') }}">Daftar Gratis</a></li>
                @endauth
            </ul>
        </div>

        {{-- Info & Newsletter --}}
        <div>
            <div class="footer-heading">Info</div>
            <ul class="footer-links" style="margin-bottom:1.5rem;">
                @if($ytUrl)
                    <li>
                        <a href="{{ $ytUrl }}" target="_blank" rel="noopener">
                            <i class="fab fa-youtube" style="color:#EF4444;margin-right:0.4rem;"></i> YouTube Channel
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('/contact') }}">Hubungi Kami</a>
                </li>
                @php $email = \App\Models\Setting::get('site_email'); @endphp
                @if($email)
                    <li><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                @endif
            </ul>

            {{-- Newsletter mini --}}
            <div style="font-size:0.72rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:0.8rem;">
                Subscribe Newsletter
            </div>
            <form id="newsletterForm">
                @csrf
                <div class="newsletter-input-wrap" style="max-width:100%;">
                    <input type="email" name="email" class="newsletter-input" placeholder="Email kamu...">
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <div class="footer-bottom">
        <span class="footer-copy">{{ $footerCopy }}</span>
        <span class="footer-copy">Made with <span style="color:var(--gold-primary);">♥</span> in Indonesia</span>
    </div>

</footer>
