<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use SMW\Query\QueryResult;
use SMW\Query\Result\ResultArray;
use SMWDITime;

class JsonBuilder {

	private $events;

	public function buildTimelineJson( QueryResult $result ): array {
		$this->events = [];

		while ( $object = $result->getNext() ) {
			$this->addObject( $object );
		}

		return [ 'events' => $this->events ];
	}

	/**
	 * @param ResultArray[] $object Represents a single page or subobject
	 */
	private function addObject( array $object ) {
		$pageStuff = array_shift( $object );

		foreach ( $object as $propertyValues ) {
			$dataItem = $propertyValues->getNextDataItem();

			if ( $dataItem instanceof SMWDITime ) {
				$this->events[] = [
					'text' => [
						'headline' => $pageStuff->getContent()[0]->getTitle()->getPrefixedText()
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
