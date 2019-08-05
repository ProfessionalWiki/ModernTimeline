<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\Subject;
use SMW\DataValueFactory;
use SMW\Query\PrintRequest;

class SlidePresenter {

	private $template;

	public function __construct( string $templateName = null ) {
		$this->template = $templateName;
	}

	public function getText( Subject $subject ): string {
		if ( false ) {
			$a = $this->getRenderedTemplate( $subject );
			return $a;
		}

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
		$value = $this->dataItemToText( $dataItem );

		if ( $property === '' ) {
			return $value;
		}

		return $property . ': ' . $value;
	}

	private function dataItemToText( \SMWDataItem $dataItem ): string {
		return DataValueFactory::getInstance()->newDataValueByItem( $dataItem )->getLongHTMLText();
	}

	private function getRenderedTemplate( Subject $subject ): string {
		$parser = $this->getParser( $subject->getWikiPage()->getTitle() );

		$parserOutput = $parser->parse(
			( new TemplateBuilder( 'testt' ) )->getTemplateText( $subject ),
			$subject->getWikiPage()->getTitle(),
			new \ParserOptions()
		);

		return $parserOutput->getText();
	}

	private function getParser( \Title $title ): \Parser {
		return $GLOBALS['wgParser'];
	}

}
