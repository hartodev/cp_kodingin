<div
    style="
    padding: 1.2rem 2.5rem;
    border-top: 1px solid rgba(244,196,48,0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
    font-size: 0.8rem;
    color: var(--text-muted);
">
    <span>
        &copy; {{ date('Y') }} <strong style="color:var(--gold-pure);">PanduanFlow</strong> — Admin Panel
    </span>
    <span>
        Logged in as <strong style="color:var(--text-main);">{{ auth()->user()->name }}</strong>
    </span>
</div>
