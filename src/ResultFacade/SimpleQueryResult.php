<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use ParamProcessor\ProcessingResult;

class SimpleQueryResult {

	public function __construct(
		private SubjectCollection $subjects,
		private ProcessingResult $processingResult
	) {
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
