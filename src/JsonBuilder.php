<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use SMW\DIWikiPage;
use SMWDITime;

class JsonBuilder {

	private $events;

	public function buildTimelineJson( SubjectCollection $pages ): array {
		$this->events = [];

		foreach ( $pages->getSubjects() as $page ) {
			$this->addEventsForSubject( $page );
		}

		return [ 'events' => $this->events ];
	}

	private function addEventsForSubject( Subject $subject ) {
		[ $startDate, $endDate ] = $this->getDates( $subject );

		if ( $startDate !== null ) {
			$this->events[] = $this->buildEvent(
				$subject->getWikiPage(),
				$startDate,
				$endDate
			);
		}
	}

	private function buildEvent( DIWikiPage $page, SMWDITime $startDate, ?SMWDITime $endDate ): array {
		$event = [
			'text' => [
				'headline' => $this->newHeadline( $page->getTitle() ),
				'text' => 'hi there i am a text' // TODO
			],
			'start_date' => $this->timeToJson( $startDate )
		];

		if ( $endDate !== null ) {
			$event['end_date'] = $this->timeToJson( $endDate );
		}

		return $event;
	}

	private function getDates( Subject $subject ): array {
		$startDate = null;
		$endDate = null;

		foreach ( $subject->getPropertyValueCollections() as $propertyValues ) {
			$dataItems = $propertyValues->getDataItems();

			if ( array_key_exists( 0, $dataItems ) ) {
				$dataItem = $dataItems[0];

				if ( $dataItem instanceof SMWDITime ) {
					if ( $startDate === null ) {
						$startDate = $dataItem;
					}
					else if ( $endDate === null ) {
						$endDate = $dataItem;
					}
					else {
						break;
					}
				}
			}
		}

		return [ $startDate, $endDate ];
	}

	private function newHeadline( \Title $title ): string {
		return \Html::element(
			'a',
			[ 'href' => $title->getFullURL() ],
			$title->getText()
		);

//		return DataValueFactory::getInstance()->newDataValueByItem( $subject->getWikiPage() )->getLongHTMLText( smwfGetLinker() );
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
