@extends('admin.layouts.app')

@section('title', 'Edit Kursus')
@section('page_title', 'Edit Kursus')

@section('content')

<form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">

        {{-- Kolom Kiri --}}
        <div>
            <div class="card">
                <div class="card-header"><i class="fas fa-book"></i> Informasi Kursus</div>

                <div class="form-group">
                    <label class="form-label">Judul Kursus <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $course->title) }}" placeholder="Judul kursus">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="5"
                        placeholder="Deskripsi lengkap kursus...">{{ old('description', $course->description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="seo_description" class="form-control"
                        value="{{ old('seo_description', $course->seo_description) }}" maxlength="255">
                </div>
            </div>

            <div class="card">
                <div class="card-header"><i class="fas fa-play-circle"></i> Video Demo</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Sumber Video</label>
                        <select name="demo_video_storage" class="form-control">
                            <option value="">Pilih sumber...</option>
                            @foreach(['youtube','vimeo','external_link','upload'] as $opt)
                            <option value="{{ $opt }}"
                                {{ old('demo_video_storage', $course->demo_video_storage) === $opt ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$opt)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">URL / Link Video</label>
                        <input type="text" name="demo_video_source" class="form-control"
                            value="{{ old('demo_video_source', $course->demo_video_source) }}"
                            placeholder="https://...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div>
            <div class="card">
                <div class="card-header"><i class="fas fa-cog"></i> Pengaturan</div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color:#EF4444;">*</span></label>
                    <select name="status" class="form-control">
                        @foreach(['draft','active','inactive'] as $s)
                        <option value="{{ $s }}" {{ old('status', $course->status) === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Level</label>
                    <select name="course_level_id" class="form-control">
                        <option value="">Pilih level...</option>
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}"
                            {{ old('course_level_id', $course->course_level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" class="form-control"
                        value="{{ old('duration', $course->duration) }}" placeholder="Contoh: 10 jam 30 menit">
                </div>

                <div
                    style="display:flex;flex-direction:column;gap:0.8rem;padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    @foreach(['certificate' => 'Berikan sertifikat', 'qna' => 'Aktifkan fitur QnA',
                    'require_youtube_subscribe' => 'Wajib subscribe YouTube'] as $field => $label)
                    <label style="display:flex;align-items:center;gap:0.8rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="{{ $field }}" value="1"
                            {{ old($field, $course->$field) ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);width:16px;height:16px;">
                        <span>{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header"><i class="fas fa-image"></i> Thumbnail</div>
                @if($course->thumbnail)
                <img src="{{ asset('storage/'.$course->thumbnail) }}" id="thumbnailPreview"
                    style="width:100%;border-radius:10px;margin-bottom:0.8rem;border:1px solid rgba(244,196,48,0.15);">
                @else
                <img id="thumbnailPreview" src="" alt=""
                    style="display:none;width:100%;border-radius:10px;margin-bottom:0.8rem;">
                @endif
                <input type="file" name="thumbnail" class="form-control" accept="image/*"
                    onchange="previewImage(this, 'thumbnailPreview')">
            </div>

            <div class="card">
                <div class="card-header"><i class="fas fa-hashtag"></i> Tags</div>
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                    @foreach($tags as $tag)
                    <label
                        style="display:flex;align-items:center;gap:0.4rem;padding:0.4rem 0.8rem;background:rgba(244,196,48,0.08);border:1px solid rgba(244,196,48,0.2);border-radius:20px;cursor:pointer;font-size:0.82rem;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', $course->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);">
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:1rem;margin-top:0.5rem;">
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
        <a href="{{ route('admin.courses.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
    </div>

</form>

@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush