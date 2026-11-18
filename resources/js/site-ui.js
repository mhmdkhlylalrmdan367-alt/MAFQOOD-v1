// Progressive enhancement for public forms and item galleries only.
const mainImage = document.getElementById('main-image');
document.querySelectorAll('[data-site-thumbnail]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!mainImage) return;
        mainImage.src = button.dataset.siteThumbnail;
        document.querySelectorAll('[data-site-thumbnail]').forEach((thumbnail) => {
            thumbnail.setAttribute('aria-pressed', String(thumbnail === button));
        });
    });
});

document.querySelector('[data-site-errors]')?.focus();

document.querySelectorAll('[data-site-upload]').forEach((input) => {
    const status = document.createElement('p');
    status.className = 'site-upload-status';
    status.setAttribute('role', 'status');
    input.after(status);
    input.addEventListener('change', () => {
        status.textContent = input.files.length
            ? `الملفات المختارة: ${Array.from(input.files, (file) => file.name).join('، ')}`
            : '';
    });
});

const pendingButtons = new Map();
document.querySelectorAll('.site-interior main form, .site-public-guest form').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const button = event.submitter;
        if (event.defaultPrevented || form.method !== 'post' || !button || button.name || !button.textContent.trim()) return;
        pendingButtons.set(button, Array.from(button.childNodes));
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.textContent = 'جارٍ التنفيذ…';
    });
});

window.addEventListener('pageshow', () => {
    pendingButtons.forEach((content, button) => {
        button.replaceChildren(...content);
        button.disabled = false;
        button.removeAttribute('aria-busy');
    });
    pendingButtons.clear();
});
