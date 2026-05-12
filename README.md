# Celemas Sire

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![CI](https://github.com/celemas/sire/actions/workflows/ci.yml/badge.svg)](https://github.com/celemas/sire/actions)
[![Psalm level](https://shepherd.dev/github/celemas/sire/level.svg?)](https://celemas.dev/sire)
[![Psalm coverage](https://shepherd.dev/github/celemas/sire/coverage.svg?)](https://shepherd.dev/github/celemas/sire)

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
