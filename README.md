# Acquia Coding Standards for PHP

[![Latest Stable Version](https://poser.pugx.org/acquia/coding-standards/v/stable)](https://packagist.org/packages/acquia/coding-standards)
[![Total Downloads](https://poser.pugx.org/acquia/coding-standards/downloads)](https://packagist.org/packages/acquia/coding-standards)
[![Latest Unstable Version](https://poser.pugx.org/acquia/coding-standards/v/unstable)](https://packagist.org/packages/acquia/coding-standards)
[![License](https://poser.pugx.org/acquia/coding-standards/license)](https://packagist.org/packages/acquia/coding-standards)
[![Tests](https://github.com/acquia/coding-standards-php/actions/workflows/orca.yml/badge.svg)](https://github.com/acquia/coding-standards-php/actions/workflows/orca.yml)

Acquia Coding Standards for PHP is a collection of [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) rules (sniffs) for Acquia coding standards for PHP projects, including Drupal extensions.

## Rules

Acquia Coding Standards for PHP includes a selection of sniffs from the following rulesets:

* [Drupal Code Sniffer](https://packagist.org/packages/drupal/coder) encapsulates [Drupal coding standards](https://www.drupal.org/coding-standards ) and best practices for module development.
* [PHP_CodeSniffer](https://packagist.org/packages/squizlabs/php_codesniffer) itself contains several broadly applicable rulesets.
* [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) checks for PHP cross-version compatibility with all supported language versions.
* [Slevomat Coding Standard](https://github.com/slevomat/coding-standard) provides functional (safety and behavior), cleaning (dead code), and formatting (consistent look) sniffs.

## Rulesets

Rules are split into rulesets according to the project language and framework:

* [AcquiaPHP](src/Standards/AcquiaPHP/ruleset.xml) contains sniffs applicable to all PHP projects.
* [AcquiaDrupalStrict](src/Standards/AcquiaDrupalStrict/ruleset.xml) incorporates AcquiaPHP and adds all Drupal coding standards and best practices sniffs. Recommended for new Drupal projects and teams familiar with Drupal coding standards.
* [AcquiaDrupalTransitional](src/Standards/AcquiaDrupalTransitional/ruleset.xml) incorporates AcquiaPHP and adds Drupal core's own phpcs configuration, which is less strict than the official standards. Recommended for legacy Drupal codebases or teams new to Drupal coding standards.
* [AcquiaEdge](src/Standards/AcquiaEdge/ruleset.xml) incorporates AcquiaPHP and adds backwards-incompatible sniffs that will be included in AcquiaPHP with the next major release of this package.

## Installation & usage

1. Add Acquia Coding Standards for PHP to your project via Composer:

    ```bash
    composer require --dev acquia/coding-standards
    ```

1. Inform PHP CodeSniffer of the location of the standard and its dependencies:

    * It is strongly recommended that you use a Composer plugin to handle this for you, e.g., [`DealerDirect/phpcodesniffer-composer-installer`](https://github.com/DealerDirect/phpcodesniffer-composer-installer):

        ```bash
        composer config extra.phpcodesniffer-search-depth 4
        composer require --dev dealerdirect/phpcodesniffer-composer-installer
        ```

    * Alternatively, add a script to your `composer.json` to handle it:

        ```json
        {
            "scripts": {
                "post-install-cmd": "@install-coding-standards",
                "post-update-cmd" : "@install-coding-standards",
                "install-coding-standards": "\"vendor/bin/phpcs\" --config-set installed_paths vendor/acquia/coding-standards/src,vendor/drupal/coder/coder_sniffer,vendor/phpcompatibility/php-compatibility"
            }
        }
        ```

1. Check code for standards compliance:

    ```bash
    ./vendor/bin/phpcs --standard=AcquiaDrupalStrict --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml path/to/code
    ```

    Automatically fix any standards violations possible:

    ```bash
    ./vendor/bin/phpcbf --standard=AcquiaDrupalStrict --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml path/to/code
    ```

    The `--extensions` argument must match the chosen code standard. For AcquiaPHP, use `--extensions=php,inc,test,css,txt,md,yml`.

1. Optionally create a [default configuration file](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#using-a-default-configuration-file) for your project so you don't have to provide the command-line arguments every time (i.e., below). Here's a working example: [`example/phpcs.xml.dist`](example/phpcs.xml.dist).

    ```bash
    ./vendor/bin/phpcs
    ```

    Modify `phpcs.xml.dist` to suit your project, especially to set the preferred code standard and matching extensions.

1. Optionally add code checking to your [Git pre-commit hook](https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) to prevent committing code with violations. Since client-side Git hooks are not copied when a repository is cloned, you might like to use an automated solution like [`BrainMaestro/composer-git-hooks`](https://packagist.org/packages/BrainMaestro/composer-git-hooks) to manage them, for example: [`example/composer.json`](example/composer.json).

1. Optionally [configure PHP Code Sniffer integration in PhpStorm](https://www.jetbrains.com/help/phpstorm/using-php-code-sniffer.html) or your IDE or code editor of choice. You can import [`example/PhpStormInspections.xml`](example/PhpStormInspections.xml) to set up default integration for new projects. When you open or create a new project for the first time, PhpStorm should automatically detect and set up PHPCS inspections based on these defaults. You will just need to uncheck the “installed standards paths” in the inspection settings for your project so that PhpStorm can find the Acquia Coding Standards.

## Contribution

Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

Copyright (C) 2019 Acquia, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
