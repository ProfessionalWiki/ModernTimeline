<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

class ResultFormatRegistry {

	/**
	 * @var ResultFormat[]
	 */
	private $resultFormats;

	public function newFormat(): ResultFormatRegistrator {
		return new ResultFormatRegistrator( function( ResultFormat $info ) {
			$this->resultFormats[$info->getName()] = $info;
		} );
	}

	public function getFormatByName( string $name ): ResultFormat {
		return $this->resultFormats[$name];
	}

}
