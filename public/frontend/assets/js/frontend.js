// ============================================================
//  PanduanFlow — Frontend JS
//  public/frontend/assets/js/frontend.js
//  Diambil dari index.html original + extended untuk multi-page
// ============================================================

(function () {

    // ── Particles ──────────────────────────────────────────────────
    const container = document.getElementById('particles');
    if (container) {
        for (let i = 0; i < 45; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.cssText = `
                left: ${Math.random() * 100}%;
                width: ${Math.random() * 4 + 2}px;
                height: ${Math.random() * 4 + 2}px;
                animation-duration: ${Math.random() * 20 + 12}s;
                animation-delay: ${Math.random() * 20}s;
            `;
            container.appendChild(p);
        }
    }

    // ── Scroll Reveal ──────────────────────────────────────────────
    const obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('active');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(function (el) {
        obs.observe(el);
    });

    document.addEventListener('DOMContentLoaded', function () {

        // ── Navbar scroll effect ────────────────────────────────────
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            window.addEventListener('scroll', function () {
                navbar.classList.toggle('scrolled', window.scrollY > 50);
            });
        }

        // ── Mobile nav toggle ───────────────────────────────────────
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');
        if (navToggle && navMenu) {
            navToggle.addEventListener('click', function () {
                navMenu.classList.toggle('open');
                const icon = navToggle.querySelector('i');
                if (icon) {
                    icon.className = navMenu.classList.contains('open')
                        ? 'fas fa-times'
                        : 'fas fa-bars';
                }
            });
        }

        // ── Active nav link ─────────────────────────────────────────
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(function (link) {
            const href = link.getAttribute('href') || '';
            if (href !== '/' && href !== '#' && currentPath.startsWith(href)) {
                link.classList.add('active');
            } else if ((href === '/' || href === url('/')) && currentPath === '/') {
                link.classList.add('active');
            }
        });

        // ── Auto-hide flash alert ───────────────────────────────────
        document.querySelectorAll('.flash-alert').forEach(function (alert) {
            setTimeout(function () {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function () { alert.remove(); }, 500);
            }, 5000);
        });

        // ── Newsletter form ajax ────────────────────────────────────
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const email = newsletterForm.querySelector('input[name="email"]').value;
                const btn = newsletterForm.querySelector('button[type="submit"]');
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                const orig = btn.innerHTML;

                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                fetch('/newsletter/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email }),
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        btn.innerHTML = '<i class="fas fa-check"></i>';
                        btn.style.background = '#10B981';
                        newsletterForm.querySelector('input[name="email"]').value = '';
                        setTimeout(function () {
                            btn.innerHTML = orig;
                            btn.style.background = '';
                            btn.disabled = false;
                        }, 3000);
                    })
                    .catch(function () {
                        btn.innerHTML = orig;
                        btn.disabled = false;
                    });
            });
        }

        // ── Wishlist toggle ajax ────────────────────────────────────
        document.querySelectorAll('[data-wishlist]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const courseId = btn.getAttribute('data-wishlist');
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                const icon = btn.querySelector('i');

                fetch('/dashboard/wishlist/toggle/' + courseId, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (icon) {
                            icon.className = data.added ? 'fas fa-heart' : 'far fa-heart';
                        }
                        btn.style.color = data.added ? '#EF4444' : '';
                    });
            });
        });

        // ── Cart add ajax ───────────────────────────────────────────
        document.querySelectorAll('[data-add-cart]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const courseId = btn.getAttribute('data-add-cart');
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                const orig = btn.innerHTML;

                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                fetch('/dashboard/cart/add/' + courseId, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        btn.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                        btn.style.background = '#10B981';
                        setTimeout(function () {
                            btn.innerHTML = orig;
                            btn.style.background = '';
                            btn.disabled = false;
                        }, 2000);
                    })
                    .catch(function () {
                        btn.innerHTML = orig;
                        btn.disabled = false;
                    });
            });
        });

    });

})();
