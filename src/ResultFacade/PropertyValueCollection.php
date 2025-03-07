<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\Query\PrintRequest;
use SMWDataItem;

class PropertyValueCollection {

	/**
	 * @param SMWDataItem[] $dataItems
	 */
	public function __construct(
		private PrintRequest $printRequest,
		private array $dataItems
	) {
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
