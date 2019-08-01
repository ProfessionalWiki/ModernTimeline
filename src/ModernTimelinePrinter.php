<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ParamProcessor\ProcessedParam;
use SMW\Parser\RecursiveTextProcessor;
use SMW\Query\QueryResult;
use SMW\Query\ResultPrinter;
use SMWOutputs;
use SMWQuery;

class ModernTimelinePrinter implements ResultPrinter {

	private const PARAM_WIDTH = 'width';
	private const PARAM_HEIGHT = 'height';

	public function getName(): string {
		return wfMessage( 'modern-timeline-format-name' )->text();
	}

	public function getParamDefinitions( array $definitions ) {
		return array_merge( $definitions, $this->getTimelineParameterDefinitions() );
	}

	private function getTimelineParameterDefinitions(): array {
		$definitions = [];

		$definitions[self::PARAM_WIDTH] = [
			'type' => 'dimension',
			'allowauto' => true,
			'units' => [ 'px', 'ex', 'em', '%', '' ],
			'default' => '100%', // TODO: config
		];

		$definitions[self::PARAM_HEIGHT] = [
			'type' => 'dimension',
			'units' => [ 'px', 'ex', 'em', '' ],
			'default' => '250px', // TODO: config
		];

		foreach ( $definitions as $name => $definition ) {
			$definitions[$name]['message'] = 'modern-timeline-param-' . $name;
		}

		return $definitions;
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

		$presenter = new ResultPresenter(
			$timelineId,
			$this->newOptionsFromParameters( $parameters )
		);

		SMWOutputs::requireScript(
			$timelineId,
			$presenter->createJs( $result )
		);

		return $presenter->createDiv();
	}

	private function newTimelineId(): string {
		return 'modern_timeline'; // TODO: make unique
	}

	/**
	 * @param ProcessedParam[] $parameters
	 * @return TimelineOptions
	 */
	private function newOptionsFromParameters( array $parameters ): TimelineOptions {
		$options = new TimelineOptions();

		$options->width = $parameters[self::PARAM_WIDTH]->getValue();
		$options->height = $parameters[self::PARAM_HEIGHT]->getValue();

		return $options;
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