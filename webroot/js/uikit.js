// UIkit theme JavaScript
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// UIkit CSS
import 'uikit/dist/css/uikit.min.css';

// Load UIkit icons
UIkit.use(Icons);

// Make UIkit globally available
window.UIkit = UIkit;

console.log('UIkit theme loaded');

export default UIkit;
