@extends('admin.layouts.app')

@section('title', 'Edit Lesson')
@section('page_title', 'Edit Lesson')

@section('content')

<div style="max-width:760px;">
    <div style="margin-bottom:1.5rem;font-size:0.85rem;color:var(--text-muted);">
        <a href="{{ route('admin.courses.index') }}" style="color:var(--gold-pure);text-decoration:none;">Kursus</a>
        <span style="margin:0 0.5rem;">/</span>
        <a href="{{ route('admin.courses.chapters.index', $course) }}"
            style="color:var(--gold-pure);text-decoration:none;">{{ Str::limit($course->title, 30) }}</a>
        <span style="margin:0 0.5rem;">/</span>
        <span>{{ $chapter->title }}</span>
        <span style="margin:0 0.5rem;">/</span>
        <span>Edit Lesson</span>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Lesson</div>

        <form method="POST" action="{{ route('admin.courses.chapters.lessons.update', [$course, $chapter, $lesson]) }}">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Judul Lesson <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $lesson->title) }}" placeholder="Judul lesson">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipe File <span style="color:#EF4444;">*</span></label>
                    <select name="file_type" class="form-control">
                        @foreach(['video'=>'Video','audio'=>'Audio','pdf'=>'PDF','doc'=>'Dokumen','file'=>'File
                        Lainnya'] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('file_type', $lesson->file_type) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Sumber <span style="color:#EF4444;">*</span></label>
                    <select name="storage" class="form-control">
                        @foreach(['youtube'=>'YouTube','vimeo'=>'Vimeo','external_link'=>'External
                        Link','upload'=>'Upload'] as $val => $label)
                        <option value="{{ $val }}" {{ old('storage', $lesson->storage) === $val ? 'selected' : '' }}>
                            {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">URL / Link Materi</label>
                    <input type="text" name="file_path" class="form-control"
                        value="{{ old('file_path', $lesson->file_path) }}" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" class="form-control"
                        value="{{ old('duration', $lesson->duration) }}" placeholder="15:30">
                </div>

                <div class="form-group">
                    <label class="form-label">Ukuran File</label>
                    <input type="text" name="volume" class="form-control" value="{{ old('volume', $lesson->volume) }}"
                        placeholder="245 MB">
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control"
                        rows="3">{{ old('description', $lesson->description) }}</textarea>
                </div>
            </div>

            <div
                style="display:flex;gap:1.5rem;padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;margin-bottom:1.5rem;flex-wrap:wrap;">
                @foreach(['is_preview'=>'Bisa dipreview (tanpa enroll)','downloadable'=>'Bisa
                didownload','status'=>'Tampilkan lesson'] as $field => $label)
                <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="{{ $field }}" value="1"
                        {{ old($field, $lesson->$field) ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>{{ $label }}</span>
                </label>
                @endforeach
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.courses.chapters.index', $course) }}" class="btn-secondary"><i
                        class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection