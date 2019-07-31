<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use SMW\Query\QueryResult;

class ResultPresenter {

	public function __construct(  ) {

	}

	public function present( QueryResult $results ): string {
		$resultText = '';

		while ( $object = $results->getNext() ) {
			foreach ( $object as $propertyValues ) {
				$resultText .= $propertyValues->getContent()[0]->getTitle()->getPrefixedText() . "<br>";
				break;
			}

		}

		return $resultText;
	}

}