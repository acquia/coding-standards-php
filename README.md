# Acquia Coding Standards for PHP

Acquia Coding Standards for PHP is a collection of [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) rules (sniffs) for Acquia coding standards for PHP projects, including Drupal extensions.

## Rules

Acquia Coding Standards for PHP includes a selection of sniffs from the following rulesets:

* [Drupal Code Sniffer](https://packagist.org/packages/drupal/coder) encapsulates [Drupal coding standards](https://www.drupal.org/coding-standards ) and best practices for module development.
* [PHP_CodeSniffer](https://packagist.org/packages/squizlabs/php_codesniffer) itself contains several broadly applicable rulesets.
* [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) checks for PHP cross-version compatibility with all supported language versions.
* [phpcs-security-audit](https://packagist.org/packages/pheromone/phpcs-security-audit) finds vulnerabilities and weaknesses related to security in PHP code.

## Rulesets

Rules are split into rulesets according to the project language and framework:

* [AcquiaPHP](src/Standards/AcquiaPHP/ruleset.xml) contains sniffs applicable to all PHP projects.
* [AcquiaDrupal](src/Standards/AcquiaDrupal/ruleset.xml) incorporates AcquiaPHP and adds sniffs applicable to Drupal projects.

## Installation & usage

1. Add Acquia Coding Standards for PHP to your project via Composer:

    ```bash
    composer require --dev acquia/coding-standards
    ```

1. Inform PHP CodeSniffer of the location of the standard and its dependencies:

    * It is strongly recommended that you use a Composer plugin to handle this for you, e.g., [`DealerDirect/phpcodesniffer-composer-installer`](https://github.com/DealerDirect/phpcodesniffer-composer-installer):

        ```bash
        composer config extra.phpcodesniffer-search-depth 4

        # Change the newly-set value to a number, since `composer config` always creates strings.
        sed -i'.bak' 's|"phpcodesniffer-search-depth": "4"|"phpcodesniffer-search-depth": 4|' composer.json

        composer require --dev dealerdirect/phpcodesniffer-composer-installer
        ```

    * Alternatively, add a script to your `composer.json` to handle it:

        ```json
        {
            "scripts": {
                "post-install-cmd": "@install-coding-standards",
                "post-update-cmd" : "@install-coding-standards",
                "install-coding-standards": "\"vendor/bin/phpcs\" --config-set installed_paths vendor/acquia/coding-standards/src,vendor/drupal/coder/coder_sniffer,vendor/pheromone/phpcs-security-audit,vendor/phpcompatibility/php-compatibility"
            }
        }
        ```

1. Check code for standards compliance:

    ```bash
    ./vendor/bin/phpcs --standard=AcquiaDrupal path/to/code
    ```
    
    Automatically fix any standards violations possible:

    ```bash
    ./vendor/bin/phpcbf --standard=AcquiaDrupal path/to/code
    ```
    
1. Optionally create a [default configuration file](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#using-a-default-configuration-file) for your project so you don't have to provide the command-line arguments every time (i.e., below). Here's a working example: [`example/phpcs.xml.dist`](example/phpcs.xml.dist).

    ```bash
    ./vendor/bin/phpcs
    ```

1. Optionally add code checking to your [Git pre-commit hook](https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) to prevent committing code with violations. Since client-side Git hooks are not copied when a repository is cloned, you might like to use an automated solution like [`BrainMaestro/composer-git-hooks`](https://packagist.org/packages/BrainMaestro/composer-git-hooks) to manage them, for example: [`example/composer.json`](example/composer.json).

## Contribution

Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

Copyright (C) 2019 Acquia, Inc.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
