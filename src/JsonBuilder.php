<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use ModernTimeline\SlidePresenter\SlidePresenter;
use SMWDITime;

class JsonBuilder {

	private $slidePresenter;

	public function __construct( SlidePresenter $slidePresenter ) {
		$this->slidePresenter = $slidePresenter;
	}

	public function buildTimelineJson( SubjectCollection $pages ): array {
		$events = [];

		foreach ( $pages->getSubjects() as $subject ) {
			[ $startDate, $endDate ] = $this->getDates( $subject );

			if ( $startDate !== null ) {
				$events[] = new Event( $subject, $startDate, $endDate );
			}
		}

		return $this->eventsToTimelineJson( $events );
	}

	private function getDates( Subject $subject ): array {
		$startDate = null;
		$endDate = null;

		foreach ( $this->getPropertyValueCollectionsWithDates( $subject ) as $propertyValues ) {
			$dataItem = $propertyValues->getDataItems()[0];

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

		return [ $startDate, $endDate ];
	}

	/**
	 * @param Event[] $events
	 * @return array
	 */
	public function eventsToTimelineJson( array $events ): array {
		$jsonEvents = [];

		foreach ( $events as $event ) {
			$jsonEvents[] = $this->buildEvent( $event );
		}

		return [ 'events' => $jsonEvents ];
	}

	private function buildEvent( Event $event ): array {
		$jsonEvent = [
			'text' => [
				'headline' => $this->newHeadline( $event->getSubject()->getWikiPage()->getTitle() ),
				'text' =>  $this->slidePresenter->getText( $event->getSubject() )
			],
			'start_date' => $this->timeToJson( $event->getStartDate() )
		];

		if ( $event->getEndDate() !== null ) {
			$jsonEvent['end_date'] = $this->timeToJson( $event->getEndDate() );
		}

		return $jsonEvent;
	}

	/**
	 * @return PropertyValueCollection[]
	 */
	private function getPropertyValueCollectionsWithDates( Subject $subject ) {
		return array_filter(
			$subject->getPropertyValueCollections(),
			function( PropertyValueCollection $pvc ) {
				return $pvc->getPrintRequest()->getTypeID() === '_dat'
					&& $pvc->getDataItems() !== [];
			}
		);
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
