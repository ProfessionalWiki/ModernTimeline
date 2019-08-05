<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit\SlidePresenter;

use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\SlidePresenter\TemplateSlidePresenter;
use PHPUnit\Framework\TestCase;
use SMW\DIWikiPage;
use SMW\Query\PrintRequest;
use SMWDITime;

/**
 * @covers \ModernTimeline\SlidePresenter\TemplateSlidePresenter
 */
class TemplateSlidePresenterTest extends TestCase {

	private const PAGE_NAME = 'Some Page';

	public function testTemplate() {
		$this->assertSame(
			'{{TemplateName|title=Some Page|Has date=2 August 2019 16:07:42|End date=5 August 2019 17:39:23}}',
			( new TemplateSlidePresenter( 'TemplateName' ) )->getTemplateText( $this->newSinglePageWithStartAndEndDate() )
		);
	}

	private function newSinglePageWithStartAndEndDate(): Subject {
		return new Subject(
			$this->newDiWikiPage(),
			[
				new PropertyValueCollection(
					$this->newDatePrintRequestWithLabel( 'Has date' ),
					[
						new SMWDITime(
							SMWDITime::CM_GREGORIAN,
							2019,
							8,
							2,
							16,
							7,
							42
						)
					]
				),
				new PropertyValueCollection(
					$this->newDatePrintRequestWithLabel( 'End date' ),
					[
						new SMWDITime(
							SMWDITime::CM_GREGORIAN,
							2019,
							8,
							5,
							17,
							39,
							23
						)
					]
				)
			]
		);
	}

	private function newDiWikiPage(): DIWikiPage {
		$page = $this->createMock( DIWikiPage::class );

		$page->method( 'getTitle' )->willReturn( \Title::newFromText( self::PAGE_NAME ) );

		return $page;
	}

	private function newDatePrintRequestWithLabel( string $label ): PrintRequest {
		$pr = $this->createMock( PrintRequest::class );
		$pr->method( 'getLabel' )->willReturn( $label );
		$pr->method( 'getText' )->willReturn( $label );
		$pr->method( 'getTypeID' )->willReturn( '_dat' );
		return $pr;
	}

}
