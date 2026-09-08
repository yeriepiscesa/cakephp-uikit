import Alpine from 'alpinejs';

// UIkit theme JavaScript
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// UIkit CSS - MUST import before custom CSS
import 'uikit/dist/css/uikit.css';
import '@css/admin.scss';

// Import notification handler
import '@js/notifications.js';

// Import admin navigation functionality
import '@js/admin/nav.js';
// Import admin list table functionality
import '@js/admin/list-table.js';

// Load UIkit icons
UIkit.use(Icons);

// Make UIkit globally available
window.UIkit = UIkit;
window.Alpine = Alpine;

// Don't start Alpine yet - let it start after all components are loaded
// Alpine.start() will be called automatically when DOM is ready
// or manually started in page-specific scripts after component registration

export default UIkit;