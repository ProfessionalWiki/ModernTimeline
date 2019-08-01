<?php

namespace ModernTimeline\ResultFacade;

class SubjectCollection {

	private $pages;

	/**
	 * @param Subject[] $pages
	 */
	public function __construct( array $pages ) {
		$this->pages = $pages;
	}

	/**
	 * @return Subject[]
	 */
	public function getSubjects(): iterable {
		return $this->pages;
	}

}
