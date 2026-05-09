@extends('admin.layouts.app')

@section('title', 'Testimoni')
@section('page_title', 'Testimoni')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">

    {{-- Tabel --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-quote-left"></i></div>
                Semua Testimoni ({{ $testimonials->total() }})
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                        <tr>
                            <td style="color:var(--gold-pure);font-weight:700;text-align:center;">{{ $t->order }}</td>
                            <td>
                                <div style="font-weight:600;">{{ $t->name }}</div>
                                @if($t->title)
                                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $t->title }}</div>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;color:var(--text-muted);max-width:200px;">
                                {{ Str::limit($t->review, 60) }}
                            </td>
                            <td>
                                <span style="color:var(--gold-pure);">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fas fa-star" style="font-size:0.75rem;{{ $i <= $t->rating ? '' : 'opacity:0.2;' }}"></i>
                                    @endfor
                                </span>
                            </td>
                            <td>
                                @if($t->status)
                                    <span class="status active">Tampil</span>
                                @else
                                    <span class="status inactive">Hidden</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.testimonials.edit', $t) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn danger" data-confirm="Hapus testimoni ini?">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-quote-left"></i><p>Belum ada testimoni.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($testimonials->hasPages())
            <div class="pagination">{{ $testimonials->links('pagination::simple-default') }}</div>
        @endif
    </div>

    {{-- Form Tambah Cepat --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah Testimoni</div>
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Nama lengkap">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jabatan / Profesi</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                    placeholder="Contoh: Web Developer">
            </div>
            <div class="form-group">
                <label class="form-label">Review <span style="color:#EF4444;">*</span></label>
                <textarea name="review" class="form-control @error('review') is-invalid @enderror"
                    rows="3" placeholder="Isi testimoni...">{{ old('review') }}</textarea>
                @error('review') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Rating <span style="color:#EF4444;">*</span></label>
                <select name="rating" class="form-control @error('rating') is-invalid @enderror">
                    @for($r=5;$r>=1;$r--)
                        <option value="{{ $r }}" {{ old('rating','5') == $r ? 'selected' : '' }}>{{ $r }} Bintang</option>
                    @endfor
                </select>
                @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Foto</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Tampilkan testimoni</span>
                </label>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>

</div>

@endsection
