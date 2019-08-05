<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMWDITime;

class Event {

	private $subject;
	private $startDate;
	private $endDate;

	public function __construct( Subject $subject, SMWDITime $startDate, ?SMWDITime $endDate ) {
		$this->subject = $subject;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}

	public function getSubject(): Subject {
		return $this->subject;
	}

	public function getStartDate(): SMWDITime {
		return $this->startDate;
	}

	public function getEndDate(): ?SMWDITime {
		return $this->endDate;
	}

}
