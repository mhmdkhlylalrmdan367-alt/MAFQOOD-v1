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



document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const input = document.getElementById(button.dataset.passwordToggle);
    button.addEventListener('click', () => {
        const reveal = input.type === 'password';
        input.type = reveal ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(reveal));
        button.setAttribute('aria-label', (reveal ? 'إخفاء ' : 'إظهار ') + input.labels[0].textContent.trim());
        button.firstElementChild.className = reveal ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
    });
});


const messageAlert = document.querySelector('[data-message-alert]');
if (messageAlert) {
    const seen = new Set();
    let polling = false;
    messageAlert.querySelector('[data-message-dismiss]').addEventListener('click', () => {
        messageAlert.hidden = true;
    });

    async function refreshMessages() {
        if (document.hidden || polling) return;
        polling = true;
        try {
            const response = await fetch(messageAlert.dataset.feed, { headers: { Accept: 'application/json' }, cache: 'no-store' });
            if (!response.ok || response.redirected) return;
            const data = await response.json();
            const list = document.querySelector('[data-notification-list]');
            if (list) {
                list.replaceChildren();
                (data.entries || []).forEach((entry) => {
                    const row = document.createElement('div');
                    row.className = 'notification-entry';
                    row.style.background = entry.read ? '' : '#edf5ef';
                    const content = document.createElement(entry.url ? 'a' : 'div');
                    if (entry.url) content.href = entry.url;
                    const title = document.createElement('strong');
                    title.textContent = entry.title;
                    const body = document.createElement('span');
                    body.textContent = entry.body;
                    content.append(title, body);
                    row.append(content);
                    const actions = document.createElement('div');
                    actions.className = 'flex gap-3 mt-2 text-xs';
                    const options = entry.read ? [['حذف', 'DELETE', entry.delete_url]] : [['جعل مقروء', 'PATCH', entry.read_url], ['حذف', 'DELETE', entry.delete_url]];
                    options.forEach(([label, method, url]) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.textContent = label;
                        button.className = 'underline p-1';
                        button.addEventListener('click', async () => {
                            button.disabled = true;
                            try {
                                const response = await fetch(url, {
                                    method,
                                    headers: { Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                                });
                                if (!response.ok) throw new Error('Request failed');
                                await refreshMessages();
                            } catch {
                                button.textContent = 'تعذّر التنفيذ، حاول مجددًا';
                            } finally { button.disabled = false; }
                        });
                        actions.append(button);
                    });
                    row.append(actions);
                    list.append(row);
                });
                if (!list.children.length) {
                    const empty = document.createElement('p');
                    empty.textContent = 'ما عندك إشعارات حاليًا.';
                    list.append(empty);
                }
            }
            const badge = document.querySelector('[data-notification-count]');
            if (badge) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.hidden = !data.count;
            }
            const latest = data.messages.find((message) => !seen.has(message.id));
            data.messages.forEach((message) => seen.add(message.id));
            if (latest && new URL(latest.url, location.origin).pathname !== location.pathname) {
                messageAlert.querySelector('[data-message-sender]').textContent = latest.sender;
                messageAlert.querySelector('[data-message-body]').textContent = latest.body;
                messageAlert.querySelector('[data-message-link]').href = latest.url;
                messageAlert.hidden = false;
            }
        } catch {
            // Retry on the next poll when the connection returns.
        } finally {
            polling = false;
        }
    }
    refreshMessages();
    setInterval(refreshMessages, 5000);
    document.addEventListener('visibilitychange', refreshMessages);
}


const chat = document.querySelector('[data-chat-url]');
if (chat) {
    let busy = false;
    setInterval(async () => {
        if (document.hidden || busy) return;
        busy = true;
        try {
            const response = await fetch(chat.dataset.chatUrl, { headers: { Accept: 'application/json' }, cache: 'no-store' });
            if (!response.ok || response.redirected) return;
            const data = await response.json();
            if (chat.innerHTML !== data.html) {
                const nearBottom = chat.scrollHeight - chat.clientHeight - chat.scrollTop < 80;
                const previousScroll = chat.scrollTop;
                chat.innerHTML = data.html;
                if (!nearBottom) chat.scrollTop = previousScroll;
                if (nearBottom) chat.scrollTop = chat.scrollHeight;
            }
        } catch {
            // Keep the existing conversation visible while offline.
        } finally { busy = false; }
    }, 4000);
}


const notificationMenu = document.querySelector('.notification-menu');
if (notificationMenu) {
    notificationMenu.querySelector('[data-close-notifications]').addEventListener('click', () => notificationMenu.open = false);
    document.addEventListener('click', (event) => {
        if (!notificationMenu.contains(event.target)) notificationMenu.open = false;
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && notificationMenu.open) {
            notificationMenu.open = false;
            notificationMenu.querySelector('summary').focus();
        }
    });
}
const latestButton = document.querySelector('[data-chat-latest]');
if (chat && latestButton) {
    function updateLatest() {
        latestButton.hidden = chat.scrollHeight - chat.scrollTop - chat.clientHeight < 100;
    }
    chat.addEventListener('scroll', updateLatest, { passive: true });
    latestButton.addEventListener('click', () => chat.scrollTo({ top: chat.scrollHeight, behavior: 'smooth' }));
    updateLatest();
}
