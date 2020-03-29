<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use RepoGroup;
use SMW\DIWikiPage;
use SMWDITime;

class EventExtractor {

	private $parameters;

	public function __construct( array $parameters ) {
		$this->parameters = $parameters;
	}

	/**
	 * @param SubjectCollection $pages
	 * @return Event[]
	 */
	public function extractEvents( SubjectCollection $pages ): array {
		$events = [];

		foreach ( $pages->getSubjects() as $subject ) {
			[ $startDate, $endDate ] = $this->getDates( $subject );

			if ( $startDate !== null ) {
				$event = new Event( $subject, $startDate, $endDate );

				foreach ( $subject->getPropertyValueCollections() as $propertyValues ) {
					if ( $propertyValues->getPrintRequest()->getText( null ) === $this->parameters['image property'] ) {
						foreach ( $propertyValues->getDataItems() as $dataItem ) {
							if ( $this->isImageValue( $dataItem ) ) {
								$event->setImageUrl( $this->getUrlForFileTitle( $dataItem->getTitle() ) );
							}
						}
					}
				}

				$events[] = $event;
			}
		}

		return $events;
	}

	private function isImageValue( \SMWDataItem $dataItem ) {
		return $dataItem instanceof DIWikiPage
			&& $dataItem->getTitle() instanceof \Title
			&& $dataItem->getTitle()->getNamespace() === NS_FILE
			&& $dataItem->getTitle()->exists();
	}

	public function getUrlForFileTitle( \Title $existingTitle ): string {
		return RepoGroup::singleton()->findFile( $existingTitle )->getURL();
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
					break;
				}
			}
		}

		return [ $startDate, $endDate ];
	}

	/**
	 * @return PropertyValueCollection[]
	 */
	private function getPropertyValueCollectionsWithDates( Subject $subject ) {
		return array_filter(
			$subject->getPropertyValueCollections()->toArray(),
			function( PropertyValueCollection $pvc ) {
				return $pvc->getPrintRequest()->getTypeID() === '_dat'
					&& $pvc->getDataItems() !== [];
			}
		);
	}

}
