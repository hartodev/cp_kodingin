@extends('user.layouts.app')
@section('title', 'Sertifikat')
@section('page_title', 'Sertifikat Saya')

@section('content')

    @if ($certificates->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
            @foreach ($certificates as $cert)
                <div class="dash-card" style="position:relative;overflow:hidden;">
                    {{-- Dekorasi --}}
                    <div
                        style="position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,var(--gold),var(--gold-light));">
                    </div>

                    <div style="text-align:center;padding:1rem 0;">
                        <i class="fas fa-certificate"
                            style="font-size:3rem;color:var(--gold);margin-bottom:1rem;display:block;filter:drop-shadow(0 4px 12px rgba(244,196,48,0.3));"></i>
                        <div
                            style="font-size:0.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:0.5rem;">
                            Sertifikat Kelulusan</div>
                        <h3 style="font-size:0.95rem;font-weight:700;line-height:1.3;margin-bottom:0.8rem;">
                            {{ $cert->course->title }}</h3>
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">
                            No. <strong style="color:var(--text);">{{ $cert->certificate_number }}</strong>
                        </div>
                        <div style="font-size:0.78rem;color:var(--text-muted);">
                            Diterbitkan {{ $cert->issued_at?->format('d M Y') ?? '-' }}
                        </div>
                    </div>

                    <div style="display:flex;gap:0.5rem;margin-top:1rem;">
                        <a href="{{ route('user.learn.certificate', $cert->course) }}" class="btn-primary"
                            style="flex:1;justify-content:center;font-size:0.82rem;">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        <a href="{{ route('user.learn.certificate.download', $cert->course) }}" class="btn-secondary"
                            style="font-size:0.82rem;padding:0.6rem 0.9rem;">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align:center;padding:5rem 2rem;">
            <i class="fas fa-certificate"
                style="font-size:4rem;color:rgba(244,196,48,0.2);margin-bottom:1rem;display:block;"></i>
            <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:0.5rem;">Belum ada sertifikat</h3>
            <p style="color:var(--text-muted);margin-bottom:2rem;">Selesaikan semua materi kursus untuk mendapatkan
                sertifikat.</p>
            <a href="{{ route('user.my-courses') }}" class="btn-primary"><i class="fas fa-book-open"></i> Lihat Kursus
                Saya</a>
        </div>
    @endif

@endsection
