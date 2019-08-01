<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use SMW\Query\QueryResult;

class ResultPresenter {

	private $options;

	private $id = 'modern_timeline'; // TODO: make unique

	public function __construct( TimelineOptions $options ) {
		$this->options = $options;
	}

	public function present( QueryResult $results ): string {
		$resultText = '';



		return $this->createDiv() . $this->createJs( $results );
	}

	private function createDiv(): string {
		return \Html::element(
			'div',
			[
				'id' => $this->id,
				'style' => "width: {$this->options->width}; height: {$this->options->height};"
			],
			'Loading' // TODO
		);
	}

	private function createJs( QueryResult $results ): string {
		$json = json_encode( ( new JsonBuilder() )->buildTimelineJson( $results ) );

		return \Html::rawElement(
			'script',
			[
				'type' => 'text/javascript'
			],
			"window.modernTimeline = { {$this->id}: $json };"
		);
	}

}
