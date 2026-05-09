@extends('admin.layouts.app')

@section('title', 'Edit User — ' . $user->name)
@section('page_title', 'Edit User')

@section('content')

<div style="max-width:760px;">

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')

        {{-- Informasi Dasar --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-user"></i> Informasi Dasar</div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group">
                    <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" placeholder="Nama lengkap">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span style="color:#EF4444;">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" placeholder="email@example.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Headline</label>
                <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror"
                    value="{{ old('headline', $user->headline) }}" placeholder="Contoh: Web Developer at Company">
                @error('headline') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3"
                    placeholder="Deskripsi singkat tentang user...">{{ old('bio', $user->bio) }}</textarea>
                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Password --}}
        <div class="card">
            <div class="card-header"><i class="fas fa-lock"></i> Ubah Password <span
                    style="font-size:0.75rem;color:var(--text-muted);font-weight:400;">(kosongkan jika tidak ingin
                    mengubah)</span></div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 8 karakter">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

    </form>
</div>

@endsection