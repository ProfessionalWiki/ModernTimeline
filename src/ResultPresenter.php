<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use SMW\Query\QueryResult;

class ResultPresenter {

	private $id;
	private $options;

	public function __construct( string $id, TimelineOptions $options ) {
		$this->id = $id;
		$this->options = $options;
	}

	public function createDiv(): string {
		return \Html::element(
			'div',
			[
				'id' => $this->id,
				'style' => "width: {$this->options->width}; height: {$this->options->height};"
			],
			'Loading' // TODO
		);
	}

	public function createJs( QueryResult $results ): string {
		$json = json_encode( ( new JsonBuilder() )->buildTimelineJson( $results ) );

		return \Html::rawElement(
			'script',
			[
				'type' => 'text/javascript'
			],
			"if (!window.hasOwnProperty('modernTimeline')) {window.modernTimeline = {};}"
				. "\n window.modernTimeline.{$this->id} = $json;"
		);
	}

}
