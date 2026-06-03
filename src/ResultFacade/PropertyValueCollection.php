<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\Query\PrintRequest;
use SMW\DataItems\DataItem;

class PropertyValueCollection {

	/**
	 * @param DataItem[] $dataItems
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
	 * @return DataItem[]
	 */
	public function getDataItems(): array {
		return $this->dataItems;
	}

}
