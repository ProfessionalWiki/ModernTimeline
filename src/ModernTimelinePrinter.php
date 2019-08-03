<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ParamProcessor\ProcessedParam;
use SMW\Parser\RecursiveTextProcessor;
use SMW\Query\ResultPrinter;
use SMWQuery;
use SMWQueryResult;

class ModernTimelinePrinter implements ResultPrinter {

	public function getName(): string {
		return wfMessage( 'modern-timeline-format-name' )->text();
	}

	public function getParamDefinitions( array $definitions ) {
		return array_merge( $definitions, TimelineOptions::getTimelineParameterDefinitions() );
	}

	/**
	 * @param SMWQueryResult $result
	 * @param ProcessedParam[] $parameters Note: currently getting Param[] from SMW but lets pretend the legacy refactor happened already
	 * @param int $outputMode
	 *
	 * @return string
	 */
	public function getResult( SMWQueryResult $result, array $parameters, $outputMode ): string {
		return ( new TimelinePresenter( $parameters ) )->getResult( $result );
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