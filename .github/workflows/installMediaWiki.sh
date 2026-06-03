#! /bin/bash

MW_BRANCH=$1
DB=$2
SMW=$3
EXTENSION_NAME=$4

rm -rf mediawiki

wget "https://github.com/wikimedia/mediawiki/archive/refs/heads/$MW_BRANCH.tar.gz" -nv

tar -zxf $MW_BRANCH.tar.gz
mv mediawiki-$MW_BRANCH mediawiki

cd mediawiki

# `phpunit.xml.dist` is `export-ignore`d in MediaWiki's .gitattributes, so the
# GitHub source tarball doesn't include it — fetch it separately. MW master
# renamed the file to `phpunit.xml.template` (read by
# tests/phpunit/generatePHPUnitConfig.php); REL1_43 still reads `.dist`. Leave
# wget to save under the URL's basename so the file lands under the name MW
# core expects on that branch.
wget -nv "https://raw.githubusercontent.com/wikimedia/mediawiki/$MW_BRANCH/phpunit.xml.dist" || \
    wget -nv "https://raw.githubusercontent.com/wikimedia/mediawiki/$MW_BRANCH/phpunit.xml.template"

composer install
if [ "$DB" = "mysql" ]; then
    php maintenance/install.php --dbtype mysql --dbserver 127.0.0.1:3306 --dbuser mediawiki --dbpass mediawiki \
        --dbname mediawiki --pass AdminPassword WikiName AdminUser
else
    php maintenance/install.php --dbtype sqlite --dbuser root --dbname mw --dbpath $(pwd) \
        --pass AdminPassword WikiName AdminUser
fi

# MediaWiki 1.46 replaced `phpunit.xml.dist` with `phpunit.xml.template`, which
# is turned into a runnable `phpunit.xml` by `generatePHPUnitConfig.php`. The
# extension's `composer phpunit` script invokes `-c phpunit.xml.dist`, so on
# branches that only ship a template, generate the config and expose it under the
# name the script expects. Generated here (after `composer install` provides the
# autoloader, before the extension load lines are appended to LocalSettings.php).
if [ ! -f phpunit.xml.dist ] && [ -f phpunit.xml.template ]; then
    php tests/phpunit/generatePHPUnitConfig.php
    cp phpunit.xml phpunit.xml.dist
fi

cat <<'EOT' >> LocalSettings.php
error_reporting(E_ALL| E_STRICT);
ini_set("display_errors", "1");
$wgShowExceptionDetails = true;
$wgShowDBErrorBacktrace = true;
EOT

cat <<EOT >> LocalSettings.php
wfLoadExtension( 'SemanticMediaWiki' );
wfLoadExtension( "$EXTENSION_NAME" );
EOT

cat <<EOT >> composer.local.json
{
	"require": {
		"mediawiki/semantic-media-wiki": "$SMW"
	},
	"extra": {
		"merge-plugin": {
			"merge-dev": true,
			"include": [
				"extensions/$EXTENSION_NAME/composer.json"
			]
		}
	}
}
EOT
