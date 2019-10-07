<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use ParamProcessor\ProcessingResult;

class SimpleQueryResult {

	private $subjects;
	private $processingResult;

	public function __construct( SubjectCollection $subjects, ProcessingResult $processingResult ) {
		$this->subjects = $subjects;
		$this->processingResult = $processingResult;
	}

	public function getSubjects(): SubjectCollection {
		return $this->subjects;
	}

	public function getParameters(): array {
		return $this->processingResult->getParameterArray();
	}

	public function getProcessingResult(): ProcessingResult {
		return $this->processingResult;
	}

}
