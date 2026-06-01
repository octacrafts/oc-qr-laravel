<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Tests;

use Octacrafts\QrLaravel\Providers\OcQrServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            OcQrServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Qr' => \Octacrafts\QrLaravel\Facades\Qr::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('oc-qr', [
            'size' => 300,
            'margin' => 4,
            'error_correction' => 'M',
            'format' => 'png',
        ]);
    }
}
