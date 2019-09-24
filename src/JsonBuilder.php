<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\SubjectCollection;
use ModernTimeline\SlidePresenter\SlidePresenter;
use SMWDITime;

class JsonBuilder {

	private $slidePresenter;

	public function __construct( SlidePresenter $slidePresenter ) {
		$this->slidePresenter = $slidePresenter;
	}

	public function buildTimelineJson( SubjectCollection $pages ): array {
		return $this->eventsToTimelineJson( ( new EventExtractor() )->extractEvents( $pages ) );
	}

	/**
	 * @param Event[] $events
	 * @return array
	 */
	private function eventsToTimelineJson( array $events ): array {
		$jsonEvents = [];

		foreach ( $events as $event ) {
			$jsonEvents[] = $this->buildEvent( $event );
		}

		return [ 'events' => $jsonEvents ];
	}

	public function buildEvent( Event $event ): array {
		$jsonEvent = [
			'text' => [
				'headline' => $this->newHeadline( $event->getSubject()->getWikiPage()->getTitle() ),
				'text' =>  $this->slidePresenter->getText( $event->getSubject() )
			],
			'start_date' => $this->timeToJson( $event->getStartDate() ),
//			'media' => [
//				'thumbnail' => 'http://default.web.mw.localhost:8080/mediawiki/images/docker/default/3/35/Media.png'
//			]
		];

		if ( $event->getEndDate() !== null ) {
			$jsonEvent['end_date'] = $this->timeToJson( $event->getEndDate() );
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
