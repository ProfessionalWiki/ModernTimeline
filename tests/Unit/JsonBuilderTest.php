<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\JsonBuilder;
use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use PHPUnit\Framework\TestCase;
use SMW\DIWikiPage;
use SMW\Query\PrintRequest;
use SMWDITime;

/**
 * @covers \ModernTimeline\JsonBuilder
 */
class JsonBuilderTest extends TestCase {

	public function testEmptySubjectCollection() {
		$this->assertBuildsJson(
			[],
			new SubjectCollection( [] )
		);
	}

	private function newDiWikiPage( string $pageName = 'SomePage' ): DIWikiPage {
		$page = $this->createMock( DIWikiPage::class );

		$page->method( 'getTitle' )->willReturn( \Title::newFromText( $pageName ) );

		return $page;
	}

	public function assertBuildsJson( array $expectedJson, SubjectCollection $input ) {
		$this->assertSame(
			[
				'events' => $expectedJson
			],
			( new JsonBuilder() )->buildTimelineJson( $input )
		);
	}

	public function testOnlySubjectsWithNoValues() {
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

	public function testSingleTimeValue() {
		$this->assertBuildsJson(
			[
				[
					'text' => [
						'headline' => 'SomePage',
						'text' => 'hi there i am a text',
					],
					'start_date' => [
						'year' => 2019,
						'month' => 8,
						'day' => 2,
						'hour' => 16,
						'minute' => 7,
						'second' => 42,
					]
				]
			],
			new SubjectCollection(
				[
					new Subject(
						$this->newDiWikiPage(),
						[
							new PropertyValueCollection(
								$this->newPrintRequestWithLabel( 'Has date' ),
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
							)
						]
					)
				]
			)
		);
	}

	private function newPrintRequestWithLabel( string $label ): PrintRequest {
		$pr = $this->createMock( PrintRequest::class );
		$pr->method( 'getLabel' )->willReturn( $label );
		return $pr;
	}

}
