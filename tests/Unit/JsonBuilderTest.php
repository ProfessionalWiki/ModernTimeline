<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\Event;
use ModernTimeline\JsonBuilder;
use ModernTimeline\ResultFacade\PropertyValueCollection;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\SlidePresenter\SimpleSlidePresenter;
use PHPUnit\Framework\TestCase;
use SMW\DIWikiPage;
use SMW\Query\PrintRequest;
use SMWDITime;
use Title;

/**
 * @covers \ModernTimeline\JsonBuilder
 */
class JsonBuilderTest extends TestCase {

	private const PAGE_NAME = 'Some Page';

	public function testStartDate() {
		$json = $this->toJson( $this->newEventWithStartAndEndDate() );

		$this->assertSame(
			[
				'year' => 2019,
				'month' => 8,
				'day' => 2,
				'hour' => 16,
				'minute' => 7,
				'second' => 42,
			],
			$json['events'][0]['start_date']
		);
	}

	private function toJson( Event ...$events ): array {
		return ( new JsonBuilder( new SimpleSlidePresenter() ) )->eventsToTimelineJson( $events );
	}

	private function newEventWithStartAndEndDate(): Event {
		return new Event(
			$this->newSubjectWithStartAndEndDate(),
			$this->newStartDate(),
			$this->newEndDate()
		);
	}

	private function newSubjectWithStartAndEndDate(): Subject {
		return new Subject(
			$this->newDiWikiPage(),
			[
				$this->newStartDateValueCollection(),
				$this->newEndDateValueCollection()
			]
		);
	}

	private function newDiWikiPage( string $pageName = self::PAGE_NAME ): DIWikiPage {
		$page = $this->createMock( DIWikiPage::class );

		$page->method( 'getTitle' )->willReturn( Title::newFromText( $pageName ) );

		return $page;
	}

	private function newStartDateValueCollection(): PropertyValueCollection {
		return new PropertyValueCollection(
			$this->newDatePrintRequestWithLabel( 'Has date' ),
			[
				$this->newStartDate()
			]
		);
	}

	private function newStartDate(): SMWDITime {
		return new SMWDITime(
			SMWDITime::CM_GREGORIAN,
			2019,
			8,
			2,
			16,
			7,
			42
		);
	}

	private function newEndDateValueCollection(): PropertyValueCollection {
		return new PropertyValueCollection(
			$this->newDatePrintRequestWithLabel( 'End date' ),
			[
				$this->newEndDate()
			]
		);
	}

	private function newEndDate(): SMWDITime {
		return new SMWDITime(
			SMWDITime::CM_GREGORIAN,
			2019,
			8,
			5,
			17,
			39,
			23
		);
	}

	private function newDatePrintRequestWithLabel( string $label ): PrintRequest {
		$pr = $this->createMock( PrintRequest::class );
		$pr->method( 'getLabel' )->willReturn( $label );
		$pr->method( 'getTypeID' )->willReturn( '_dat' );
		return $pr;
	}

	public function testEndDate() {
		$json = $this->toJson( $this->newEventWithStartAndEndDate() );

		$this->assertSame(
			[
				'year' => 2019,
				'month' => 8,
				'day' => 5,
				'hour' => 17,
				'minute' => 39,
				'second' => 23,
			],
			$json['events'][0]['end_date']
		);
	}

	public function testHeadline() {
		$json = $this->toJson( $this->newEventWithStartAndEndDate() );

		$this->assertContains(
			self::PAGE_NAME,
			$json['events'][0]['text']['headline']
		);
	}

	public function testPageWithStartAndEndDateOnlyLeadsToOneEvent() {
		$this->assertCount(
			1,
			$this->toJson( $this->newEventWithStartAndEndDate() )['events']
		);
	}

	public function testEventWithoutImageHasNoMedia() {
		$this->assertArrayNotHasKey(
			'media',
			$this->toJson( $this->newEventWithStartAndEndDate() )['events'][0]
		);
	}

}
