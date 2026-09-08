/**
 * Admin Navigation and Sidebar functionality
 */

/**
 * Toggle sidebar between minimized and expanded states
 */
export function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const content = document.getElementById('adminContent');
    
    if (window.innerWidth <= 960) {
        // Mobile: slide in/out
        sidebar.classList.toggle('mobile-open');
    } else {
        // Desktop: minimize/expand
        sidebar.classList.toggle('minimized');
        content.classList.toggle('expanded');
        
        // Toggle header/icon display
        const headers = sidebar.querySelectorAll('.uk-nav-header');
        headers.forEach(header => {
            const text = header.querySelector('.menu-text');
            const icon = header.querySelector('.menu-icon');
            if (sidebar.classList.contains('minimized')) {
                text.style.display = 'none';
                icon.style.display = 'inline';
            } else {
                text.style.display = 'inline';
                icon.style.display = 'none';
            }
        });
    }
}

/**
 * Close mobile sidebar when clicking outside
 */
function handleOutsideClick(event) {
    if (window.innerWidth <= 960) {
        const sidebar = document.getElementById('adminSidebar');
        const toggle = document.querySelector('.sidebar-toggle');
        
        if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
            sidebar.classList.remove('mobile-open');
        }
    }
}

/**
 * Initialize submenu toggle functionality
 */
function initializeSubmenuToggle() {
    document.querySelectorAll('.uk-parent > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const sidebar = document.getElementById('adminSidebar');
            if (!sidebar.classList.contains('minimized')) {
                e.preventDefault();
                const parent = this.parentElement;
                const submenu = this.nextElementSibling;
                const arrow = this.querySelector('.menu-arrow');
                
                // Toggle submenu
                if (submenu.hasAttribute('hidden')) {
                    submenu.removeAttribute('hidden');
                    parent.classList.add('uk-open');
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                } else {
                    submenu.setAttribute('hidden', '');
                    parent.classList.remove('uk-open');
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                }
            }
        });
    });
}

/**
 * Initialize all navigation functionality
 */
export function initAdminNav() {
    // Setup outside click handler
    document.addEventListener('click', handleOutsideClick);
    
    // Initialize submenu toggles
    initializeSubmenuToggle();
}

// Make toggleSidebar available globally for onclick handlers
window.toggleSidebar = toggleSidebar;

// Auto-initialize on DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminNav);
} else {
    initAdminNav();
}
