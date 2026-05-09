@extends('admin.layouts.app')

@section('title', 'Kategori Kursus')
@section('page_title', 'Kategori Kursus')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">

    {{-- Tabel Kategori --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-tags"></i></div>
                Semua Kategori
                <span
                    style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $categories->total() }})</span>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Kursus</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td style="color:var(--text-muted);font-size:0.85rem;">
                            {{ $categories->firstItem() + $loop->index }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.7rem;">
                                @if($cat->icon)
                                <div
                                    style="width:34px;height:34px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--black-void);font-size:0.85rem;">
                                    <i class="fas {{ $cat->icon }}"></i>
                                </div>
                                @endif
                                <span style="font-weight:600;">{{ $cat->name }}</span>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $cat->slug }}</td>
                        <td>
                            <span style="font-weight:600;color:var(--gold-pure);">{{ $cat->courses_count }}</span>
                        </td>
                        <td>
                            @if($cat->status)
                            <span class="status active">Aktif</span>
                            @else
                            <span class="status inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus"
                                    data-confirm="Hapus kategori {{ $cat->name }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-tags"></i>
                                <p>Belum ada kategori.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="pagination">{{ $categories->links('pagination::simple-default') }}</div>
        @endif
    </div>

    {{-- Form Tambah Cepat --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah Kategori</div>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Contoh: Web Development">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Icon (Font Awesome)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fa-code">
            </div>
            <div class="form-group">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Aktifkan kategori</span>
                </label>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Simpan Kategori
            </button>
        </form>
    </div>

</div>

@endsection