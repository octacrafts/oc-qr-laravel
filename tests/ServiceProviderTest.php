<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Tests;

final class ServiceProviderTest extends TestCase
{
    public function test_config_is_merged(): void
    {
        $this->assertSame(300, config('oc-qr.size'));
        $this->assertSame(4, config('oc-qr.margin'));
        $this->assertSame('M', config('oc-qr.error_correction'));
        $this->assertSame('png', config('oc-qr.format'));
    }

    public function test_config_can_be_published_via_artisan_tag(): void
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'oc-qr-config',
            '--force' => true,
        ])->assertExitCode(0);

        $this->assertFileExists($this->app->configPath('oc-qr.php'));
    }
}
