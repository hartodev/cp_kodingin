// ============================================================
//  PanduanFlow — Admin Panel JS
//  public/backend/assets/js/admin.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar toggle ──────────────────────────────────────────────
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const toggleBtn = document.getElementById('sidebarToggle');

    if (toggleBtn && sidebar && mainWrapper) {
        toggleBtn.addEventListener('click', function () {
            const isMobile = window.innerWidth <= 1024;

            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        });

        // Restore sidebar state dari localStorage
        if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth > 1024) {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('sidebar-collapsed');
        }
    }

    // ── Tutup sidebar saat klik overlay di mobile ───────────────────
    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 1024 && sidebar) {
            const clickedInside = sidebar.contains(e.target) || (toggleBtn && toggleBtn.contains(e.target));
            if (!clickedInside && sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });

    // ── Active menu item berdasarkan URL ───────────────────────────
    const currentPath = window.location.pathname;
    document.querySelectorAll('.menu-item').forEach(function (item) {
        const href = item.getAttribute('href');
        if (href && currentPath.startsWith(href) && href !== '/') {
            item.classList.add('active');
        }
    });

    // ── Auto-hide alert setelah 4 detik ────────────────────────────
    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

    // ── Confirm delete ─────────────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            const msg = el.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // ── CSRF token untuk semua fetch/ajax ──────────────────────────
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        window._csrf = csrfToken.getAttribute('content');
    }

    // ── Responsive window resize ───────────────────────────────────
    window.addEventListener('resize', function () {
        if (window.innerWidth > 1024 && sidebar) {
            sidebar.classList.remove('mobile-open');
        }
    });
});
