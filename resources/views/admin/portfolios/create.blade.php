@extends('admin.layouts.app')

@section('title', 'Tambah Portfolio')
@section('page_title', 'Tambah Portfolio')

@section('content')

<div style="max-width:760px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-briefcase"></i> Portfolio Baru</div>

        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Judul Proyek <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Contoh: E-Commerce Platform" autofocus>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Deskripsi singkat tentang proyek ini...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Tipe Proyek <span style="color:#EF4444;">*</span></label>
                    <select name="type" class="form-control @error('type') is-invalid @enderror">
                        @foreach(['web'=>'Web','mobile'=>'Mobile','design'=>'Design','other'=>'Other'] as $val => $label)
                            <option value="{{ $val }}" {{ old('type','web') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*"
                        onchange="previewImage(this,'imgPrev')">
                    <img id="imgPrev" src="" style="display:none;width:100%;border-radius:8px;margin-top:0.6rem;">
                </div>

                <div class="form-group">
                    <label class="form-label">Link Demo / Live</label>
                    <input type="url" name="project_url" class="form-control"
                        value="{{ old('project_url') }}" placeholder="https://project.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Link GitHub</label>
                    <input type="url" name="github_url" class="form-control"
                        value="{{ old('github_url') }}" placeholder="https://github.com/user/repo">
                </div>

                <div class="form-group" style="grid-column:1/-1;margin-bottom:0;">
                    <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                        <span>Tampilkan di halaman portfolio</span>
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1.5rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Portfolio</button>
                <a href="{{ route('admin.portfolios.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
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
