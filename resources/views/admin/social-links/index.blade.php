@extends('admin.layouts.app')

@section('title', 'Social Links')
@section('page_title', 'Social Links')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">

    {{-- Tabel --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-share-alt"></i></div>
                Semua Social Links ({{ $socialLinks->count() }})
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Platform</th>
                        <th>Icon</th>
                        <th>URL</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($socialLinks as $link)
                        <tr>
                            <td style="color:var(--gold-pure);font-weight:700;text-align:center;">{{ $link->order }}</td>
                            <td style="font-weight:600;">{{ $link->platform }}</td>
                            <td>
                                @if($link->icon)
                                    <div style="width:34px;height:34px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--black-void);">
                                        <i class="fab {{ $link->icon }}"></i>
                                    </div>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $link->url }}" target="_blank"
                                    style="color:var(--gold-pure);text-decoration:none;font-size:0.82rem;">
                                    {{ Str::limit($link->url, 35) }}
                                </a>
                            </td>
                            <td>
                                @if($link->status)
                                    <span class="status active">Aktif</span>
                                @else
                                    <span class="status inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.social-links.edit', $link) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn danger" data-confirm="Hapus social link ini?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-share-alt"></i><p>Belum ada social link.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Tambah --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah Social Link</div>
        <form method="POST" action="{{ route('admin.social-links.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Platform <span style="color:#EF4444;">*</span></label>
                <input type="text" name="platform" class="form-control @error('platform') is-invalid @enderror"
                    value="{{ old('platform') }}" placeholder="Contoh: Instagram">
                @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon (Font Awesome brands)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}"
                    placeholder="fa-instagram">
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">
                    fa-instagram, fa-github, fa-youtube, fa-linkedin, fa-x-twitter
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">URL <span style="color:#EF4444;">*</span></label>
                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                    value="{{ old('url') }}" placeholder="https://instagram.com/...">
                @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan</span>
                </label>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>

</div>

@endsection
