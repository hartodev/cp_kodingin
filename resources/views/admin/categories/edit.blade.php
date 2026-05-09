@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')

@section('content')

<div style="max-width:560px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Kategori</div>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}" placeholder="Nama kategori">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon (Font Awesome class)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon) }}"
                    placeholder="fa-code">
            </div>
            <div class="form-group">
                <label class="form-label">Gambar</label>
                @if($category->image)
                <img src="{{ asset('storage/'.$category->image) }}" id="imgPreview"
                    style="width:100%;border-radius:10px;margin-bottom:0.8rem;border:1px solid rgba(244,196,48,0.15);">
                @else
                <img id="imgPreview" src="" style="display:none;width:100%;border-radius:10px;margin-bottom:0.8rem;">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*"
                    onchange="previewImage(this,'imgPreview')">
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1"
                        {{ old('status', $category->status) ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan kategori</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary"><i class="fas fa-times"></i>
                    Batal</a>
            </div>
        </form>
    </div>
</div>

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