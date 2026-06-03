<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMW\DataItems\Time;

class Event {

	private string $imageUrl = '';

	public function __construct(
		private Subject $subject,
		private Time $startDate,
		private ?Time $endDate
	) {
	}

	public function getSubject(): Subject {
		return $this->subject;
	}

	public function getStartDate(): Time {
		return $this->startDate;
	}

	public function getEndDate(): ?Time {
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
