<?php

declare( strict_types = 1 );

namespace ModernTimeline\SlidePresenter;

use MediaWiki\MediaWikiServices;
use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use SMW\DataValueFactory;

class TemplateSlidePresenter implements SlidePresenter {

	public function __construct(
		private string $templateName
	) {
	}

	public function getText( Subject $subject ): string {
		$parser = $this->getParser();

		return $parser->recursiveTagParseFully(
			( new TemplateSlidePresenter( $this->templateName ) )->getTemplateText( $subject )
		);
	}

	private function getParser(): \Parser {
		return MediaWikiServices::getInstance()->getParser();
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
				$subject->getPropertyValueCollections()->toArray()
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
