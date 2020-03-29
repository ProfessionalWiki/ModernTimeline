<?php

declare( strict_types = 1 );

namespace ModernTimeline\SlidePresenter;

use ModernTimeline\ResultFacade\Subject;
use SMW\DataValueFactory;
use SMW\Query\PrintRequest;

class SimpleSlidePresenter implements SlidePresenter {

	private $parameters;

	public function __construct( array $parameters ) {
		$this->parameters = $parameters;
	}

	public function getText( Subject $subject ): string {
		return implode( '<br>', iterator_to_array( $this->getDisplayValues( $subject ) ) );
	}

	private function getDisplayValues( Subject $subject ) {
		foreach ( $subject->getPropertyValueCollections() as $propertyValues ) {
			foreach ( $propertyValues->getDataItems() as $dataItem ) {
				if ( !$this->isHiddenPrintRequest( $propertyValues->getPrintRequest() ) ) {
					yield $this->getDisplayValue( $propertyValues->getPrintRequest(), $dataItem );
				}
			}
		}
	}

	private function isHiddenPrintRequest( PrintRequest $pr ) {
		return $pr->getText( null ) === $this->parameters['image property'];
	}

	private function getDisplayValue( PrintRequest $pr, \SMWDataItem $dataItem ) {
		$property = $pr->getText( null );
		$value = $this->dataItemToText( $dataItem );

		if ( $property === '' ) {
			return $value;
		}

		return $property . ': ' . $value;
	}

	private function dataItemToText( \SMWDataItem $dataItem ): string {
		return DataValueFactory::getInstance()->newDataValueByItem( $dataItem )->getLongHTMLText();
	}

}
