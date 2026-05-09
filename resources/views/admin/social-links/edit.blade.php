@extends('admin.layouts.app')

@section('title', 'Edit Social Link')
@section('page_title', 'Edit Social Link')

@section('content')
<div style="max-width:500px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit Social Link</div>
        <form method="POST" action="{{ route('admin.social-links.update', $socialLink) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Platform <span style="color:#EF4444;">*</span></label>
                <input type="text" name="platform" class="form-control @error('platform') is-invalid @enderror"
                    value="{{ old('platform', $socialLink->platform) }}">
                @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $socialLink->icon) }}" placeholder="fa-instagram">
            </div>
            <div class="form-group">
                <label class="form-label">URL <span style="color:#EF4444;">*</span></label>
                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                    value="{{ old('url', $socialLink->url) }}">
                @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1"
                        {{ old('status', $socialLink->status) ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan social link</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.social-links.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
