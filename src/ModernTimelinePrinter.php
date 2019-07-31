<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ParamProcessor\ProcessedParam;
use SMW\Parser\RecursiveTextProcessor;
use SMW\Query\QueryResult;
use SMW\Query\ResultPrinter;
use SMWQuery;

class ModernTimelinePrinter implements ResultPrinter {

	public function getName(): string {
		return wfMessage( 'modern-timeline-format-name' )->text();
	}

	public function getParamDefinitions( array $definitions ) {
		return $definitions;
	}

	/**
	 * @param QueryResult $results
	 * @param ProcessedParam[] $parameters Note: currently getting Param[] from SMW but lets pretend the legacy refactor happened already
	 * @param int $outputMode
	 *
	 * @return string
	 */
	public function getResult( QueryResult $results, array $parameters, $outputMode ): string {
		$presenter = new ResultPresenter();

		return $presenter->present( $results );
	}

	public function getQueryMode( $context ): int {
		return SMWQuery::MODE_INSTANCES;
	}

	public function setShowErrors( $show ) {
	}

	public function isExportFormat(): bool {
		return false;
	}

	public function getDefaultSort() {
		return 'ASC';
	}

	public function supportsRecursiveAnnotation(): bool {
		return false;
	}

	public function setRecursiveTextProcessor( RecursiveTextProcessor $recursiveTextProcessor ) {
	}
}