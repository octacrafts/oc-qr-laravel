<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Tests;

use Octacrafts\QrEngine\Domain\OutputFormat;
use Octacrafts\QrLaravel\Contracts\QrManagerContract;
use Octacrafts\QrLaravel\Facades\Qr;

final class DelegationTest extends TestCase
{
    public function test_png_generation_via_facade(): void
    {
        $output = Qr::make('test')->png();

        $this->assertSame(OutputFormat::Png, $output->format());
        $this->assertSame('image/png', $output->contentType());
        $this->assertNotEmpty($output->content());
        $this->assertStringStartsWith("\x89PNG", $output->content());
    }

    public function test_svg_generation_via_facade(): void
    {
        $output = Qr::make('Hello World')->svg();

        $this->assertSame(OutputFormat::Svg, $output->format());
        $this->assertSame('image/svg+xml', $output->contentType());
        $this->assertStringContainsString('<svg', $output->content());
    }

    public function test_png_generation_via_injected_manager(): void
    {
        $manager = $this->app->make(QrManagerContract::class);

        $output = $manager->make('https://example.com')
            ->size(300)
            ->margin(4)
            ->png();

        $this->assertSame(OutputFormat::Png, $output->format());
        $this->assertNotEmpty($output->content());
    }

    public function test_fluent_overrides_apply_before_generation(): void
    {
        $output = Qr::make('test')
            ->errorCorrection(\Octacrafts\QrEngine\Domain\ErrorCorrectionLevel::H)
            ->size(200)
            ->margin(1)
            ->svg();

        $this->assertSame(OutputFormat::Svg, $output->format());
        $this->assertStringContainsString('<svg', $output->content());
    }
}
