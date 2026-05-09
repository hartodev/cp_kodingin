@extends('admin.layouts.app')

@section('title', 'Tambah Banner')
@section('page_title', 'Tambah Banner')

@section('content')
<div style="max-width:680px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-images"></i> Banner Baru</div>
        <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul <span style="color:#EF4444;">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" placeholder="Judul banner / headline" autofocus>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Subjudul</label>
                <textarea name="subtitle" class="form-control" rows="2"
                    placeholder="Deskripsi pendek di bawah judul...">{{ old('subtitle') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Gambar Banner</label>
                <input type="file" name="image" class="form-control" accept="image/*"
                    onchange="previewImage(this,'imgPrev')">
                <img id="imgPrev" src="" style="display:none;width:100%;border-radius:10px;margin-top:0.8rem;max-height:200px;object-fit:cover;">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group">
                    <label class="form-label">Teks Tombol</label>
                    <input type="text" name="button_text" class="form-control"
                        value="{{ old('button_text') }}" placeholder="Mulai Sekarang">
                </div>
                <div class="form-group">
                    <label class="form-label">URL Tombol</label>
                    <input type="text" name="button_url" class="form-control"
                        value="{{ old('button_url') }}" placeholder="/courses">
                </div>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan banner</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
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
        r.onload = e => { const el = document.getElementById(id); el.src = e.target.result; el.style.display='block'; };
        r.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
