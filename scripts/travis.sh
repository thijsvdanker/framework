#!/bin/bash

# e causes to exit when one commands returns non-zero
# v prints every line before executing
set -ev

cd ${TRAVIS_BUILD_DIR}/laravel

BRANCH_REGEX="^(([[:digit:]]+\.)+[[:digit:]]+)$"

if [[ ${TRAVIS_BRANCH} =~ $BRANCH_REGEX ]]; then
    echo "composer require hyn/framework:${TRAVIS_BRANCH}"
    composer require hyn/framework:${TRAVIS_BRANCH}
else
    echo "composer require ${TRAVIS_REPO_SLUG}:dev-${TRAVIS_BRANCH}"
    composer require hyn/framework:dev-${TRAVIS_BRANCH}
fi

# moves the unit test to the root laravel directory
cp ./vendor/hyn/framework/phpunit.travis.xml ./phpunit.xml

phpunit