@extends('admin.layouts.app')

@section('title', 'Tulis Blog')
@section('page_title', 'Tulis Blog')

@section('content')

<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Kiri: Konten --}}
        <div>
            <div class="card">
                <div class="card-header"><i class="fas fa-newspaper"></i> Konten Blog</div>

                <div class="form-group">
                    <label class="form-label">Judul <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Judul artikel blog..." autofocus>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konten <span style="color:#EF4444;">*</span></label>
                    <textarea name="description" id="blogContent"
                        class="form-control @error('description') is-invalid @enderror" rows="14"
                        placeholder="Tulis konten blog di sini...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="seo_description" class="form-control" value="{{ old('seo_description') }}"
                        placeholder="Deskripsi singkat untuk mesin pencari (max 255 karakter)" maxlength="255">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;" id="seoCount">0 / 255
                        karakter</div>
                </div>
            </div>
        </div>

        {{-- Kanan: Settings --}}
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><i class="fas fa-cog"></i> Pengaturan</div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Publish</option>
                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                    <select name="blog_category_id"
                        class="form-control @error('blog_category_id') is-invalid @enderror">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('blog_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header"><i class="fas fa-image"></i> Gambar Cover</div>
                <input type="file" name="image" class="form-control" accept="image/*"
                    onchange="previewImage(this,'imgPreview')">
                <img id="imgPreview" src="" alt=""
                    style="display:none;width:100%;border-radius:10px;margin-top:0.8rem;border:1px solid rgba(244,196,48,0.15);">
            </div>
        </div>
    </div>

    <div style="display:flex;gap:1rem;margin-top:0.5rem;">
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Publish Blog</button>
        <a href="{{ route('admin.blogs.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
    </div>

</form>

@endsection

@push('scripts')
<script>
function previewImage(input, id) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => {
            const el = document.getElementById(id);
            el.src = e.target.result;
            el.style.display = 'block';
        };
        r.readAsDataURL(input.files[0]);
    }
}
const seoInput = document.querySelector('[name="seo_description"]');
const seoCount = document.getElementById('seoCount');
if (seoInput && seoCount) {
    seoInput.addEventListener('input', () => {
        seoCount.textContent = seoInput.value.length + ' / 255 karakter';
    });
}
</script>
@endpush