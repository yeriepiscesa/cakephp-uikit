// Convert flash notification elements to UIkit notifications
document.addEventListener('DOMContentLoaded', function() {
    // Check if UIkit is available
    if (typeof UIkit !== 'undefined') {
        // Get all notification flash elements
        const notifications = document.querySelectorAll('.uk-notification-flash');
        
        notifications.forEach(element => {
            const message = element.getAttribute('data-message');
            const type = element.getAttribute('data-type') || 'primary';
            
            if (message) {
                UIkit.notification({
                    message: message,
                    status: type,
                    timeout: 5000,
                    pos: 'bottom-right'
                });
            }
            
            // Remove the element
            element.remove();
        });
    }
});
