<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\JsonBuilder;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use PHPUnit\Framework\TestCase;
use SMW\DIWikiPage;

/**
 * @covers \ModernTimeline\JsonBuilder
 */
class JsonBuilderTest extends TestCase {

	public function testEmptySubjectCollection() {
		$this->assertBuildsJson(
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

	private function newDiWikiPage(): DIWikiPage {
		return $this->createMock( DIWikiPage::class );
	}

	public function assertBuildsJson( array $expectedJson, SubjectCollection $input ) {
		$this->assertSame(
			[
				'events' => $expectedJson
			],
			( new JsonBuilder() )->buildTimelineJson( $input )
		);
	}

}
