// UIkit theme JavaScript
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// UIkit CSS
import 'uikit/dist/css/uikit.min.css';

// Import notification handler
import '@js/notifications.js';

// Load UIkit icons
UIkit.use(Icons);

// Make UIkit globally available
window.UIkit = UIkit;

export default UIkit;