# octacrafts/oc-qr-laravel

Laravel integration for [octacrafts/oc-qr](https://github.com/octacrafts/oc-qr). This package is a thin adapter: all QR generation, encoding, masking, and rendering live in the core library.

## Requirements

- PHP 8.2+
- Laravel 11 or 12
- `ext-gd` (required by the core library for PNG output)

## Installation

```bash
composer require octacrafts/oc-qr-laravel
```

The package auto-registers via Laravel package discovery. No manual provider registration is required.

### Publish configuration (optional)

```bash
php artisan vendor:publish --tag=oc-qr-config
```

Environment variables:

| Variable | Default | Description |
|----------|---------|-------------|
| `OC_QR_SIZE` | `300` | Default output size in pixels |
| `OC_QR_MARGIN` | `4` | Default quiet zone in modules |
| `OC_QR_ERROR_CORRECTION` | `M` | `L`, `M`, `Q`, or `H` |
| `OC_QR_FORMAT` | `png` | `png` or `svg` |

## Usage

### Facade

```php
use Octacrafts\QrLaravel\Facades\Qr;

$output = Qr::make('https://example.com')
    ->size(300)
    ->margin(4)
    ->png();

return response($output->content(), 200, [
    'Content-Type' => $output->contentType(),
]);
```

```php
$svg = Qr::make('Hello World')->svg();
```

### Dependency injection

```php
use Octacrafts\QrLaravel\Contracts\QrManagerContract;

final class QrController
{
    public function __construct(
        private readonly QrManagerContract $qr,
    ) {}

    public function show(): \Illuminate\Http\Response
    {
        $output = $this->qr->make('https://example.com')->png();

        return response($output->content(), 200, [
            'Content-Type' => $output->contentType(),
        ]);
    }
}
```

### Advanced options

Use core domain types for full control. The fluent builder delegates to `Octacrafts\QrEngine\Core\QrBuilder`:

```php
use Octacrafts\QrEngine\Domain\ErrorCorrectionLevel;
use Octacrafts\QrEngine\Domain\OutputFormat;

$output = Qr::make('payload')
    ->errorCorrection(ErrorCorrectionLevel::H)
    ->format(OutputFormat::Svg)
    ->generate();
```

For forced version, mask, or custom colors, use `QrEngine` from the core package directly.

## Architecture

```
Facade (Qr) → QrManager → FluentQrBuilder → octacrafts/oc-qr QrBuilder → QrEngine
```

For a detailed walkthrough from bootstrap to `RenderedOutput`, see [docs/flow.md](docs/flow.md).

Configuration is parsed once into `PackageConfig` and injected into `QrManager`. Avoid calling `config()` from package classes outside the service provider.

## Extending

Rebind services in your application `AppServiceProvider` without modifying this package:

```php
$this->app->singleton(\Octacrafts\QrEngine\Core\QrEngine::class, fn () => $customEngine);
```

Future Laravel-specific features (storage, response helpers, logo overlays) should implement `FluentQrContract` or wrap `RenderedOutput` after generation.

## Development

Clone the repository and install dependencies:

```bash
composer install
composer test
```

Manual smoke test (writes files to the project root; gitignored):

```bash
vendor/bin/testbench tinker --execute="file_put_contents('manual-test-qr.png', \Octacrafts\QrLaravel\Facades\Qr::make('https://example.com')->png()->content());"
```

QR encoding correctness is covered by [octacrafts/oc-qr](https://github.com/octacrafts/oc-qr). This package only ships Laravel integration tests.

## License

MIT. See [LICENSE](LICENSE).
