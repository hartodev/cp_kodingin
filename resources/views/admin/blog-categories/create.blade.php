@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Blog')
@section('page_title', 'Tambah Kategori Blog')

@section('content')
<div style="max-width:480px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-folder"></i> Kategori Blog Baru</div>
        <form method="POST" action="{{ route('admin.blog-categories.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama kategori" autofocus>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan kategori</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.blog-categories.index') }}" class="btn-secondary"><i class="fas fa-times"></i>
                    Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection