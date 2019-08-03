<?php

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
use ParamProcessor\ProcessedParam;
use SMWOutputs;
use SMWQueryResult;

class TimelinePresenter {

	private $id;
	private $parameters;

	/**
	 * @param ProcessedParam[] $parameters
	 */
	public function __construct( array $parameters ) {
		$this->parameters = $parameters;
		$this->id = $this->newTimelineId();
	}

	private function newTimelineId(): string {
		static $timelineNumber = 0;
		return 'modern_timeline' . ++$timelineNumber;
	}

	public function getResult( SMWQueryResult $result ): string {
		SMWOutputs::requireResource( 'ext.modern.timeline' );

		$json = $this->createJsonString( $result );

		SMWOutputs::requireScript(
			$this->id,
			$this->createJs( $json )
		);

		return $this->createDiv( $json );
	}

	private function createJsonString( SMWQueryResult $result ) {
		$preJson = ( new JsonBuilder() )->buildTimelineJson(
			( new ResultSimplifier() )->newSubjectCollection( $result )
		);

		$preJson['options'] = TimelineOptions::processedParamsToJson( $this->parameters );

		return json_encode( $preJson );
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

	private function createDiv( string $json ): string {
		$width = $this->parameters[TimelineOptions::PARAM_WIDTH]->getValue();
		$height = $this->parameters[TimelineOptions::PARAM_HEIGHT]->getValue();

		return \Html::element(
			'div',
			[
				'id' => $this->id,
				'style' => "width: $width; height: $height;"
			],
			'Loading' // TODO: add message or remove
		)
			. \Html::element( // TODO: remove when system tests can test head items
				'div',
				[ 'style' => 'display:none' ],
				$json
			);
	}

}
