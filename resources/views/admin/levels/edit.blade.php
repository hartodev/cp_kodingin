@extends('admin.layouts.app')

@section('title', 'Edit Level')
@section('page_title', 'Edit Level')

@section('content')
<div style="max-width:480px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Level</div>
        <form method="POST" action="{{ route('admin.levels.update', $level) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Level <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $level->name) }}" placeholder="Nama level">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.levels.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection