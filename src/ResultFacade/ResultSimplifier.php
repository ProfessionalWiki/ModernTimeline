<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\DIWikiPage;
use SMW\Query\PrintRequest;
use SMWQueryResult;

class ResultSimplifier {

	public function newSubjectCollection( SMWQueryResult $result ): SubjectCollection {
		$subjects = [];

		foreach ( $result->getResults() as $diWikiPage ) {
			$subjects[] = $this->newSubject( $diWikiPage, $result->getPrintRequests(), $result );
		}

		return new SubjectCollection( $subjects );
	}

	/**
	 * @param DIWikiPage $resultPage
	 * @param PrintRequest[] $printRequests
	 * @param SMWQueryResult $result
	 * @return Subject
	 */
	private function newSubject( DIWikiPage $resultPage, array $printRequests, SMWQueryResult $result ): Subject {
		$propertyValueCollections = [];

		foreach ( $printRequests as $printRequest ) {
			$dataItems = ( new \SMWResultArray( $resultPage, $printRequest, $result->getStore() ) )->getContent();

			$propertyValueCollections[] = new PropertyValueCollection(
				$printRequest,
				$dataItems === false ? [] : $dataItems
			);
		}

		return new Subject( $resultPage, $propertyValueCollections );
	}

}
