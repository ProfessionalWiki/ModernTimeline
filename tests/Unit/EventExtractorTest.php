<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\EventExtractor;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use PHPUnit\Framework\TestCase;
use SMW\DIWikiPage;
use Title;

/**
 * @covers \ModernTimeline\EventExtractor
 */
class EventExtractorTest extends TestCase {

	private const PAGE_NAME = 'Some Page';

	public function testEmptySubjectCollection() {
		$this->assertExtractsEvents(
			[],
			new SubjectCollection( [] )
		);
	}

	private function assertExtractsEvents( array $expectedEvents, SubjectCollection $subjects ) {
		$this->assertSame(
			$expectedEvents,
			( new EventExtractor() )->extractEvents( $subjects )
		);
	}



	public function testOnlySubjectsWithNoValues() {
		$this->assertExtractsEvents(
			[],
			new SubjectCollection(
				[
					new Subject(
						$this->newDiWikiPage(),
						[]
					)
				]
			)
		);
	}

	private function newDiWikiPage( string $pageName = self::PAGE_NAME ): DIWikiPage {
		$page = $this->createMock( DIWikiPage::class );

		$page->method( 'getTitle' )->willReturn( Title::newFromText( $pageName ) );

		return $page;
	}

}
