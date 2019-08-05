<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use SMW\DataValueFactory;

class TemplateBuilder {

	private $templateName;

	public function __construct( string $templateName ) {
		$this->templateName = $templateName;
	}

	public function getTemplateText( Subject $subject ): string {
		return '{{' . implode( '|', $this->getTemplateSegments( $subject ) ) . '}}';
	}

	private function getTemplateSegments( Subject $subject ): array {
		return array_merge(
			[
				$this->templateName,
				$this->parameter( 'title', $subject->getWikiPage()->getTitle()->getFullText() )
			],
			array_map(
				function( PropertyValueCollection $pvc ) {
					return $this->parameter(
						$pvc->getPrintRequest()->getText( null ) ?? '',
						$pvc->getDataItems() === [] ? '' : $this->dataItemToText( $pvc->getDataItems()[0] )
					);
				},
				$subject->getPropertyValueCollections()
			)
		);
	}

	private function dataItemToText( \SMWDataItem $dataItem ): string {
		return DataValueFactory::getInstance()->newDataValueByItem( $dataItem )->getLongHTMLText();
	}

	private function parameter( string $name, string $value ): string {
		return $name . '=' . $value;
	}

}
