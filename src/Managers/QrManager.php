<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Managers;

use Octacrafts\QrEngine\Core\QrBuilder;
use Octacrafts\QrEngine\Core\QrEngine;
use Octacrafts\QrLaravel\Contracts\FluentQrContract;
use Octacrafts\QrLaravel\Contracts\QrManagerContract;
use Octacrafts\QrLaravel\Support\FluentQrBuilder;
use Octacrafts\QrLaravel\Support\PackageConfig;

final class QrManager implements QrManagerContract
{
    public function __construct(
        private readonly QrEngine $engine,
        private readonly PackageConfig $config,
    ) {
    }

    public function make(string $content): FluentQrContract
    {
        $builder = QrBuilder::create($content, $this->engine)
            ->errorCorrection($this->config->errorCorrection)
            ->size($this->config->size)
            ->margin($this->config->margin)
            ->format($this->config->format);

        return new FluentQrBuilder($builder);
    }
}
