@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan Website')

@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;">

        {{-- Identitas Website --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-globe"></i> Identitas Website</div>

            <div class="form-group">
                <label class="form-label">Nama Website <span style="color:#EF4444;">*</span></label>
                <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                    value="{{ old('site_name', $settings['site_name'] ?? '') }}" placeholder="PanduanFlow">
                @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tagline</label>
                <input type="text" name="site_tagline" class="form-control"
                    value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                    placeholder="Next Gen Learning Platform">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Website</label>
                <textarea name="site_description" class="form-control" rows="3"
                    placeholder="Deskripsi singkat tentang website...">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Email <span style="color:#EF4444;">*</span></label>
                <input type="email" name="site_email" class="form-control @error('site_email') is-invalid @enderror"
                    value="{{ old('site_email', $settings['site_email'] ?? '') }}" placeholder="hello@panduanflow.com">
                @error('site_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" name="site_phone" class="form-control"
                    value="{{ old('site_phone', $settings['site_phone'] ?? '') }}" placeholder="+62 812-3456-7890">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Alamat</label>
                <input type="text" name="site_address" class="form-control"
                    value="{{ old('site_address', $settings['site_address'] ?? '') }}"
                    placeholder="Kota, Provinsi, Indonesia">
            </div>
        </div>

        {{-- YouTube Channel --}}
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><i class="fab fa-youtube" style="color:#EF4444;"></i> YouTube Channel</div>

                <div class="form-group">
                    <label class="form-label">Nama Channel</label>
                    <input type="text" name="youtube_channel_name" class="form-control"
                        value="{{ old('youtube_channel_name', $settings['youtube_channel_name'] ?? '') }}"
                        placeholder="PanduanFlow">
                </div>

                <div class="form-group">
                    <label class="form-label">URL Channel</label>
                    <input type="url" name="youtube_channel_url" class="form-control"
                        value="{{ old('youtube_channel_url', $settings['youtube_channel_url'] ?? '') }}"
                        placeholder="https://youtube.com/@panduanflow">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Channel ID</label>
                    <input type="text" name="youtube_channel_id" class="form-control"
                        value="{{ old('youtube_channel_id', $settings['youtube_channel_id'] ?? '') }}"
                        placeholder="UC...">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">
                        Digunakan untuk verifikasi otomatis via YouTube API
                    </div>
                </div>
            </div>

            {{-- Logo & Favicon --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><i class="fas fa-image"></i> Logo & Favicon</div>

                <div class="form-group">
                    <label class="form-label">Logo Website</label>
                    @if(!empty($settings['site_logo']))
                        <img src="{{ asset('storage/'.$settings['site_logo']) }}" id="logoPreview"
                            style="height:50px;border-radius:8px;margin-bottom:0.6rem;display:block;">
                    @else
                        <img id="logoPreview" src="" style="display:none;height:50px;border-radius:8px;margin-bottom:0.6rem;">
                    @endif
                    <input type="file" name="site_logo" class="form-control" accept="image/png,image/jpg,image/svg+xml"
                        onchange="previewImage(this,'logoPreview','block')">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">PNG, JPG, SVG. Maks 1MB</div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Favicon</label>
                    @if(!empty($settings['site_favicon']))
                        <img src="{{ asset('storage/'.$settings['site_favicon']) }}" id="faviconPreview"
                            style="width:32px;height:32px;border-radius:4px;margin-bottom:0.6rem;display:block;">
                    @else
                        <img id="faviconPreview" src="" style="display:none;width:32px;height:32px;border-radius:4px;margin-bottom:0.6rem;">
                    @endif
                    <input type="file" name="site_favicon" class="form-control" accept="image/png,image/x-icon"
                        onchange="previewImage(this,'faviconPreview','block')">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">PNG atau ICO. Maks 512KB</div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-search"></i> SEO</div>

            <div class="form-group">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control"
                    value="{{ old('meta_title', $settings['meta_title'] ?? '') }}"
                    placeholder="PanduanFlow - Next Gen Learning Platform" maxlength="255">
            </div>

            <div class="form-group">
                <label class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="2"
                    placeholder="Deskripsi untuk mesin pencari (max 160 karakter)" maxlength="255">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control"
                    value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
                    placeholder="belajar coding, kursus programming, laravel">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Google Analytics ID</label>
                <input type="text" name="google_analytics_id" class="form-control"
                    value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}"
                    placeholder="G-XXXXXXXXXX">
            </div>
        </div>

        {{-- Footer --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-shoe-prints"></i> Footer</div>

            <div class="form-group">
                <label class="form-label">Copyright</label>
                <input type="text" name="footer_copyright" class="form-control"
                    value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}"
                    placeholder="© 2025 PanduanFlow. All rights reserved.">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Deskripsi Footer</label>
                <textarea name="footer_description" class="form-control" rows="2"
                    placeholder="Tagline atau deskripsi singkat di footer...">{{ old('footer_description', $settings['footer_description'] ?? '') }}</textarea>
            </div>
        </div>

    </div>

    {{-- Save Button --}}
    <div style="margin-top:1.5rem;padding:1.5rem;background:rgba(244,196,48,0.04);border:1px solid rgba(244,196,48,0.15);border-radius:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div style="font-size:0.88rem;color:var(--text-muted);">
            <i class="fas fa-info-circle" style="color:var(--gold-pure);margin-right:0.4rem;"></i>
            Perubahan settings akan langsung berlaku setelah disimpan.
        </div>
        <button type="submit" class="btn-primary" style="padding:0.9rem 2.5rem;">
            <i class="fas fa-save"></i> Simpan Semua Pengaturan
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script>
function previewImage(input, id, display) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => { const el = document.getElementById(id); el.src = e.target.result; el.style.display = display; };
        r.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
