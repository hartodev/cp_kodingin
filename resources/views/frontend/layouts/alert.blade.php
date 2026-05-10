{{-- Flash Alert — muncul di pojok kanan atas, auto-hide 5 detik --}}
@if (session('success') || session('error') || session('info') || $errors->any())
    <div
        style="position:fixed;top:90px;right:1.5rem;z-index:9999;max-width:380px;width:100%;display:flex;flex-direction:column;gap:0.8rem;">

        @if (session('success'))
            <div class="alert alert-success flash-alert" style="box-shadow:0 10px 30px rgba(16,185,129,0.2);">
                <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger flash-alert" style="box-shadow:0 10px 30px rgba(239,68,68,0.15);">
                <i class="fas fa-times-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info flash-alert" style="box-shadow:0 10px 30px rgba(244,196,48,0.15);">
                <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger flash-alert" style="box-shadow:0 10px 30px rgba(239,68,68,0.15);">
                <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
                <ul style="margin:0;padding-left:1rem;">
                    @foreach ($errors->all() as $error)
                        <li style="font-size:0.88rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endif
