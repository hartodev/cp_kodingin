@extends('admin.layouts.app')

@section('title', 'Manajemen Order')
@section('page_title', 'Manajemen Order')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.orders.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari invoice atau nama user..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                @foreach(['pending','waiting_verification','verified','failed','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_',' ',$s)) }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-shopping-cart"></i></div>
            Semua Order
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $orders->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>User</th>
                    <th>Kursus</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.85rem;">{{ $orders->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <span style="font-weight:600;font-family:monospace;font-size:0.85rem;">
                            {{ $order->invoice_id }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.88rem;">{{ $order->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td style="font-size:0.85rem;color:var(--text-muted);">
                        {{ $order->items->count() }} kursus
                    </td>
                    <td>
                        @php
                        $statusClass = match($order->status) {
                        'verified' => 'verified',
                        'waiting_verification' => 'waiting',
                        'failed','cancelled' => 'inactive',
                        default => 'pending',
                        };
                        @endphp
                        <span class="status {{ $statusClass }}">
                            {{ ucfirst(str_replace('_',' ',$order->status)) }}
                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Belum ada order.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="pagination">{{ $orders->links('pagination::simple-default') }}</div>
    @endif
</div>

@endsection