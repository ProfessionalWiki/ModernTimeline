<?php

declare( strict_types = 1 );

// Semantic MediaWiki 7 dropped the composer PSR-4 autoload for the SMW\
// namespace (its composer.json `autoload` is now `files` only); SMW is loaded
// through MediaWiki's extension registration at runtime instead. PHPStan
// analyses this extension without booting MediaWiki, so register the mapping
// here — matching SMW's extension.json AutoloadNamespaces ("SMW\\": "src/") —
// so classes such as the SMW\Query\ResultPrinter that ModernTimelinePrinter
// implements can be reflected.
spl_autoload_register( static function ( string $class ): void {
	if ( strncmp( $class, 'SMW\\', 4 ) !== 0 ) {
		return;
	}

	$path = __DIR__ . '/../SemanticMediaWiki/src/'
		. str_replace( '\\', '/', substr( $class, 4 ) ) . '.php';

	if ( is_file( $path ) ) {
		require_once $path;
	}
} );
