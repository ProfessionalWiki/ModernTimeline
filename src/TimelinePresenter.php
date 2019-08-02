<?php

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
use SMW\Query\QueryResult;
use SMWOutputs;

class TimelinePresenter {

	public function getResult( QueryResult $result, array $parameters ): string {
		SMWOutputs::requireResource( 'ext.modern.timeline' );

		$timelineId = $this->newTimelineId();

		SMWOutputs::requireScript(
			$timelineId,
			$this->createJs( $timelineId, $result, $parameters )
		);

		return $this->createDiv(
			$timelineId,
			$parameters[TimelineOptions::PARAM_WIDTH]->getValue(),
			$parameters[TimelineOptions::PARAM_HEIGHT]->getValue()
		);
	}

	private function newTimelineId(): string {
		static $timelineNumber = 0;
		return 'modern_timeline' . ++$timelineNumber;
	}

	private function createDiv( string $timelineId, string $width, string $height ): string {
		return \Html::element(
			'div',
			[
				'id' => $timelineId,
				'style' => "width: $width; height: $height;"
			],
			'Loading' // TODO
		);
	}

	private function createJs( string $timelineId, QueryResult $result, array $parameters ): string {
		$preJson = ( new JsonBuilder() )->buildTimelineJson(
			( new ResultSimplifier() )->newSubjectCollection( $result )
		);

		$preJson['options'] = TimelineOptions::processedParamsToJson( $parameters );

		$json = json_encode( $preJson );

		return \Html::rawElement(
			'script',
			[
				'type' => 'text/javascript'
			],
			"if (!window.hasOwnProperty('modernTimeline')) {window.modernTimeline = {};}"
			. "\n window.modernTimeline.{$timelineId} = $json;"
		);
	}

}
