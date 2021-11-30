#!/usr/bin/env bash

# NAME
#     install.sh - Create the test fixture.
#
# SYNOPSIS
#     install.sh
#
# DESCRIPTION
#     Creates the test fixture.

cd "$(dirname "$0")" || exit 1

# Reuse ORCA's own includes.
source ../../../orca/bin/travis/_includes.sh || exit

# Exit early on standard ORCA jobs.
[[ "$ORCA_JOB" ]] && exit 0

# Create a new Composer project.
mkdir -p ~/fixture
cd ~/fixture || exit 1
composer init --name=test/example --no-interaction

# Install the SUT.
composer config repositories.coding-standards path "$ORCA_SUT_DIR"
composer require --dev acquia/coding-standards:@dev
composer config extra.phpcodesniffer-search-depth 4
sed -i'.bak' 's|"phpcodesniffer-search-depth": "4"|"phpcodesniffer-search-depth": 4|' composer.json && rm composer.json.bak
composer require --dev dealerdirect/phpcodesniffer-composer-installer

cat composer.json
