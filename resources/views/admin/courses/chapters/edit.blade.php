@extends('admin.layouts.app')

@section('title', 'Edit Chapter')
@section('page_title', 'Edit Chapter')

@section('content')

<div style="max-width:600px;">
    <div style="margin-bottom:1.5rem;font-size:0.85rem;color:var(--text-muted);">
        <a href="{{ route('admin.courses.index') }}" style="color:var(--gold-pure);text-decoration:none;">Kursus</a>
        <span style="margin:0 0.5rem;">/</span>
        <a href="{{ route('admin.courses.chapters.index', $course) }}"
            style="color:var(--gold-pure);text-decoration:none;">{{ Str::limit($course->title, 40) }}</a>
        <span style="margin:0 0.5rem;">/</span>
        <span>Edit Chapter</span>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Chapter</div>

        <form method="POST" action="{{ route('admin.courses.chapters.update', [$course, $chapter]) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Judul Chapter <span style="color:#EF4444;">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $chapter->title) }}" placeholder="Judul chapter">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label style="display:flex;align-items:center;gap:0.8rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1"
                        {{ old('status', $chapter->status) ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:16px;height:16px;">
                    <span>Tampilkan chapter ini</span>
                </label>
            </div>

            <div style="display:flex;gap:1rem;margin-top:1.5rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.courses.chapters.index', $course) }}" class="btn-secondary"><i
                        class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection