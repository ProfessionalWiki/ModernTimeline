<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
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
		$preJson = $this->jsonBuilder->buildTimelineJson(
			( new ResultSimplifier() )->newSubjectCollection( $result )
		);

		$preJson['options'] = [
			'hash_bookmark' => $this->options->bookmark,
			'default_bg_color' => $this->options->backgroundColor,
			'scale_factor' => $this->options->scaleFactor,
			'timenav_position' => $this->options->position,
			'optimal_tick_width' => $this->options->tickWidth,
			'start_at_slide' => $this->options->startSlide,
			'start_at_end' => $this->options->startAtEnd,
		];

		$json = json_encode( $preJson );

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
