<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Contracts;

interface QrManagerContract
{
    public function make(string $content): FluentQrContract;
}
