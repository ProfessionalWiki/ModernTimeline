<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMWDITime;

class Event {

	private string $imageUrl = '';

	public function __construct(
		private Subject $subject,
		private SMWDITime $startDate,
		private ?SMWDITime $endDate
	) {
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
		return $this->imageUrl !== '';
	}

	public function getImageUrl(): string {
		return $this->imageUrl;
	}

	public function setImageUrl( string $url ): void {
		$this->imageUrl = $url;
	}

}
