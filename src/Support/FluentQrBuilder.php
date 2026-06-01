<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Support;

use Octacrafts\QrEngine\Core\QrBuilder;
use Octacrafts\QrEngine\Domain\ErrorCorrectionLevel;
use Octacrafts\QrEngine\Domain\OutputFormat;
use Octacrafts\QrEngine\Domain\RenderedOutput;
use Octacrafts\QrLaravel\Contracts\FluentQrContract;

final class FluentQrBuilder implements FluentQrContract
{
    public function __construct(
        private readonly QrBuilder $builder,
    ) {
    }

    public function errorCorrection(ErrorCorrectionLevel $level): self
    {
        $this->builder->errorCorrection($level);

        return $this;
    }

    public function size(int $pixels): self
    {
        $this->builder->size($pixels);

        return $this;
    }

    public function margin(int $modules): self
    {
        $this->builder->margin($modules);

        return $this;
    }

    public function format(OutputFormat $format): self
    {
        $this->builder->format($format);

        return $this;
    }

    public function generate(): RenderedOutput
    {
        return $this->builder->generate();
    }

    public function png(): RenderedOutput
    {
        return $this->format(OutputFormat::Png)->generate();
    }

    public function svg(): RenderedOutput
    {
        return $this->format(OutputFormat::Svg)->generate();
    }
}
