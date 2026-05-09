@extends('admin.layouts.app')

@section('title', 'FAQ')
@section('page_title', 'FAQ')

@section('content')

<div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">

    {{-- Daftar FAQ --}}
    <div class="data-section">
        <div class="section-header">
            <div class="section-title">
                <div class="section-icon"><i class="fas fa-question-circle"></i></div>
                Semua FAQ ({{ $faqs->total() }})
            </div>
            <a href="{{ route('admin.faqs.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        @forelse($faqs as $faq)
            <div style="padding:1.2rem 1.5rem;border-bottom:1px solid rgba(244,196,48,0.07);">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;">
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.5rem;">
                            <span style="font-size:0.72rem;color:var(--gold-pure);background:rgba(244,196,48,0.1);padding:2px 8px;border-radius:6px;font-weight:600;">#{{ $faq->order }}</span>
                            <span style="font-weight:600;font-size:0.95rem;">{{ $faq->question }}</span>
                            @if(!$faq->status)
                                <span class="status inactive" style="font-size:0.7rem;">Hidden</span>
                            @endif
                        </div>
                        <div style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;">
                            {{ Str::limit($faq->answer, 100) }}
                        </div>
                    </div>
                    <div style="display:flex;gap:0.3rem;flex-shrink:0;">
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="action-btn"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" data-confirm="Hapus FAQ ini?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="padding:3rem;">
                <i class="fas fa-question-circle"></i>
                <p>Belum ada FAQ.</p>
            </div>
        @endforelse
        @if($faqs->hasPages())
            <div class="pagination">{{ $faqs->links('pagination::simple-default') }}</div>
        @endif
    </div>

    {{-- Form Tambah Cepat --}}
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i> Tambah FAQ</div>
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Pertanyaan <span style="color:#EF4444;">*</span></label>
                <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
                    value="{{ old('question') }}" placeholder="Pertanyaan yang sering ditanya...">
                @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jawaban <span style="color:#EF4444;">*</span></label>
                <textarea name="answer" class="form-control @error('answer') is-invalid @enderror"
                    rows="4" placeholder="Jawaban lengkap...">{{ old('answer') }}</textarea>
                @error('answer') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.2rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Tampilkan FAQ</span>
                </label>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;"><i class="fas fa-save"></i> Simpan FAQ</button>
        </form>
    </div>

</div>

@endsection
