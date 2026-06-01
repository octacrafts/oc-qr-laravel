<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Tests;

use Octacrafts\QrEngine\Core\QrEngine;
use Octacrafts\QrEngine\Domain\OutputFormat;
use Octacrafts\QrLaravel\Contracts\QrManagerContract;
use Octacrafts\QrLaravel\Managers\QrManager;
use Octacrafts\QrLaravel\Support\PackageConfig;

final class ContainerBindingTest extends TestCase
{
    public function test_qr_manager_contract_resolves(): void
    {
        $manager = $this->app->make(QrManagerContract::class);

        $this->assertInstanceOf(QrManager::class, $manager);
    }

    public function test_qr_alias_resolves_to_manager(): void
    {
        $this->assertSame(
            $this->app->make(QrManagerContract::class),
            $this->app->make('qr'),
        );
    }

    public function test_qr_engine_is_singleton(): void
    {
        $first = $this->app->make(QrEngine::class);
        $second = $this->app->make(QrEngine::class);

        $this->assertSame($first, $second);
    }

    public function test_package_config_reflects_application_config(): void
    {
        $this->app['config']->set('oc-qr', [
            'size' => 400,
            'margin' => 2,
            'error_correction' => 'H',
            'format' => 'svg',
        ]);

        $this->app->forgetInstance(PackageConfig::class);
        $this->app->forgetInstance(QrManagerContract::class);

        $config = $this->app->make(PackageConfig::class);

        $this->assertSame(400, $config->size);
        $this->assertSame(2, $config->margin);
        $this->assertSame(OutputFormat::Svg, $config->format);
    }
}
