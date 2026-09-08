/**
 * Image Upload Preview Component
 * 
 * Usage:
 * <div x-data="imagePreview({ 
 *   width: 300, 
 *   height: 300, 
 *   shape: 'box|circle|rounded',
 *   currentImage: '/path/to/image.jpg' 
 * })">
 *   <img x-show="preview" :src="preview" :style="imageStyle" />
 *   <input type="file" @change="handleFileChange" />
 * </div>
 */

// Register component before Alpine starts
Alpine.data('imagePreview', (config = {}) => ({
    preview: config.currentImage || null,
    width: config.width || 300,
    height: config.height || 300,
    shape: config.shape || 'box', // box, circle, rounded
        
        init() {
            // Set initial preview if current image exists
            if (config.currentImage) {
                this.preview = config.currentImage;
            }
        },
        
        // Helper to format dimension (supports number, %, or auto)
        formatDimension(value) {
            if (typeof value === 'string') {
                return value; // '100%', 'auto', etc.
            }
            return `${value}px`; // numeric value
        },
        
        get imageStyle() {
            const styles = {
                width: this.formatDimension(this.width),
                height: this.formatDimension(this.height),
                objectFit: 'contain',
                padding: '10px',
                display: 'block'
            };
            
            // Apply shape-specific styles
            switch (this.shape) {
                case 'circle':
                    styles.borderRadius = '50%';
                    break;
                case 'rounded':
                    styles.borderRadius = '12px';
                    break;
                case 'box':
                default:
                    styles.borderRadius = '0';
                    break;
            }
            
            return Object.entries(styles)
                .map(([key, value]) => `${key.replace(/([A-Z])/g, '-$1').toLowerCase()}: ${value}`)
                .join('; ');
        },
        
        get containerStyle() {
            const styles = {
                width: this.formatDimension(this.width),
                height: this.formatDimension(this.height),
                overflow: 'hidden',
                backgroundColor: '#f8f8f8',
                border: '2px dashed #ddd',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                position: 'relative'
            };
            
            // Apply shape-specific styles to container
            switch (this.shape) {
                case 'circle':
                    styles.borderRadius = '50%';
                    break;
                case 'rounded':
                    styles.borderRadius = '12px';
                    break;
                case 'box':
                default:
                    styles.borderRadius = '4px';
                    break;
            }
            
            return Object.entries(styles)
                .map(([key, value]) => `${key.replace(/([A-Z])/g, '-$1').toLowerCase()}: ${value}`)
                .join('; ');
        },
        
        handleFileChange(event) {
            const file = event.target.files[0];
            
            if (!file) {
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                event.target.value = '';
                return;
            }
            
            // Create preview
            const reader = new FileReader();
            
            reader.onload = (e) => {
                this.preview = e.target.result;
            };
            
            reader.onerror = () => {
                alert('Error reading file');
            };
            
            reader.readAsDataURL(file);
        },
        
        clearPreview() {
            this.preview = null;
        }
    }
));