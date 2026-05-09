@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')
@section('page_title', 'Newsletter Subscribers')

@section('content')

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
        <div class="stat-number">{{ \App\Models\Newsletter::count() }}</div>
        <div class="stat-label">Total Subscriber</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-number">{{ \App\Models\Newsletter::where('is_active', true)->count() }}</div>
        <div class="stat-label">Subscriber Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
        <div class="stat-number">{{ \App\Models\Newsletter::where('is_active', false)->count() }}</div>
        <div class="stat-label">Unsubscribed</div>
    </div>
</div>

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.newsletters.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control"
                placeholder="Cari email subscriber..." value="{{ request('search') }}"
                style="max-width:260px;">
            <select name="is_active" class="form-control" style="max-width:160px;">
                <option value="">Semua Status</option>
                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Unsubscribed</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','is_active']))
                <a href="{{ route('admin.newsletters.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-paper-plane"></i></div>
            Semua Subscriber
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $newsletters->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Subscribe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newsletters as $nl)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $newsletters->firstItem() + $loop->index }}</td>
                        <td style="font-weight:500;">{{ $nl->email }}</td>
                        <td>
                            @if($nl->is_active)
                                <span class="status active">Aktif</span>
                            @else
                                <span class="status inactive">Unsubscribed</span>
                            @endif
                        </td>
                        <td style="color:var(--text-muted);font-size:0.85rem;">
                            {{ $nl->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.newsletters.destroy', $nl) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn danger" title="Hapus"
                                    data-confirm="Hapus subscriber {{ $nl->email }}?">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-paper-plane"></i>
                                <p>Belum ada subscriber.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($newsletters->hasPages())
        <div class="pagination">{{ $newsletters->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection
