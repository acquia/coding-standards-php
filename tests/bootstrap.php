<?php

declare(strict_types=1);

// Required by PHPCS internals before any PHPCS class is loaded.
define('PHP_CODESNIFFER_CBF', false);
define('PHP_CODESNIFFER_IN_TESTS', true);
define('PHP_CODESNIFFER_VERBOSITY', 0);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/squizlabs/php_codesniffer/autoload.php';
// Register PHPCS token constants (T_COMMA, T_WHITESPACE, etc.) used by sniffs.
require_once __DIR__ . '/../vendor/squizlabs/php_codesniffer/src/Util/Tokens.php';
