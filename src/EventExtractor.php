<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\PropertyValues;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use SMWDITime;

class EventExtractor {

	/**
	 * @param SubjectCollection $pages
	 * @return Event[]
	 */
	public function extractEvents( SubjectCollection $pages ): array {
		$events = [];

		foreach ( $pages->getSubjects() as $subject ) {
			[ $startDate, $endDate ] = $this->getDates( $subject );

			if ( $startDate !== null ) {
				$events[] = new Event( $subject, $startDate, $endDate );
			}
		}

		return $events;
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
	 * @return PropertyValues[]
	 */
	private function getPropertyValueCollectionsWithDates( Subject $subject ) {
		return array_filter(
			$subject->getPropertyValueCollections(),
			function( PropertyValues $pvc ) {
				return $pvc->getPrintRequest()->getTypeID() === '_dat'
					&& $pvc->getDataItems() !== [];
			}
		);
	}

}
