<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\Query\Result\ResultArray;

/**
 * Represents a single page or subobject
 */
class Page {

	private $resultArrays;

	/**
	 * @param ResultArray[] $resultArrays
	 */
	public function __construct( array $resultArrays ) {
		$this->resultArrays = $resultArrays;
	}

	public function getPageStuff(): ResultArray {
		return $this->resultArrays[0];
	}

	/**
	 * @return ResultArray[]
	 */
	public function getPropertyValueSets(): array {
		return array_slice( $this->resultArrays, 1 );
	}

}