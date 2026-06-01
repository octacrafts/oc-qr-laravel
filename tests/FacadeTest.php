<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Tests;

use Octacrafts\QrLaravel\Contracts\QrManagerContract;
use Octacrafts\QrLaravel\Facades\Qr;
use Octacrafts\QrLaravel\Managers\QrManager;

final class FacadeTest extends TestCase
{
    public function test_facade_resolves_to_manager(): void
    {
        $root = Qr::getFacadeRoot();

        $this->assertInstanceOf(QrManager::class, $root);
        $this->assertInstanceOf(QrManagerContract::class, $root);
    }

    public function test_facade_make_returns_fluent_builder(): void
    {
        $fluent = Qr::make('test');

        $this->assertInstanceOf(\Octacrafts\QrLaravel\Contracts\FluentQrContract::class, $fluent);
    }
}
