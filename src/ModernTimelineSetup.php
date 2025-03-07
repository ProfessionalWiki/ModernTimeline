<?php

declare( strict_types = 1 );

namespace ModernTimeline;

class ModernTimelineSetup {

	public static function onExtensionFunction(): void {
		self::doSmwCheck();

		$GLOBALS['smwgResultFormats']['moderntimeline'] = ModernTimelinePrinter::class;
	}

	private static function doSmwCheck(): void {
		if ( !defined( 'SMW_VERSION' ) ) {

			if ( PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg' ) {
				die( "\nThe 'Modern Timeline' extension requires 'Semantic MediaWiki' to be installed and enabled.\n" );
			}

			die(
				'<b>Error:</b> The <a href="https://github.com/ProfessionalWiki/ModernTimeline">Modern Timeline</a> ' .
				'extension requires <a href="https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> to be ' .
				'installed and enabled.<br />'
			);
		}
	}

}
