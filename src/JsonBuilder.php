<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Page;
use ModernTimeline\ResultFacade\Pages;
use SMWDITime;

class JsonBuilder {

	private $events;

	public function buildTimelineJson( Pages $pages ): array {
		$this->events = [];

		foreach ( $pages->toArray() as $page ) {
			$this->addObject( $page );
		}

		return [ 'events' => $this->events ];
	}

	private function addObject( Page $page ) {
		foreach ( $page->getPropertyValueSets() as $propertyValues ) {
			$dataItem = $propertyValues->getNextDataItem();

			if ( $dataItem instanceof SMWDITime ) {
				$this->events[] = [
					'text' => [
						'headline' => $page->getPageStuff()->getContent()[0]->getTitle()->getPrefixedText()
					],
					'start_date' => $this->timeToJson( $dataItem )
				];
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
			'second' => $time->getSecond(),
		];
	}

}
