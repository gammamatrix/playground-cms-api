# Playground: CMS API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-cms-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-cms-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-cms-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-level%2010-brightgreen)](.github/workflows/ci.yml#L128)

Playground: CMS API

This package provides an API without UI for interacting with the [Playground: CMS](https://github.com/gammamatrix/playground-cms), a model package for Laravel.

If you need a JSON API with a UI, then have a look at [Playground: CMS Resource.](https://github.com/gammamatrix/playground-cms-resource)

## Documentation

Read more on using [Playground: CMS API at Read the Docs: Playground Documentation](https://gammamatrix-playground.readthedocs.io/en/develop/built-components/cms.html)

### Postman

A postman collection is provided in the repository: [postman-playground-cms-api.json.](postman-playground-cms-api.json)
- This same collection is viewable on the [Postman: GammaMatrix Playground Workspace.](https://www.postman.com/gammamatrix/workspace/playground/documentation/1185343-1e4a5656-d4e0-45b2-8f4e-daad7a6ee2b1)

### OpenAPI

This application provides OpenAPI documentation: [openapi.yaml](openapi.yaml).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the Playground: CMS API API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.yaml](openapi.yaml) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-cms-api/develop/openapi.yaml)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-cms-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-cms-api.png" alt="screenshot of artisan about command with Playground: CMS API."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Cms\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via environment variable or the configuration.

See the contents of the published config file: [config/playground-cms-api.php](config/playground-cms-api.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Cms\Api\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-cms-api`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-cms-api.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-cms-api/wiki/Environment-Variables)

## Migrations

This package requires the migrations in [playground-cms](https://github.com/gammamatrix/playground-cms) a Laravel package.

## Cloc

```sh
composer cloc
```

```
➜  playground-cms-api git:(develop) ✗ composer cloc
     210 text files.
     203 unique files.
      49 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.06 s (3375.2 files/s, 519960.9 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                            79              0              0          18171
YAML                            30              5              0           6327
PHP                             80            866           1211           3630
XML                             10              0              7            853
Markdown                         3             57              1            130
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           203            931           1219          29123
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `lang/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

Run unit tests:
```sh
composer test
```

Run unit and feature tests:
```sh
composer test-dev
```

Run unit and feature tests in parallel:
```sh
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
