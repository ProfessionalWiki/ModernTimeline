<?php

namespace ModernTimeline\ResultFacade;

class SubjectCollection {

	private array $pages;

	public function __construct( Subject ...$subjects ) {
		$this->pages = $subjects;
	}

	/**
	 * @param Subject[] $subjects
	 * @return self
	 */
	public static function newFromArray( array $subjects ): self {
		$instance = new self();
		$instance->pages = $subjects;
		return $instance;
	}

	/**
	 * @return Subject[]
	 */
	public function getSubjects(): array {
		return $this->pages;
	}

}
