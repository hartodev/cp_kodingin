@extends('admin.layouts.app')

@section('title', 'Tags Kursus')
@section('page_title', 'Tags Kursus')

@section('content')

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    {{-- Tabel Tags --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-hashtag"></i></div>
                Semua Tag
                <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $tags->total() }})</span>
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
                    @forelse($tags as $tag)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $tags->firstItem() + $loop->index }}</td>
                        <td>
                            <span
                                style="padding:0.3rem 0.8rem;background:rgba(244,196,48,0.1);border:1px solid rgba(244,196,48,0.2);border-radius:20px;font-size:0.85rem;color:var(--gold-pure);">
                                {{ $tag->name }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $tag->slug }}</td>
                        <td><span style="font-weight:600;color:var(--gold-pure);">{{ $tag->courses_count }}</span></td>
                        <td>
                            {{-- Inline edit form --}}
                            <form method="POST" action="{{ route('admin.tags.update', $tag) }}"
                                style="display:inline-flex;gap:0.4rem;align-items:center;">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $tag->name }}" class="form-control"
                                    style="max-width:130px;padding:0.4rem 0.7rem;font-size:0.82rem;">
                                <button type="submit" class="action-btn success" title="Update">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger"
                                    data-confirm="Hapus tag {{ $tag->name }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state"><i class="fas fa-hashtag"></i>
                                <p>Belum ada tag.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tags->hasPages())
        <div class="pagination">{{ $tags->links('pagination::simple-default') }}</div>
        @endif
    </div>

    {{-- Form Tambah --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah Tag</div>
        <form method="POST" action="{{ route('admin.tags.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Tag <span style="color:#EF4444;">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Contoh: Laravel">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">
                <i class="fas fa-save"></i> Tambah Tag
            </button>
        </form>
    </div>

</div>

@endsection