# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this package is

A **ruleset-composition-only** PHP_CodeSniffer package. It contains no custom PHP sniff classes — only four `ruleset.xml` files that compose rules from upstream packages (`drupal/coder`, `slevomat/coding-standard`, and PHPCS core). All sniff logic lives in those dependencies.

The four standards and their intent:

| Standard | Base | Audience |
|---|---|---|
| `AcquiaDrupalMinimal` | Drupal coding standard | Public Drupal projects |
| `AcquiaDrupalStrict` | AcquiaDrupalMinimal + DrupalPractice | Internal Drupal projects |
| `AcquiaPHPMinimal` | PSR-12 + Generic indentation | Public non-Drupal projects |
| `AcquiaPHPStrict` | AcquiaPHPMinimal + Slevomat rules | Internal non-Drupal projects |

## Commands

```bash
# Run all tests
composer test

# Run a single test class
vendor/bin/phpunit tests/Standards/AcquiaPHPStrictTest.php

# Run a single test method
vendor/bin/phpunit --filter testSuperglobalUsageIsReported

# Manually verify a fixture against a standard (useful when writing new tests)
vendor/bin/phpcs -s --standard=src/Standards/AcquiaPHPStrict/ruleset.xml tests/fixtures/AcquiaPHPStrict/fail-superglobal.php
```

## Testing architecture

Because this package has no custom sniffs, PHPCS's built-in `AbstractSniffUnitTest` framework does not apply. Tests drive the PHPCS PHP API directly:

- `tests/bootstrap.php` — defines PHPCS constants (`PHP_CODESNIFFER_IN_TESTS`, etc.) and requires both the Composer autoloader and PHPCS's own `autoload.php` + `Util/Tokens.php`. The token constants file **must** be loaded before any sniff class is instantiated or `T_COMMA` and friends will be undefined.
- `tests/Standards/AbstractRulesetTestCase.php` — base class with three assertion helpers: `assertStandardPasses`, `assertViolationOnLine`, `assertViolationWithCode`. Resolves standards by name from `src/Standards/<name>/ruleset.xml`.
- `tests/Standards/<Standard>Test.php` — one test class per standard.
- `tests/fixtures/<Standard>/` — PHP fixture files. `pass.php` is a minimal compliant file; `fail-*.php` files each trigger one specific sniff code.

### Fixture path gotcha

PHPCS `<exclude-pattern>tests/*</exclude-pattern>` matches on substring of the absolute file path, so any fixture stored under `tests/` will have those rules silenced. When writing a fail fixture for `AcquiaDrupalMinimal`, use a rule that is **not** in the exclusion list (e.g. `Drupal.Commenting.FileComment.Missing`). The excluded rules are: `Drupal.Arrays.Array.LongLineDeclaration`, `Drupal.Commenting.ClassComment.Missing`, `Drupal.Commenting.DocComment.MissingShort`, `Drupal.Commenting.FunctionComment.Missing`, `Drupal.Commenting.VariableComment.Missing`.

## Adding or changing rules

Edit the relevant `src/Standards/<Standard>/ruleset.xml`. All rule references must be to sniffs provided by the three runtime dependencies (`drupal/coder`, `slevomat/coding-standard`, `squizlabs/php_codesniffer`). When adding a rule, add a corresponding `fail-*.php` fixture and `assertViolationWithCode` test.

## Branch targeting

- `develop` — new work for the active `4.x` line
- `support/3` — approved fixes for the `3.x` LTS line
- PRs must target the correct branch; maintainers handle merges/backports
