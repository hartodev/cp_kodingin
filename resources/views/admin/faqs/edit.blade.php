@extends('admin.layouts.app')

@section('title', 'Edit FAQ')
@section('page_title', 'Edit FAQ')

@section('content')
<div style="max-width:600px;">
    <div class="card">
        <div class="card-header"><i class="fas fa-edit"></i> Edit FAQ</div>
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Pertanyaan <span style="color:#EF4444;">*</span></label>
                <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
                    value="{{ old('question', $faq->question) }}" placeholder="Pertanyaan">
                @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Jawaban <span style="color:#EF4444;">*</span></label>
                <textarea name="answer" class="form-control" rows="5">{{ old('answer', $faq->answer) }}</textarea>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:0.7rem;cursor:pointer;font-size:0.9rem;">
                    <input type="checkbox" name="status" value="1"
                        {{ old('status', $faq->status) ? 'checked' : '' }}
                        style="accent-color:var(--gold-pure);width:15px;height:15px;">
                    <span>Tampilkan FAQ</span>
                </label>
            </div>
            <div style="display:flex;gap:1rem;">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
