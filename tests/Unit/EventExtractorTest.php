<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\Event;
use ModernTimeline\EventExtractor;
use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use PHPUnit\Framework\TestCase;
use SMW\DataItems\Time;
use SMW\DataItems\WikiPage;
use SMW\Query\PrintRequest;
use MediaWiki\Title\Title;

/**
 * @covers \ModernTimeline\EventExtractor
 */
class EventExtractorTest extends TestCase {

	public function testEmptySubjectCollection() {
		$this->assertExtractsEvents(
			[],
			new SubjectCollection()
		);
	}

	private function assertExtractsEvents( array $expectedEvents, SubjectCollection $subjects ) {
		$this->assertEquals(
			$expectedEvents,
			( new EventExtractor( [ 'image property' => '' ] ) )->extractEvents( $subjects )
		);
	}

	public function testOnlySubjectsWithNoValues() {
		$this->assertExtractsEvents(
			[],
			new SubjectCollection(
				new Subject(
					$this->newDiWikiPage(),
					[]
				)
			)
		);
	}

	private function newDiWikiPage( string $pageName = 'Some page' ): WikiPage {
		$page = $this->createMock( WikiPage::class );

		$page->method( 'getTitle' )->willReturn( Title::newFromText( $pageName ) );

		return $page;
	}

	public function testSingleSubjectWithStartDate() {
		$subject = new Subject(
			$this->newDiWikiPage(),
			[
				$this->newStartDateValueCollection()
			]
		);

		$this->assertExtractsEvents(
			[
				new Event(
					$subject,
					$this->newStartDate(),
					null
				)
			],
			new SubjectCollection( $subject )
		);
	}

	private function newStartDateValueCollection(): PropertyValueCollection {
		return new PropertyValueCollection(
			$this->newDatePrintRequestWithLabel( 'Has date' ),
			[
				$this->newStartDate()
			]
		);
	}

	private function newDatePrintRequestWithLabel( string $label ): PrintRequest {
		$pr = $this->createMock( PrintRequest::class );
		$pr->method( 'getLabel' )->willReturn( $label );
		$pr->method( 'getTypeID' )->willReturn( '_dat' );
		return $pr;
	}

	private function newStartDate(): Time {
		return new Time(
			Time::CM_GREGORIAN,
			2019,
			8,
			2,
			16,
			7,
			42
		);
	}

}
