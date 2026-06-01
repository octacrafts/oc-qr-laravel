<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Contracts;

use Octacrafts\QrEngine\Domain\ErrorCorrectionLevel;
use Octacrafts\QrEngine\Domain\OutputFormat;
use Octacrafts\QrEngine\Domain\RenderedOutput;

interface FluentQrContract
{
    public function errorCorrection(ErrorCorrectionLevel $level): self;

    public function size(int $pixels): self;

    public function margin(int $modules): self;

    public function format(OutputFormat $format): self;

    public function generate(): RenderedOutput;

    public function png(): RenderedOutput;

    public function svg(): RenderedOutput;
}
