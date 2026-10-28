<?php
declare(strict_types=1);

namespace Uikit\View\Helper;

use Cake\View\Helper\FlashHelper as CakeFlashHelper;

class FlashHelper extends CakeFlashHelper
{
    public function render(string $key = 'flash', array $options = []): ?string
    {
        $messages = $this->_View->getRequest()->getFlash()->consume($key);
        if ($messages === null) {
            return null;
        }
        $output = '';
        foreach ($messages as $message) {
            $message = $options + $message;
            if (in_array($message['element'], ['flash/default', 'flash/success', 'flash/error', 'flash/warning', 'flash/info'], true)) {
                $message['element'] = 'Uikit.' . $message['element'];
            }
            $output .= $this->_View->element($message['element'], $message);
        }

        return $output;
    }
}
