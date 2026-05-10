@extends('user.layouts.app')
@section('title', 'Sertifikat — ' . $course->title)
@section('page_title', 'Sertifikat Kelulusan')

@section('content')

    <div style="max-width:800px;margin:0 auto;">

        {{-- Certificate Card --}}
        <div id="certificateCard"
            style="background:linear-gradient(135deg,#0F0F23 0%,#1A1A2E 50%,#16213E 100%);border:2px solid rgba(244,196,48,0.4);border-radius:24px;padding:4rem;text-align:center;position:relative;overflow:hidden;margin-bottom:2rem;">

            {{-- Dekorasi sudut --}}
            <div
                style="position:absolute;top:1.5rem;left:1.5rem;width:40px;height:40px;border-top:3px solid var(--gold);border-left:3px solid var(--gold);border-radius:4px 0 0 0;">
            </div>
            <div
                style="position:absolute;top:1.5rem;right:1.5rem;width:40px;height:40px;border-top:3px solid var(--gold);border-right:3px solid var(--gold);border-radius:0 4px 0 0;">
            </div>
            <div
                style="position:absolute;bottom:1.5rem;left:1.5rem;width:40px;height:40px;border-bottom:3px solid var(--gold);border-left:3px solid var(--gold);border-radius:0 0 0 4px;">
            </div>
            <div
                style="position:absolute;bottom:1.5rem;right:1.5rem;width:40px;height:40px;border-bottom:3px solid var(--gold);border-right:3px solid var(--gold);border-radius:0 0 4px 0;">
            </div>

            {{-- Logo --}}
            <div
                style="font-size:1.6rem;font-weight:900;background:linear-gradient(135deg,var(--gold),var(--gold-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:0.3rem;">
                {{ \App\Models\Setting::get('site_name', 'PanduanFlow') }}
            </div>
            <div
                style="font-size:0.72rem;letter-spacing:3px;text-transform:uppercase;color:rgba(244,196,48,0.5);margin-bottom:3rem;">
                Certificate of Completion
            </div>

            {{-- Icon --}}
            <div
                style="width:80px;height:80px;background:rgba(244,196,48,0.1);border:2px solid rgba(244,196,48,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 2rem;font-size:2.2rem;">
                🎓
            </div>

            {{-- Nama --}}
            <div
                style="font-size:0.85rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem;letter-spacing:1px;text-transform:uppercase;">
                Dengan bangga diberikan kepada
            </div>
            <div
                style="font-size:2.5rem;font-weight:900;background:linear-gradient(135deg,#fff,var(--gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:0.5rem;line-height:1.2;">
                {{ auth()->user()->name }}
            </div>

            {{-- Teks --}}
            <div style="font-size:0.88rem;color:rgba(255,255,255,0.5);margin-bottom:0.5rem;">telah berhasil menyelesaikan
                kursus</div>
            <div style="font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:2rem;line-height:1.3;">
                {{ $course->title }}
            </div>

            {{-- Meta --}}
            <div style="display:flex;justify-content:center;gap:3rem;flex-wrap:wrap;margin-bottom:2rem;">
                @if ($course->level)
                    <div style="text-align:center;">
                        <div
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:rgba(244,196,48,0.5);margin-bottom:0.3rem;">
                            Level</div>
                        <div style="font-weight:700;font-size:0.88rem;">{{ $course->level->name }}</div>
                    </div>
                @endif
                <div style="text-align:center;">
                    <div
                        style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:rgba(244,196,48,0.5);margin-bottom:0.3rem;">
                        Tanggal</div>
                    <div style="font-weight:700;font-size:0.88rem;">
                        {{ $certificate->issued_at?->format('d M Y') ?? now()->format('d M Y') }}</div>
                </div>
                @if ($course->duration)
                    <div style="text-align:center;">
                        <div
                            style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;color:rgba(244,196,48,0.5);margin-bottom:0.3rem;">
                            Durasi</div>
                        <div style="font-weight:700;font-size:0.88rem;">{{ $course->duration }}</div>
                    </div>
                @endif
            </div>

            {{-- Divider --}}
            <div
                style="width:200px;height:1px;background:linear-gradient(90deg,transparent,rgba(244,196,48,0.5),transparent);margin:0 auto 1.5rem;">
            </div>

            {{-- Nomor Sertifikat --}}
            <div style="font-size:0.72rem;color:rgba(255,255,255,0.3);letter-spacing:1px;">
                No. <strong style="color:rgba(244,196,48,0.7);">{{ $certificate->certificate_number }}</strong>
            </div>
        </div>

        {{-- Aksi --}}
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('user.learn.certificate.download', $course) }}" class="btn-primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <button onclick="printCertificate()" class="btn-secondary">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('user.certificates') }}" class="btn-secondary">
                <i class="fas fa-certificate"></i> Semua Sertifikat
            </a>
            <a href="{{ route('user.my-courses') }}" class="btn-secondary">
                <i class="fas fa-book-open"></i> Kursus Saya
            </a>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function printCertificate() {
            const card = document.getElementById('certificateCard').outerHTML;
            const win = window.open('', '_blank');
            win.document.write(`
        <!DOCTYPE html><html><head>
        <style>
            body { margin: 0; background: #0F0F23; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Inter', sans-serif; }
            :root { --gold: #F4C430; --gold-light: #F7D154; }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap" rel="stylesheet">
        </head><body>${card}</body></html>
    `);
            win.document.close();
            setTimeout(() => {
                win.print();
                win.close();
            }, 800);
        }
    </script>
@endpush
