<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
use ModernTimeline\ResultFacade\Subject;
use ModernTimeline\ResultFacade\SubjectCollection;
use SMW\Query\QueryResult;

/**
 * Creates the HTML and JS for the timeline.
 * Purposefully decoupled from the ResultPrinter interface and the global state in the implementation.
 */
class ResultPresenter {

	private $id;
	private $options;
	private $jsonBuilder;

	public function __construct( string $id, TimelineOptions $options, JsonBuilder $jsonBuilder ) {
		$this->id = $id;
		$this->options = $options;
		$this->jsonBuilder = $jsonBuilder;
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

	public function createJs( QueryResult $result ): string {
		$json = json_encode( $this->jsonBuilder->buildTimelineJson(
			( new ResultSimplifier() )->newSubjectCollection( $result )
		) );

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
