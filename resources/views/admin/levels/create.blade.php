@extends('admin.layouts.app')

@section('title', 'Tambah Level')
@section('page_title', 'Tambah Level')

@section('content')
<div style="max-width:480px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-layer-group"></i> Level Baru</div>
        <form method="POST" action="{{ route('admin.levels.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Level <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Contoh: Beginner" autofocus>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.levels.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection