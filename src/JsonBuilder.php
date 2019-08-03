<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use SMWDITime;

class JsonBuilder {

	private $events;

	public function buildTimelineJson( SubjectCollection $pages ): array {
		$this->events = [];

		foreach ( $pages->getSubjects() as $page ) {
			$this->addObject( $page );
		}

		return [ 'events' => $this->events ];
	}

	private function addObject( Subject $subject ) {
		foreach ( $subject->getPropertyValueCollections() as $propertyValues ) {
			$dataItems = $propertyValues->getDataItems();

			if ( array_key_exists( 0, $dataItems ) ) {
				$dataItem = $dataItems[0];

				if ( $dataItem instanceof SMWDITime ) {
					$this->events[] = [
						'text' => [
							'headline' => $subject->getWikiPage()->getTitle()->getPrefixedText(),
							'text' => 'hi there i am a text' // TODO
						],
						'start_date' => $this->timeToJson( $dataItem )
					];
				}
			}
		}
	}

	private function timeToJson( SMWDITime $time ): array {
		return [
			'year' => $time->getYear(),
			'month' => $time->getMonth(),
			'day' => $time->getDay(),
			'hour' => $time->getHour(),
			'minute' => $time->getMinute(),
			'second' => (int)$time->getSecond(),
		];
	}

}
