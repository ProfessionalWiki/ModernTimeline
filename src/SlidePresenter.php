<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMW\DataValueFactory;
use SMW\Query\PrintRequest;

class SlidePresenter {

	public function getText( Subject $subject ): string {
		return implode( "<br>", iterator_to_array( $this->getDisplayValues( $subject ) ) );
	}

	private function getDisplayValues( Subject $subject ) {
		foreach ( $subject->getPropertyValueCollections() as $propertyValues ) {
			foreach ( $propertyValues->getDataItems() as $dataItem ) {
				yield $this->getDisplayValue( $propertyValues->getPrintRequest(), $dataItem );
			}
		}
	}

	private function getDisplayValue( PrintRequest $pr, \SMWDataItem $dataItem ) {
		$property = $pr->getText( null );
		$value = DataValueFactory::getInstance()->newDataValueByItem( $dataItem )->getLongHTMLText();

		if ( $property === '' ) {
			return $value;
		}

		return $property . ': ' . $value;
	}

}
