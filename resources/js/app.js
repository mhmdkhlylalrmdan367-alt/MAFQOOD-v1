document.querySelectorAll('[data-report-strip]').forEach((strip) => {
    const track = strip.querySelector('[data-report-track]');
    if (!track || track.children.length < 2) return;

    const desktop = matchMedia('(min-width: 768px) and (hover: hover) and (pointer: fine)');
    const sign = getComputedStyle(track).direction === 'rtl' ? -1 : 1;
    const originals = Array.from(track.children);
    const copies = originals.map((card) => {
        const copy = card.cloneNode(true);
        copy.setAttribute('aria-hidden', 'true');
        copy.querySelector('a').tabIndex = -1;
        return copy;
    });
    track.append(...copies);
    track.style.scrollSnapType = 'none';

    let position = 0;
    let lastFrame = 0;
    let resumeAt = 0;
    let touching = false;

    function pause() {
        resumeAt = performance.now() + 2000;
    }

    track.addEventListener('pointerdown', () => {
        touching = true;
        pause();
    }, { passive: true });

    function release() {
        if (!touching) return;
        touching = false;
        pause();
    }

    window.addEventListener('pointerup', release, { passive: true });
    window.addEventListener('pointercancel', release, { passive: true });
    track.addEventListener('wheel', pause, { passive: true });
    track.addEventListener('scrollend', () => {
        if (performance.now() < resumeAt) pause();
    });

    function animate(now) {
        const elapsed = Math.min(now - lastFrame, 50) / 1000;
        lastFrame = now;
        const loopWidth = Math.abs(copies[0].offsetLeft - originals[0].offsetLeft);
        const current = sign * track.scrollLeft;

        if (touching || now < resumeAt || track.querySelector('a:focus-visible') || !loopWidth) {
            position = current;
        } else {
            const pixelsPerSecond = desktop.matches ? 44 : 30;
            position = (Math.max(0, position) + pixelsPerSecond * elapsed) % loopWidth;
            track.scrollLeft = sign * position;
        }

        requestAnimationFrame(animate);
    }

    requestAnimationFrame(animate);
});


const heroSearch = document.querySelector('[data-hero-search]');

if (heroSearch) {
    const examples = ['حقيبة', 'هاتف', 'لابتوب', 'مفاتيح', 'محفظة', 'هوية', 'ساعة'];
    let currentExample = 0;

    window.setInterval(() => {
        if (document.hidden || heroSearch.value || document.activeElement === heroSearch) return;

        currentExample = (currentExample + 1) % examples.length;
        heroSearch.placeholder = `ماذا تبحث عنه؟ ${examples[currentExample]}`;
    }, 2400);
}

