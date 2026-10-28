const breakpoint = 960;

function syncToggle() {
    const sidebar = document.getElementById('adminSidebar');
    const button = document.querySelector('.sidebar-toggle');
    if (!sidebar || !button) return;
    const expanded = window.innerWidth <= breakpoint
        ? sidebar.classList.contains('mobile-open')
        : !document.body.classList.contains('toolbar-mode');
    button.setAttribute('aria-expanded', String(expanded));
}

export function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    if (!sidebar) return;
    if (window.innerWidth <= breakpoint) {
        sidebar.classList.toggle('mobile-open');
    } else {
        document.body.classList.toggle('toolbar-mode');
    }
    syncToggle();
}

export function initAdminNav() {
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.querySelector('.sidebar-toggle');
    if (!sidebar || !toggle) return;
    syncToggle();
    window.addEventListener('resize', syncToggle);
    document.addEventListener('click', (event) => {
        if (window.innerWidth <= breakpoint && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
            sidebar.classList.remove('mobile-open');
            syncToggle();
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
            sidebar.classList.remove('mobile-open');
            syncToggle();
            toggle.focus();
        }
    });
    sidebar.querySelectorAll('.uk-parent > a').forEach((link) => {
        const submenu = link.nextElementSibling;
        if (!submenu || !submenu.matches('.uk-nav-sub')) return;
        link.setAttribute('aria-expanded', String(!submenu.hidden));
        link.addEventListener('click', (event) => {
            event.preventDefault();
            submenu.hidden = !submenu.hidden;
            link.parentElement.classList.toggle('uk-open', !submenu.hidden);
            link.setAttribute('aria-expanded', String(!submenu.hidden));
        });
    });
}
window.toggleSidebar = toggleSidebar;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminNav);
} else {
    initAdminNav();
}
