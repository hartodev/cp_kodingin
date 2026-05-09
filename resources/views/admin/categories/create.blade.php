@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori')

@section('content')

<div style="max-width:560px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-tags"></i> Kategori Baru</div>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama kategori" autofocus>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon (Font Awesome class)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fa-code">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.3rem;">Contoh: fa-code,
                    fa-mobile-alt, fa-paint-brush</div>
            </div>
            <div class="form-group">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*"
                    onchange="previewImage(this,'imgPreview')">
                <img id="imgPreview" src="" style="display:none;width:100%;border-radius:10px;margin-top:0.8rem;">
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan kategori</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
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