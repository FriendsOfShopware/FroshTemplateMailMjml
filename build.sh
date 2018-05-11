#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$(git tag --sort=-creatordate | head -1)
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

# Remove old release
rm -rf FroshTemplateMailMjml FroshTemplateMailMjml-*.zip

# Build new release
mkdir -p FroshTemplateMailMjml
git archive ${commit} | tar -x -C FroshTemplateMailMjml
composer install --no-dev -n -o -d FroshTemplateMailMjml
( find ./FroshTemplateMailMjml -type d -name ".git" && find ./FroshTemplateMailMjml -name ".gitignore" && find ./FroshTemplateMailMjml -name ".gitmodules" ) | xargs rm -r
zip -r FroshTemplateMailMjml-${commit}.zip FroshTemplateMailMjml