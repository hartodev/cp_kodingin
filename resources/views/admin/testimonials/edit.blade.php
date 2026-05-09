@extends('admin.layouts.app')

@section('title', 'Edit Testimoni')
@section('page_title', 'Edit Testimoni')

@section('content')
<div style="max-width:600px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Testimoni</div>
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group">
                    <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $testimonial->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan / Profesi</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $testimonial->title) }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Review <span style="color:#EF4444;">*</span></label>
                    <textarea name="review" class="form-control" rows="4">{{ old('review', $testimonial->review) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-control">
                        @for($r=5;$r>=1;$r--)
                            <option value="{{ $r }}" {{ old('rating', $testimonial->rating) == $r ? 'selected' : '' }}>{{ $r }} Bintang</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto</label>
                    @if($testimonial->image)
                        <img src="{{ asset('storage/'.$testimonial->image) }}" id="imgPrev"
                            style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-bottom:0.5rem;display:block;">
                    @else
                        <img id="imgPrev" src="" style="display:none;width:60px;height:60px;border-radius:50%;object-fit:cover;margin-bottom:0.5rem;">
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(this,'imgPrev')">
                </div>
                <div class="form-group" style="grid-column:1/-1;margin-bottom:0;">
                    <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="status" value="1"
                            {{ old('status', $testimonial->status) ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);width:15px;height:15px;">
                        <span>Tampilkan testimoni</span>
                    </label>
                </div>
            </div>
            <div style="display:flex;gap:1rem;margin-top:1.5rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
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
