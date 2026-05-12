# Celemas Sire

<!-- prettier-ignore-start -->
[![ci](https://github.com/celemas/sire/actions/workflows/ci.yml/badge.svg)](https://github.com/celemas/sire/actions)
[![codecov](https://codecov.io/github/celemas/sire/graph/badge.svg?token=JEBA0KS2XR)](https://codecov.io/github/celemas/sire)
[![psalm coverage](https://shepherd.dev/github/celemas/sire/coverage.svg?)](https://shepherd.dev/github/celemas/sire)
[![psalm level](https://shepherd.dev/github/celemas/sire/level.svg?)](https://shepherd.dev/github/celemas/sire)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
<!-- prettier-ignore-end -->

A PHP validation library with a shape-first API and a compact rule DSL.

> **Note:** This is a preview feature currently under active development.

Sire defines required fields by default. Use field-level `optional()`, `default()`, `empty()`, and `nullable()` when a field can be absent, filled, empty, or explicitly `null`. Use shape-level `prepare()` for payload migrations, field-level `prepare()` for value normalization, and `finalize()` for final field output transforms.

## Installation

```bash
composer require celemas/sire
```

## Documentation

Use the docs in `docs/` for complete setup and usage guidance.

- [Introduction](docs/index.md)
- [Installation](docs/installation.md)
- [Usage](docs/usage.md)
- [Development](docs/development.md)

## License

This project is licensed under the [MIT license](LICENSE.md).
