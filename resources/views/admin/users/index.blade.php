@extends('admin.layouts.app')

@section('title', 'Manajemen User')
@section('page_title', 'Manajemen User')

@section('content')

{{-- Filter --}}
<div class="data-section" style="margin-bottom:1.5rem;">
    <div style="padding:1.2rem 1.5rem;">
        <form method="GET" action="{{ route('admin.users.index') }}"
            style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..."
                value="{{ request('search') }}" style="max-width:260px;">
            <select name="verified" class="form-control" style="max-width:180px;">
                <option value="">Semua Status YouTube</option>
                <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }}>Sudah Verified</option>
                <option value="no" {{ request('verified') === 'no'  ? 'selected' : '' }}>Belum Verified</option>
            </select>
            <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
            @if(request()->hasAny(['search','verified']))
            <a href="{{ route('admin.users.index') }}" class="btn-secondary"><i class="fas fa-times"></i> Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="data-section">
    <div class="section-header">
        <div class="section-title">
            <div class="section-icon"><i class="fas fa-users"></i></div>
            Semua User
            <span style="font-size:0.8rem;color:var(--text-muted);font-weight:400;">({{ $users->total() }})</span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>YouTube</th>
                    <th>Enrollment</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $users->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.8rem;">
                            <div
                                style="width:40px;height:40px;background:linear-gradient(135deg,var(--gold-pure),var(--gold-glow));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--black-void);font-size:0.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;">{{ $user->name }}</div>
                                @if($user->headline)
                                <div style="font-size:0.78rem;color:var(--text-muted);">
                                    {{ Str::limit($user->headline, 35) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:var(--text-muted);">{{ $user->email }}</td>
                    <td>
                        @if($user->is_youtube_verified)
                        <span class="status verified"><i class="fas fa-check"
                                style="margin-right:4px;"></i>Verified</span>
                        @else
                        <span class="status inactive">Belum</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--gold-pure);">{{ $user->enrollments_count }}</span>
                        <span style="color:var(--text-muted);font-size:0.8rem;"> kursus</span>
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="action-btn" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="action-btn" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn danger" title="Hapus"
                                data-confirm="Yakin ingin menghapus user {{ $user->name }}?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>Belum ada user terdaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="pagination">
        {{ $users->links('pagination::simple-default') }}
    </div>
    @endif
</div>

@endsection