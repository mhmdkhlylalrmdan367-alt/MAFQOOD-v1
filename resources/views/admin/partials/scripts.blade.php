<script>
(() => {
    const errors = document.querySelector('[data-admin-errors]');
    if (errors) errors.focus();
    const button = document.querySelector('[data-admin-menu]');
    const nav = document.querySelector('.admin-nav');
    const mobile = matchMedia('(max-width: 600px)');
    const setMenu = (open) => {
        document.body.classList.toggle('admin-navigation-open', open);
        button.setAttribute('aria-expanded', String(open));
        button.setAttribute('aria-label', open ? 'إغلاق قائمة الإدارة' : 'فتح قائمة الإدارة');
    };
    document.body.classList.add('admin-navigation-ready');
    button.addEventListener('click', () => setMenu(button.getAttribute('aria-expanded') !== 'true'));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobile.matches && button.getAttribute('aria-expanded') === 'true') {
            setMenu(false);
            button.focus();
        }
    });
    mobile.addEventListener('change', () => {
        if (mobile.matches && nav.contains(document.activeElement)) button.focus();
        setMenu(false);
    });
})();
</script>
