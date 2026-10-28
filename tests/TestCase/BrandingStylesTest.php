<?php
declare(strict_types=1);

namespace Uikit\Test\TestCase;

use Cake\Core\Configure;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 4) . '/vendor/cakephp/cakephp/src/Core/functions_global.php';

class BrandingStylesTest extends TestCase
{
    public function testConfiguredColorsAndInvalidValues(): void
    {
        $previous = Configure::read('Uikit.branding.colors');
        Configure::write('Uikit.branding.colors', [
            'primary' => '#123abc',
            'primaryHover' => '#abc',
            'sidebar' => '#000; color:red',
            'background' => 'invalid',
        ]);
        try {
            ob_start();
            include dirname(__DIR__, 2) . '/templates/element/branding_styles.php';
            $styles = ob_get_clean();
            self::assertStringContainsString('--theme-primary: #123abc', $styles);
            self::assertStringContainsString('--theme-primary-hover: #abc', $styles);
            self::assertStringContainsString('--theme-sidebar: #16293d', $styles);
            self::assertStringContainsString('--theme-background: #f5f7fa', $styles);
            self::assertStringNotContainsString('color:red', $styles);
        } finally {
            Configure::write('Uikit.branding.colors', $previous);
        }
    }
}
