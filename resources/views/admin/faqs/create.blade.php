@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')
@section('page_title', 'Tambah FAQ')

@section('content')
<div style="max-width:600px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-question-circle"></i> FAQ Baru</div>
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Pertanyaan <span style="color:#EF4444;">*</span></label>
                <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
                    value="{{ old('question') }}" placeholder="Pertanyaan yang sering ditanya..." autofocus>
                @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jawaban <span style="color:#EF4444;">*</span></label>
                <textarea name="answer" class="form-control @error('answer') is-invalid @enderror"
                    rows="5" placeholder="Jawaban lengkap dan jelas...">{{ old('answer') }}</textarea>
                @error('answer') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1" checked style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Tampilkan FAQ</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan FAQ</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
