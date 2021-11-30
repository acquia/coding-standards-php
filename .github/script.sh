#!/usr/bin/env bash

# NAME
#     script.sh - Run tests.
#
# SYNOPSIS
#     script.sh
#
# DESCRIPTION
#     Runs automated tests.

cd "$(dirname "$0")" || exit 1

# Reuse ORCA's own includes.
source ../../orca/bin/ci/_includes.sh || exit

# Running other packages' automated tests is overkill for a SUT that has no
# runtime side-effects. Limit the standard jobs to static code analysis and
# deprecated code scan jobs.
if [[ " STATIC_CODE_ANALYSIS DEPRECATED_CODE_SCAN " == *" $ORCA_JOB "*  ]]; then
  ../../orca/bin/ci/script.sh
  set +v
fi

# Exit early on standard ORCA jobs.
[[ "$ORCA_JOB" ]] && exit 0

NO_COLOR="\033[0m"

cd ~/fixture || exit 1

# Test that all standards were installed.
INSTALLED=$(./vendor/bin/phpcs -i)
EXPECTED=(
  AcquiaDrupalStrict
  AcquiaDrupalTransitional
  AcquiaPHP
  Drupal
  DrupalPractice
  PHPCompatibility
)
echo "$INSTALLED"
for STANDARD in "${EXPECTED[@]}"; do
  if [[ "$INSTALLED" == *" $STANDARD"* ]]; then
    echo "Pass: $STANDARD standard successfully installed."
  else
    RED="\033[1;31m"
    printf "%bFail: %s standard not installed.%b\n" "$RED" "$STANDARD" "$NO_COLOR"
    FAILURES=true
  fi
done
if [[ "$FAILURES" ]]; then
  exit 1
fi

# Place a good test file.
printf "<?php\n\n/**\n * @file\n * Good test file.\n */\n" > good.php

# Test that the SUT's standards can be run.
EXPECTED=(
  AcquiaDrupalStrict
  AcquiaDrupalTransitional
  AcquiaPHP
)
for STANDARD in "${EXPECTED[@]}"; do
  ./vendor/bin/phpcs -v --standard="$STANDARD" good.php
done

GREEN="\033[1;32m\033[1;7m"
printf "\n%b PASS! %b\n\n" "$GREEN" "$NO_COLOR"
