# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-06-01

### Added

- Laravel service provider with package auto-discovery
- `Qr` facade and `QrManagerContract` for dependency injection
- Publishable `oc-qr` configuration (size, margin, error correction, format)
- Fluent API (`make`, `png`, `svg`) delegating to `octacrafts/oc-qr`
- Orchestra Testbench integration test suite

[1.0.0]: https://github.com/octacrafts/oc-qr-laravel/releases/tag/v1.0.0
