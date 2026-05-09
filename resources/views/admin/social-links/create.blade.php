@extends('admin.layouts.app')

@section('title', 'Tambah Social Link')
@section('page_title', 'Tambah Social Link')

@section('content')
<div style="max-width:500px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-share-alt"></i> Social Link Baru</div>
        <form method="POST" action="{{ route('admin.social-links.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Platform <span style="color:#EF4444;">*</span></label>
                <input type="text" name="platform" class="form-control @error('platform') is-invalid @enderror"
                    value="{{ old('platform') }}" placeholder="Instagram" autofocus>
                @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon (Font Awesome brands class)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fa-instagram">
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">fa-instagram · fa-github · fa-youtube · fa-linkedin · fa-x-twitter · fa-facebook</div>
            </div>
            <div class="form-group">
                <label class="form-label">URL <span style="color:#EF4444;">*</span></label>
                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                    value="{{ old('url') }}" placeholder="https://...">
                @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan social link</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('admin.social-links.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
