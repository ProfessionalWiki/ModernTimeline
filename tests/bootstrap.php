<?php

declare( strict_types = 1 );

if ( PHP_SAPI !== 'cli' ) {
	die( 'Not an entry point' );
}

error_reporting( -1 );
ini_set( 'display_errors', '1' );

if ( !is_readable( $autoloaderClassPath = __DIR__ . '/../../SemanticMediaWiki/tests/autoloader.php' ) ) {
	die( "\nThe Semantic MediaWiki test autoloader is not available" );
}

require $autoloaderClassPath;

$autoloader->addPsr4( 'SMW\\Tests\\', __DIR__ . '/../../SemanticMediaWiki/tests/phpunit' );
