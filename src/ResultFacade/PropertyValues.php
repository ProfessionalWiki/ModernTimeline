<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\Query\PrintRequest;
use SMWDataItem;

class PropertyValues {

	private $printRequest;
	private $dataItems;

	/**
	 * @param PrintRequest $printRequest
	 * @param SMWDataItem[] $dataItems
	 */
	public function __construct( PrintRequest $printRequest, array $dataItems ) {
		$this->printRequest = $printRequest;
		$this->dataItems = $dataItems;
	}

	public function getPrintRequest(): PrintRequest {
		return $this->printRequest;
	}

	/**
	 * @return SMWDataItem[]
	 */
	public function getDataItems(): array {
		return $this->dataItems;
	}

}
