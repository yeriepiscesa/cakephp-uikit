<?php
declare(strict_types=1);

namespace Uikit\View\Helper;

use Cake\View\Helper;

/**
 * ImageUpload helper
 * 
 * Renders image upload field with Alpine.js preview component
 * @property \Cake\View\Helper\FormHelper $Form
 */
class ImageUploadHelper extends Helper
{
    /**
     * @var array<string>
     */
    protected array $helpers = ['Form'];

    /**
     * Render image upload field with preview
     *
     * @param string $field Field name
     * @param array<string, mixed> $options Options:
    *   - width: Preview width as px integer or CSS string such as 100% (default: 300)
    *   - height: Preview height as px integer or CSS string such as auto (default: 200)
     *   - shape: Preview shape 'box', 'circle', or 'rounded' (default: 'rounded')
     *   - currentImage: Current image path for edit mode (default: null)
     *   - currentFileName: Current file name (default: null)
     *   - currentFileSize: Current file size in bytes (default: null)
     *   - currentFileType: Current file mime type (default: null)
     *   - label: Field label (default: field name)
     *   - showDeleteCheckbox: Show delete checkbox for existing image (default: true)
     *   - deleteFieldName: Name for delete checkbox field (default: 'delete_{field}')
     *   - help: Help text below file input (default: null)
     *   - required: Mark field as required (default: false)
     * @return string
     */
    public function control(string $field, array $options = []): string
    {
        $defaults = [
            'width' => 300,
            'height' => 200,
            'shape' => 'rounded',
            'currentImage' => null,
            'currentFileName' => null,
            'currentFileSize' => null,
            'currentFileType' => null,
            'label' => null,
            'showDeleteCheckbox' => true,
            'deleteFieldName' => 'delete_' . $field,
            'help' => null,
            'required' => false,
        ];

        $config = $options + $defaults;

        $alpineConfig = [
            'width' => $config['width'],
            'height' => $config['height'],
            'shape' => $config['shape'],
        ];
        if ($config['currentImage']) {
            $alpineConfig['currentImage'] = $config['currentImage'];
        }
        $alpineConfigStr = (string)json_encode($alpineConfig);

        $label = $config['label'] ?? __(ucfirst($field));
        $hasImage = !empty($config['currentImage']);

        $html = '<div class="uk-margin" x-data="imagePreview(' . h($alpineConfigStr) . ')">';
        $html .= '<label class="uk-form-label" for="' . h($field) . '">' . h($label) . '</label>';

        // Preview Container
        $html .= '<div x-show="preview" class="uk-margin-small-bottom">';
        $html .= '<div :style="containerStyle">';
        $html .= '<img :src="preview" :style="imageStyle" alt="Preview">';
        $html .= '</div>';

        // File info (name, size, type)
        if ($hasImage && ($config['currentFileName'] || $config['currentFileSize'] || $config['currentFileType'])) {
            $html .= '<div class="uk-margin-small-top uk-text-small uk-text-muted">';

            if ($config['currentFileName']) {
                $html .= '<div class="uk-text-bold">' . h($config['currentFileName']) . '</div>';
            }

            $fileInfoParts = [];
            if ($config['currentFileSize']) {
                $currentFileSize = (int)$config['currentFileSize'];
                $fileInfoParts[] = $this->formatFileSize($currentFileSize);
            }
            if ($config['currentFileType']) {
                $fileInfoParts[] = h($config['currentFileType']);
            }

            if (!empty($fileInfoParts)) {
                $html .= '<div>' . implode(' &middot; ', $fileInfoParts) . '</div>';
            }

            $html .= '</div>';
        }

        // Delete checkbox for existing image
        if ($hasImage && $config['showDeleteCheckbox']) {
            $html .= '<div class="uk-margin-small-top uk-display-inline-block">';
            $html .= '<label class="uk-form-label">';
            $html .= $this->Form->checkbox($config['deleteFieldName'], [
                'hiddenField' => false,
                'class' => 'uk-checkbox',
                'x-on:change' => '$event.target.checked && clearPreview()',
            ]);
            $html .= ' ' . __('Delete current image');
            $html .= '</label>';
            $html .= '</div>';
        }

        $html .= '</div>'; // end preview container

        // Placeholder when no preview
        $html .= '<div x-show="!preview" :style="containerStyle" class="uk-margin-small-bottom uk-flex uk-flex-center uk-flex-middle uk-background-muted">';
        $html .= '<div class="uk-text-center uk-text-muted">';
        $html .= '<span uk-icon="icon: image; ratio: 3"></span>';
        $html .= '<p class="uk-margin-remove-vertical uk-text-small">' . __('No image selected') . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        // File input
        $html .= '<div uk-form-custom="target: true" class="uk-form-controls uk-width-expand uk-margin-small-top">';
        $html .= $this->Form->control($field, [
            'label' => false,
            'type' => 'file',
            'x-on:change' => 'handleFileChange',
            'help' => $config['help'],
            'required' => $config['required'],
            'aria-label' => 'Upload a file',
        ]);
        $html .= '<button name="upload-' . h($field) . '" 
                    class="uk-input uk-button uk-button-default" 
                    type="button" 
                    aria-label="Custom controls">Select a file...</button>';
        $html .= '</div>';

        $html .= '</div>'; // end uk-margin

        return $html;
    }
    
    /**
     * Format file size to human readable format
     *
     * @param int $bytes File size in bytes
     * @return string Formatted file size
     */
    protected function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
