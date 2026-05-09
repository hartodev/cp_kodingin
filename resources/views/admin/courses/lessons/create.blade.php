@extends('admin.layouts.app')

@section('title', 'Tambah Lesson')
@section('page_title', 'Tambah Lesson')

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
        <span>Tambah Lesson</span>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-play-circle"></i> Lesson Baru</div>

        <form method="POST" action="{{ route('admin.courses.chapters.lessons.store', [$course, $chapter]) }}">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Judul Lesson <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Contoh: Instalasi & Konfigurasi" autofocus>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipe File <span style="color:#EF4444;">*</span></label>
                    <select name="file_type" class="form-control @error('file_type') is-invalid @enderror">
                        @foreach(['video'=>'Video','audio'=>'Audio','pdf'=>'PDF','doc'=>'Dokumen','file'=>'File
                        Lainnya'] as $val => $label)
                        <option value="{{ $val }}" {{ old('file_type','video') === $val ? 'selected' : '' }}>
                            {{ $label }}</option>
                        @endforeach
                    </select>
                    @error('file_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sumber <span style="color:#EF4444;">*</span></label>
                    <select name="storage" class="form-control @error('storage') is-invalid @enderror">
                        @foreach(['youtube'=>'YouTube','vimeo'=>'Vimeo','external_link'=>'External
                        Link','upload'=>'Upload'] as $val => $label)
                        <option value="{{ $val }}" {{ old('storage','youtube') === $val ? 'selected' : '' }}>
                            {{ $label }}</option>
                        @endforeach
                    </select>
                    @error('storage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">URL / Link Materi</label>
                    <input type="text" name="file_path" class="form-control" value="{{ old('file_path') }}"
                        placeholder="https://youtube.com/watch?v=...">
                </div>

                <div class="form-group">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration') }}"
                        placeholder="Contoh: 15:30">
                </div>

                <div class="form-group">
                    <label class="form-label">Ukuran File</label>
                    <input type="text" name="volume" class="form-control" value="{{ old('volume') }}"
                        placeholder="Contoh: 245 MB">
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Deskripsi singkat isi lesson...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div
                style="display:flex;gap:1.5rem;padding:1rem;background:rgba(244,196,48,0.04);border-radius:10px;margin-bottom:1.5rem;flex-wrap:wrap;">
                <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="is_preview" value="1" {{ old('is_preview') ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Bisa dipreview (tanpa enroll)</span>
                </label>
                <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="downloadable" value="1" {{ old('downloadable') ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Bisa didownload</span>
                </label>
                <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Tampilkan lesson</span>
                </label>
            </div>

            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Lesson</button>
                <a href="{{ route('admin.courses.chapters.index', $course) }}" class="btn-secondary"><i
                        class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection