<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Octacrafts\QrLaravel\Contracts\QrManagerContract;

/**
 * @method static \Octacrafts\QrLaravel\Contracts\FluentQrContract make(string $content)
 *
 * @see \Octacrafts\QrLaravel\Managers\QrManager
 */
final class Qr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return QrManagerContract::class;
    }
}
