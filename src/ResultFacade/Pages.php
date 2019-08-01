<?php

namespace ModernTimeline\ResultFacade;

class Pages {

	private $pages;

	/**
	 * @param Page[] $pages
	 */
	public function __construct( array $pages ) {
		$this->pages = $pages;
	}

	/**
	 * @return Page[]
	 */
	public function toArray(): array {
		return $this->pages;
	}

}
