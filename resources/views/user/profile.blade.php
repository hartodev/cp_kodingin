@extends('user.layouts.app')
@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')

    <div style="display:grid;grid-template-columns:280px 1fr;gap:1.5rem;align-items:start;">

        {{-- Kartu Profil --}}
        <div class="dash-card" style="text-align:center;">
            <div
                style="width:80px;height:80px;border-radius:50%;margin:0 auto 1rem;overflow:hidden;border:3px solid rgba(244,196,48,0.3);">
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div
                        style="width:100%;height:100%;background:linear-gradient(135deg,var(--gold),var(--gold-light));display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--dark-1);font-size:1.8rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div style="font-size:1.1rem;font-weight:700;margin-bottom:0.2rem;">{{ $user->name }}</div>
            @if ($user->headline)
                <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:0.8rem;">{{ $user->headline }}</div>
            @endif
            <div style="font-size:0.82rem;color:var(--gold);">
                @if ($user->is_youtube_verified)
                    <i class="fab fa-youtube" style="margin-right:4px;"></i> YouTube Verified
                @else
                    <i class="fas fa-clock" style="margin-right:4px;color:var(--text-muted);"></i> <span
                        style="color:var(--text-muted);">Belum Verified</span>
                @endif
            </div>

            {{-- Sosmed --}}
            @if ($user->github || $user->linkedin || $user->instagram || $user->website)
                <div style="display:flex;justify-content:center;gap:0.5rem;margin-top:1rem;flex-wrap:wrap;">
                    @foreach (['github' => 'fab fa-github', 'linkedin' => 'fab fa-linkedin', 'instagram' => 'fab fa-instagram', 'website' => 'fas fa-globe'] as $field => $icon)
                        @if ($user->$field)
                            <a href="{{ $user->$field }}" target="_blank"
                                style="width:34px;height:34px;background:rgba(244,196,48,0.08);border:1px solid rgba(244,196,48,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);text-decoration:none;transition:all 0.3s;"
                                onmouseover="this.style.color='var(--gold)';this.style.borderColor='var(--gold)'"
                                onmouseout="this.style.color='var(--text-muted)';this.style.borderColor='rgba(244,196,48,0.2)'">
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Form Edit --}}
        <div>
            {{-- Tab --}}
            <div
                style="display:flex;gap:0.5rem;margin-bottom:1.5rem;border-bottom:1px solid var(--border);padding-bottom:0;">
                <button onclick="showTab('info')" id="tab-info"
                    style="padding:0.7rem 1.2rem;background:none;border:none;border-bottom:2px solid var(--gold);color:var(--gold);font-family:'Inter',sans-serif;font-size:0.88rem;font-weight:600;cursor:pointer;">
                    Informasi Dasar
                </button>
                <button onclick="showTab('password')" id="tab-password"
                    style="padding:0.7rem 1.2rem;background:none;border:none;border-bottom:2px solid transparent;color:var(--text-muted);font-family:'Inter',sans-serif;font-size:0.88rem;font-weight:600;cursor:pointer;">
                    Ubah Password
                </button>
            </div>

            {{-- Tab Info --}}
            <div id="content-info">
                <div class="dash-card">
                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            <div class="form-group">
                                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email <span style="color:#EF4444;">*</span></label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" style="grid-column:1/-1;">
                                <label class="form-label">Headline</label>
                                <input type="text" name="headline" class="form-control"
                                    value="{{ old('headline', $user->headline) }}"
                                    placeholder="Contoh: Web Developer | Laravel Enthusiast">
                            </div>
                            <div class="form-group" style="grid-column:1/-1;">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">Pilih...</option>
                                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div
                            style="font-size:0.78rem;color:var(--text-muted);margin-bottom:1rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                            Social Media</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                            @foreach (['github' => 'GitHub', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'x' => 'X (Twitter)', 'website' => 'Website'] as $field => $label)
                                <div class="form-group" style="margin-bottom:0.8rem;">
                                    <label class="form-label">{{ $label }}</label>
                                    <input type="url" name="{{ $field }}" class="form-control"
                                        value="{{ old($field, $user->$field) }}" placeholder="https://...">
                                </div>
                            @endforeach
                        </div>

                        <div style="margin-top:1.5rem;">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tab Password --}}
            <div id="content-password" style="display:none;">
                <div class="dash-card">
                    <form method="POST" action="{{ route('user.profile.password') }}">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Password Saat Ini <span style="color:#EF4444;">*</span></label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="••••••••">
                            @error('current_password')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password Baru <span style="color:#EF4444;">*</span></label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru <span
                                    style="color:#EF4444;">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ulangi password baru">
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function showTab(tab) {
            ['info', 'password'].forEach(t => {
                document.getElementById('content-' + t).style.display = t === tab ? 'block' : 'none';
                const btn = document.getElementById('tab-' + t);
                btn.style.color = t === tab ? 'var(--gold)' : 'var(--text-muted)';
                btn.style.borderColor = t === tab ? 'var(--gold)' : 'transparent';
            });
        }
    </script>
@endpush
