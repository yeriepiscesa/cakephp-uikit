const breakpoint = 960;
const storageKey = 'uikit.admin.navigation';

function loadNavigation() {
    try { return JSON.parse(localStorage.getItem(storageKey) || '{}'); }
    catch { return {}; }
}

function saveNavigation(sidebar) {
    try {
        const state = loadNavigation();
        if (window.innerWidth <= breakpoint) {
            state.mobileOpen = sidebar.classList.contains('mobile-open');
        } else {
            state.toolbar = document.body.classList.contains('toolbar-mode');
        }
        localStorage.setItem(storageKey, JSON.stringify(state));
    } catch { /* Storage can be unavailable in private or restricted contexts. */ }
}

function isToolbar() {
    return window.innerWidth > breakpoint && document.body.classList.contains('toolbar-mode');
}

function setMenuOpen(link, open) {
    const submenu = link.nextElementSibling;
    if (!submenu || !submenu.matches('.uk-nav-sub')) return;
    submenu.hidden = !open;
    link.parentElement.classList.toggle('uk-open', open);
    link.setAttribute('aria-expanded', String(open));
}

function closeToolbarMenus(sidebar) {
    sidebar.querySelectorAll('.uk-parent > a').forEach(link => setMenuOpen(link, false));
}

function restoreActiveTrail(sidebar) {
    sidebar.querySelectorAll('.uk-parent.uk-active > a').forEach(link => setMenuOpen(link, true));
}

function syncToggle() {
    const sidebar = document.getElementById('adminSidebar');
    const button = document.querySelector('.sidebar-toggle');
    if (!sidebar || !button) return;
    const expanded = window.innerWidth <= breakpoint
        ? sidebar.classList.contains('mobile-open')
        : !document.body.classList.contains('toolbar-mode');
    button.setAttribute('aria-expanded', String(expanded));
    document.body.classList.toggle('mobile-nav-open', window.innerWidth <= breakpoint && expanded);
}

export function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    if (!sidebar) return;
    if (window.innerWidth <= breakpoint) {
        sidebar.classList.toggle('mobile-open');
    } else {
        document.body.classList.toggle('toolbar-mode');
        if (isToolbar()) closeToolbarMenus(sidebar);
        else restoreActiveTrail(sidebar);
    }
    saveNavigation(sidebar);
    syncToggle();
}

export function initAdminNav() {
    const sidebar = document.getElementById('adminSidebar');
    const toggle = document.querySelector('.sidebar-toggle');
    if (!sidebar || !toggle) return;
    const saved = loadNavigation();
    document.body.classList.toggle('toolbar-mode', saved.toolbar === true);
    sidebar.classList.toggle('mobile-open', saved.mobileOpen === true);
    if (isToolbar()) closeToolbarMenus(sidebar);
    syncToggle();
    window.addEventListener('resize', syncToggle);
    document.addEventListener('click', (event) => {
        if (isToolbar() && !sidebar.contains(event.target)) closeToolbarMenus(sidebar);
        if (window.innerWidth <= breakpoint && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
            sidebar.classList.remove('mobile-open');
            saveNavigation(sidebar);
            syncToggle();
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isToolbar()) {
            const openLink = sidebar.querySelector('.uk-parent.uk-open > a');
            if (openLink) { closeToolbarMenus(sidebar); openLink.focus(); }
        }
        if (event.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
            sidebar.classList.remove('mobile-open');
            saveNavigation(sidebar);
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
            const open = submenu.hidden;
            if (open && isToolbar() && link.parentElement.parentElement.matches('.admin-menu > .uk-nav')) {
                closeToolbarMenus(sidebar);
            }
            setMenuOpen(link, open);
        });
    });
}
window.toggleSidebar = toggleSidebar;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminNav);
} else {
    initAdminNav();
}
