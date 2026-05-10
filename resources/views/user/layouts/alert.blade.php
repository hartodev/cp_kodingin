@if (session('success') || session('error') || session('info') || $errors->any())
    <div style="padding:1rem 2rem 0;">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-times-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
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
