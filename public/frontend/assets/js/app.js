// ===== PARTICLES =====
(function () {
    const c = document.getElementById('particles');
    if (!c) return;
    for (let i = 0; i < 45; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.cssText = `left:${Math.random() * 100}%;animation-duration:${Math.random() * 20 + 12}s;animation-delay:${Math.random() * 20}s;width:${Math.random() * 4 + 2}px;height:${Math.random() * 4 + 2}px;`;
        c.appendChild(p);
    }
})();

// ===== SCROLL REVEAL =====
const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('active');
            obs.unobserve(e.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.reveal').forEach(el => obs.observe(el));