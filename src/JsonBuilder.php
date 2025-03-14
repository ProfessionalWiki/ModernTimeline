<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\SubjectCollection;
use ModernTimeline\SlidePresenter\SlidePresenter;
use SMWDITime;

class JsonBuilder {

	public function __construct(
		private SlidePresenter $slidePresenter
	) {
	}

	/**
	 * @param Event[] $events
	 * @return array
	 */
	public function eventsToTimelineJson( array $events ): array {
		$jsonEvents = [];

		foreach ( $events as $event ) {
			if ( $event->getSubject()->getWikiPage()->getTitle() !== null ) {
				$jsonEvents[] = $this->buildEvent( $event );
			}
		}

		return [ 'events' => $jsonEvents ];
	}

	public function buildEvent( Event $event ): array {
		$jsonEvent = [
			'text' => [
				'headline' => $this->newHeadline( $event->getSubject()->getWikiPage()->getTitle() ),
				'text' => $this->slidePresenter->getText( $event->getSubject() )
			],
			'start_date' => $this->timeToJson( $event->getStartDate() ),
		];

		if ( $event->getEndDate() !== null ) {
			$jsonEvent['end_date'] = $this->timeToJson( $event->getEndDate() );
		}

		if ( $event->hasImage() ) {
			$jsonEvent['media'] = [
				'url' => $event->getImageUrl(),
				'thumbnail' => $event->getImageUrl()
			];
		}

		return $jsonEvent;
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
