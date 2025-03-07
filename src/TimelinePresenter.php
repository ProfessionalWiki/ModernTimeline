<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\SimpleQueryResult;
use ModernTimeline\ResultFacade\ResultPresenter;
use ModernTimeline\SlidePresenter\SimpleSlidePresenter;
use ModernTimeline\SlidePresenter\SlidePresenter;
use ModernTimeline\SlidePresenter\TemplateSlidePresenter;
use SMWOutputs;

class TimelinePresenter implements ResultPresenter {

	private string $id;

	public function __construct() {
		$this->id = $this->newTimelineId();
	}

	private function newTimelineId(): string {
		static $timelineNumber = 0;
		return 'modern_timeline_' . ++$timelineNumber;
	}

	public function presentResult( SimpleQueryResult $result ): string {
		SMWOutputs::requireResource( 'ext.modern.timeline' );

		SMWOutputs::requireHeadItem(
			$this->id,
			$this->createJs( $this->createJsonString( $result ) )
		);

		return $this->createDiv( $result->getParameters() );
	}

	private function createJsonString( SimpleQueryResult $result ): string {
		$preJson = $this->newJsonBuilder( $result )
			->eventsToTimelineJson( ( new EventExtractor( $result->getParameters() ) )->extractEvents( $result->getSubjects() ) );

		$preJson['options'] = TimelineOptions::processedParamsToJson( $result->getParameters() );

		return json_encode( $preJson );
	}

	private function newJsonBuilder( SimpleQueryResult $result ): JsonBuilder {
		return new JsonBuilder(
			$this->getSlidePresenter( $result )
		);
	}

	private function getSlidePresenter( SimpleQueryResult $result ): SlidePresenter {
		$templateName = $result->getParameters()['template'];

		if ( $templateName === '' ) {
			return new SimpleSlidePresenter( $result->getProcessingResult()->getParameterArray() );
		}

		return new TemplateSlidePresenter( $templateName );
	}

	private function createJs( string $json ): string {
		return \Html::rawElement(
			'script',
			[
				'type' => 'text/javascript'
			],
			"if (!window.hasOwnProperty('modernTimeline')) {window.modernTimeline = {};}"
			. "\n window.modernTimeline.{$this->id} = $json;"
		);
	}

	private function createDiv( array $parameters ): string {
		$width = $parameters[TimelineOptions::PARAM_WIDTH];
		$height = $parameters[TimelineOptions::PARAM_HEIGHT];

		return \Html::rawElement(
			'div',
			[
				'id' => $this->id,
				'style' => "width: $width; height: $height",
				'class' => 'modern_timeline_outer_div'
			],
			\Html::element(
				'div',
				[
					'class' => 'modern_timeline_inner_div',
					'style' => 'width: 100%; height: calc(100% - 10px); background-color: rgba(0, 0, 0, 0.05); margin-top: 5px; margin-bottom: 5px;'
				]
			)
		);
	}

}
