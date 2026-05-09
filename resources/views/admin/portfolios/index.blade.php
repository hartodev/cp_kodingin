@extends('admin.layouts.app')

@section('title', 'Portfolio')
@section('page_title', 'Portfolio')

@section('content')

<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-briefcase"></i></div>
            Semua Portfolio ({{ $portfolios->count() }})
        </div>
        <a href="{{ route('admin.portfolios.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Portfolio
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Proyek</th>
                    <th>Tipe</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portfolios as $portfolio)
                    <tr>
                        <td style="color:var(--gold-pure);font-weight:700;text-align:center;">
                            {{ $portfolio->order }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.8rem;">
                                @if($portfolio->thumbnail)
                                    <img src="{{ asset('storage/'.$portfolio->thumbnail) }}"
                                        style="width:48px;height:48px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                                @else
                                    <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--black-void);font-size:1.1rem;flex-shrink:0;">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:600;">{{ $portfolio->title }}</div>
                                    <div style="font-size:0.78rem;color:var(--text-muted);">
                                        {{ Str::limit($portfolio->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="padding:0.3rem 0.8rem;background:rgba(244,196,48,0.1);border:1px solid rgba(244,196,48,0.2);border-radius:20px;font-size:0.8rem;color:var(--gold-pure);">
                                {{ ucfirst($portfolio->type) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:0.5rem;">
                                @if($portfolio->project_url)
                                    <a href="{{ $portfolio->project_url }}" target="_blank" class="action-btn" title="Demo">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                                @if($portfolio->github_url)
                                    <a href="{{ $portfolio->github_url }}" target="_blank" class="action-btn" title="GitHub">
                                        <i class="fab fa-github"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($portfolio->status)
                                <span class="status active">Tampil</span>
                            @else
                                <span class="status inactive">Hidden</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus"
                                    data-confirm="Hapus portfolio {{ $portfolio->title }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-briefcase"></i>
                                <p>Belum ada portfolio. <a href="{{ route('admin.portfolios.create') }}" style="color:var(--gold-pure);">Tambah sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
