<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMWDITime;

class Event {

	private $subject;
	private $startDate;
	private $endDate;
	private $imageUrl;

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

	public function hasImage(): bool {
		return $this->imageUrl !== null;
	}

	public function getImageUrl(): string {
		return $this->imageUrl;
	}

	public function setImageUrl( string $url ) {
		$this->imageUrl = $url;
	}

}
