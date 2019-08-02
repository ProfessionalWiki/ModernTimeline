<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
use ParamProcessor\ProcessedParam;
use SMW\Parser\RecursiveTextProcessor;
use SMW\Query\QueryResult;
use SMW\Query\ResultPrinter;
use SMWOutputs;
use SMWQuery;

class ModernTimelinePrinter implements ResultPrinter {

	public function getName(): string {
		return wfMessage( 'modern-timeline-format-name' )->text();
	}

	public function getParamDefinitions( array $definitions ) {
		return array_merge( $definitions, TimelineOptions::getTimelineParameterDefinitions() );
	}

	/**
	 * @param QueryResult $result
	 * @param ProcessedParam[] $parameters Note: currently getting Param[] from SMW but lets pretend the legacy refactor happened already
	 * @param int $outputMode
	 *
	 * @return string
	 */
	public function getResult( QueryResult $result, array $parameters, $outputMode ): string {
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

	public function createDiv( string $timelineId, string $width, string $height ): string {
		return \Html::element(
			'div',
			[
				'id' => $timelineId,
				'style' => "width: $width; height: $height;"
			],
			'Loading' // TODO
		);
	}

	public function createJs( string $timelineId, QueryResult $result, array $parameters ): string {
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

	public function getQueryMode( $context ): int {
		return SMWQuery::MODE_INSTANCES;
	}

	public function setShowErrors( $show ) {
	}

	public function isExportFormat(): bool {
		return false;
	}

	public function getDefaultSort(): string {
		return 'ASC';
	}

	public function isDeferrable(): bool {
		return false;
	}

	public function supportsRecursiveAnnotation(): bool {
		return false;
	}

	public function setRecursiveTextProcessor( RecursiveTextProcessor $recursiveTextProcessor ) {
	}
}