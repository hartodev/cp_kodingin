@extends('admin.layouts.app')

@section('title', 'Tambah Kursus')
@section('page_title', 'Tambah Kursus')

@section('content')

<form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">

        {{-- Kolom Kiri --}}
        <div>
            {{-- Informasi Dasar --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-book"></i> Informasi Kursus</div>

                <div class="form-group">
                    <label class="form-label">Judul Kursus <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Contoh: Belajar Laravel dari Nol">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        rows="5"
                        placeholder="Deskripsi lengkap tentang kursus ini...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">SEO Description</label>
                    <input type="text" name="seo_description" class="form-control" value="{{ old('seo_description') }}"
                        placeholder="Deskripsi singkat untuk mesin pencari (max 255 karakter)" maxlength="255">
                </div>
            </div>

            {{-- Video Demo --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-play-circle"></i> Video Demo</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Sumber Video</label>
                        <select name="demo_video_storage" class="form-control" id="videoStorage">
                            <option value="">Pilih sumber...</option>
                            <option value="youtube"
                                {{ old('demo_video_storage') === 'youtube'       ? 'selected' : '' }}>YouTube</option>
                            <option value="vimeo" {{ old('demo_video_storage') === 'vimeo'         ? 'selected' : '' }}>
                                Vimeo</option>
                            <option value="external_link"
                                {{ old('demo_video_storage') === 'external_link' ? 'selected' : '' }}>External Link
                            </option>
                            <option value="upload"
                                {{ old('demo_video_storage') === 'upload'        ? 'selected' : '' }}>Upload</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">URL / Link Video</label>
                        <input type="text" name="demo_video_source" class="form-control"
                            value="{{ old('demo_video_source') }}" placeholder="https://youtube.com/watch?v=...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div>
            {{-- Publish Settings --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-cog"></i> Pengaturan</div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color:#EF4444;">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status', 'draft') === 'draft'    ? 'selected' : '' }}>Draft
                        </option>
                        <option value="active" {{ old('status') === 'active'            ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ old('status') === 'inactive'          ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-control">
                        <option value="">Pilih kategori...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                        <option value="{{ $level->id }}" {{ old('course_level_id') == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration') }}"
                        placeholder="Contoh: 10 jam 30 menit">
                </div>

                {{-- Checkboxes --}}
                <div
                    style="display:flex;flex-direction:column;gap:0.8rem;padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;">
                    <label style="display:flex;align-items:center;gap:0.8rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="certificate" value="1" {{ old('certificate') ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);width:16px;height:16px;">
                        <span>Berikan sertifikat</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:0.8rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="qna" value="1" {{ old('qna') ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);width:16px;height:16px;">
                        <span>Aktifkan fitur QnA</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:0.8rem;cursor:pointer;font-size:0.9rem;">
                        <input type="checkbox" name="require_youtube_subscribe" value="1"
                            {{ old('require_youtube_subscribe', '1') ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);width:16px;height:16px;">
                        <span>Wajib subscribe YouTube</span>
                    </label>
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-image"></i> Thumbnail</div>
                <input type="file" name="thumbnail" class="form-control" accept="image/*"
                    onchange="previewImage(this, 'thumbnailPreview')">
                <img id="thumbnailPreview" src="" alt=""
                    style="display:none;width:100%;border-radius:10px;margin-top:0.8rem;border:1px solid rgba(244,196,48,0.15);">
            </div>

            {{-- Tags --}}
            <div class="card">
                <div class="card-header"><i class="fas fa-hashtag"></i> Tags</div>
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                    @foreach($tags as $tag)
                    <label
                        style="display:flex;align-items:center;gap:0.4rem;padding:0.4rem 0.8rem;background:rgba(244,196,48,0.08);border:1px solid rgba(244,196,48,0.2);border-radius:20px;cursor:pointer;font-size:0.82rem;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                            style="accent-color:var(--gold-pure);">
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol --}}
    <div style="display:flex;gap:1rem;margin-top:0.5rem;">
        <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Simpan Kursus
        </button>
        <a href="{{ route('admin.courses.index') }}" class="btn-secondary">
            <i class="fas fa-times"></i> Batal
        </a>
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