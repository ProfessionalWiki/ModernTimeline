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

composer install
if [ "$DB" = "mysql" ]; then
    php maintenance/install.php --dbtype mysql --dbserver 127.0.0.1:3306 --dbuser mediawiki --dbpass mediawiki \
        --dbname mediawiki --pass AdminPassword WikiName AdminUser
else
    php maintenance/install.php --dbtype sqlite --dbuser root --dbname mw --dbpath $(pwd) \
        --pass AdminPassword WikiName AdminUser
fi

cat <<'EOT' >> LocalSettings.php
error_reporting(E_ALL| E_STRICT);
ini_set("display_errors", "1");
$wgShowExceptionDetails = true;
$wgShowDBErrorBacktrace = true;
$wgDevelopmentWarnings = true;
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
