<header class="user-header">
    <div style="display:flex;align-items:center;gap:1rem;">
        {{-- Mobile toggle --}}
        <button class="mobile-toggle" onclick="openSidebar()"
            style="background:none;border:none;color:var(--text);font-size:1.2rem;cursor:pointer;">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
    </div>

    <div class="header-actions">
        {{-- Notif --}}
        @php
            $unread = \App\Models\Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp
        <a href="{{ route('user.notifications') }}"
            style="position:relative;width:38px;height:38px;background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);text-decoration:none;transition:all 0.3s;"
            onmouseover="this.style.color='var(--gold)';this.style.borderColor='rgba(244,196,48,0.3)'"
            onmouseout="this.style.color='var(--text-muted)';this.style.borderColor='var(--border)'">
            <i class="fas fa-bell"></i>
            @if ($unread > 0)
                <span
                    style="position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:#EF4444;border-radius:50%;font-size:0.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;">
                    {{ $unread > 9 ? '9+' : $unread }}
                </span>
            @endif
        </a>

        {{-- Cart --}}
        @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
        <a href="{{ route('user.cart') }}"
            style="position:relative;width:38px;height:38px;background:rgba(255,255,255,0.05);border:1px solid var(--border);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);text-decoration:none;transition:all 0.3s;"
            onmouseover="this.style.color='var(--gold)';this.style.borderColor='rgba(244,196,48,0.3)'"
            onmouseout="this.style.color='var(--text-muted)';this.style.borderColor='var(--border)'">
            <i class="fas fa-shopping-cart"></i>
            @if ($cartCount > 0)
                <span
                    style="position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:var(--gold);border-radius:50%;font-size:0.65rem;font-weight:700;color:var(--dark-1);display:flex;align-items:center;justify-content:center;">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

        {{-- User avatar --}}
        <a href="{{ route('user.profile') }}"
            style="width:38px;height:38px;background:linear-gradient(135deg,var(--gold),var(--gold-light));border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--dark-1);font-size:0.85rem;text-decoration:none;flex-shrink:0;">
            @if (auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}"
                    style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            @endif
        </a>
    </div>
</header>
