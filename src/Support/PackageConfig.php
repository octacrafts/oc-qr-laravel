<?php

declare(strict_types=1);

namespace Octacrafts\QrLaravel\Support;

use InvalidArgumentException;
use Octacrafts\QrEngine\Domain\ErrorCorrectionLevel;
use Octacrafts\QrEngine\Domain\OutputFormat;

final readonly class PackageConfig
{
    public function __construct(
        public int $size,
        public int $margin,
        public ErrorCorrectionLevel $errorCorrection,
        public OutputFormat $format,
    ) {
    }

    /**
     * @param  array{size?: int|string, margin?: int|string, error_correction?: string, format?: string}  $config
     */
    public static function fromArray(array $config): self
    {
        return new self(
            size: (int) ($config['size'] ?? 300),
            margin: (int) ($config['margin'] ?? 4),
            errorCorrection: self::parseErrorCorrection((string) ($config['error_correction'] ?? 'M')),
            format: self::parseFormat((string) ($config['format'] ?? 'png')),
        );
    }

    private static function parseErrorCorrection(string $value): ErrorCorrectionLevel
    {
        return match (strtoupper($value)) {
            'L' => ErrorCorrectionLevel::L,
            'M' => ErrorCorrectionLevel::M,
            'Q' => ErrorCorrectionLevel::Q,
            'H' => ErrorCorrectionLevel::H,
            default => throw new InvalidArgumentException(
                sprintf('Invalid error correction level [%s]. Expected L, M, Q, or H.', $value),
            ),
        };
    }

    private static function parseFormat(string $value): OutputFormat
    {
        return match (strtolower($value)) {
            'png' => OutputFormat::Png,
            'svg' => OutputFormat::Svg,
            default => throw new InvalidArgumentException(
                sprintf('Invalid output format [%s]. Expected png or svg.', $value),
            ),
        };
    }
}
