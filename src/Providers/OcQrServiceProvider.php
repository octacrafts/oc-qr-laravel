<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Octacrafts\QrEngine\Core\QrEngine;
use Octacrafts\QrEngine\Core\QrEngineFactory;
use Octacrafts\QrLaravel\Contracts\QrManagerContract;
use Octacrafts\QrLaravel\Managers\QrManager;
use Octacrafts\QrLaravel\Support\PackageConfig;

final class OcQrServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/oc-qr.php', 'oc-qr');

        $this->app->singleton(QrEngine::class, static fn (): QrEngine => QrEngineFactory::createDefault());

        $this->app->singleton(PackageConfig::class, function ($app): PackageConfig {
            /** @var array<string, mixed> $config */
            $config = $app['config']->get('oc-qr', []);

            return PackageConfig::fromArray($config);
        });

        $this->app->singleton(QrManagerContract::class, function ($app): QrManager {
            return new QrManager(
                $app->make(QrEngine::class),
                $app->make(PackageConfig::class),
            );
        });

        $this->app->alias(QrManagerContract::class, 'qr');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/oc-qr.php' => $this->app->configPath('oc-qr.php'),
            ], 'oc-qr-config');
        }
    }
}
