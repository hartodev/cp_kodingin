@extends('admin.layouts.app')

@section('title', 'Edit Blog')
@section('page_title', 'Edit Blog')

@section('content')

<form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Kiri --}}
        <div>
            <div class="card">
                <div class="card-header"><i class="fas fa-edit"></i> Edit Konten</div>

                <div class="form-group">
                    <label class="form-label">Judul <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $blog->title) }}" placeholder="Judul artikel">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konten <span style="color:#EF4444;">*</span></label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="14" placeholder="Konten blog...">{{ old('description', $blog->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="seo_description" class="form-control"
                        value="{{ old('seo_description', $blog->seo_description) }}" maxlength="255">
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div>
            <div class="card" style="margin-bottom:1.5rem;">
                <div class="card-header"><i class="fas fa-cog"></i> Pengaturan</div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $blog->status ? '1' : '0') === '1' ? 'selected' : '' }}>
                            Publish</option>
                        <option value="0" {{ old('status', $blog->status ? '1' : '0') === '0' ? 'selected' : '' }}>Draft
                        </option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Kategori <span style="color:#EF4444;">*</span></label>
                    <select name="blog_category_id"
                        class="form-control @error('blog_category_id') is-invalid @enderror">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('blog_category_id', $blog->blog_category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('blog_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header"><i class="fas fa-image"></i> Gambar Cover</div>
                @if($blog->image)
                <img src="{{ asset('storage/'.$blog->image) }}" id="imgPreview"
                    style="width:100%;border-radius:10px;margin-bottom:0.8rem;border:1px solid rgba(244,196,48,0.15);">
                @else
                <img id="imgPreview" src="" style="display:none;width:100%;border-radius:10px;margin-bottom:0.8rem;">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*"
                    onchange="previewImage(this,'imgPreview')">
            </div>
        </div>
    </div>

    <div style="display:flex;gap:1rem;margin-top:0.5rem;">
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
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
</script>
@endpush