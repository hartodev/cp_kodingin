@extends('admin.layouts.app')

@section('title', 'Level Kursus')
@section('page_title', 'Level Kursus')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    {{-- Tabel Level --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-layer-group"></i></div>
                Semua Level
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Kursus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($levels as $i => $level)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ $level->name }}</td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $level->slug }}</td>
                        <td><span style="font-weight:600;color:var(--gold-pure);">{{ $level->courses_count }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.levels.edit', $level) }}" class="action-btn"><i
                                    class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.levels.destroy', $level) }}"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger"
                                    data-confirm="Hapus level {{ $level->name }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state"><i class="fas fa-layer-group"></i>
                                <p>Belum ada level.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Tambah --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah Level</div>
        <form method="POST" action="{{ route('admin.levels.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Level <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Contoh: Beginner">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Simpan Level
            </button>
        </form>
    </div>

</div>

@endsection