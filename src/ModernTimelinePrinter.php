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
	private const PARAM_BOOKMARK = 'bookmark';
	private const PARAM_BACKGROUND = 'background';
	private const PARAM_SCALE_FACTOR = 'scale factor';
	private const PARAM_POSITION = 'position';
	private const PARAM_TICK_WIDTH = 'tick width';
	private const PARAM_START_SLIDE = 'start slide';
	private const PARAM_START_AT_END = 'start at end';

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
			'default' => $GLOBALS['wgModernTimelineWidth'],
		];

		$definitions[self::PARAM_HEIGHT] = [
			'type' => 'dimension',
			'units' => [ 'px', 'ex', 'em', '' ],
			'default' => $GLOBALS['wgModernTimelineHeight'],
		];

		$definitions[self::PARAM_BOOKMARK] = [
			'type' => 'boolean',
			'default' => $GLOBALS['wgModernTimelineBookmark'],
		];

		$definitions[self::PARAM_BACKGROUND] = [
			'type' => 'string',
			'default' => $GLOBALS['wgModernTimelineBackground'],
		];

		$definitions[self::PARAM_SCALE_FACTOR] = [
			'type' => 'integer',
			'default' => $GLOBALS['wgModernTimelineScaleFactor'],
		];

		$definitions[self::PARAM_POSITION] = [
			'type' => 'string',
			'default' => $GLOBALS['wgModernTimelinePosition'],
			'values' => [ 'top', 'bottom' ],
		];

		$definitions[self::PARAM_TICK_WIDTH] = [
			'type' => 'integer',
			'default' => $GLOBALS['wgModernTimelineTickWidth']
		];

		$definitions[self::PARAM_START_SLIDE] = [
			'type' => 'integer',
			'default' => $GLOBALS['wgModernTimelineStartSlide']
		];

		$definitions[self::PARAM_START_AT_END] = [
			'type' => 'boolean',
			'default' => $GLOBALS['wgModernTimelineStartAtEnd']
		];

		foreach ( $definitions as $name => $definition ) {
			$definitions[$name]['message'] = 'modern-timeline-param-' . str_replace( ' ', '-', $name );

			if ( strpos( $name, ' ' ) !== false ) {
				$definitions[$name]['aliases'] = [ str_replace( ' ', '', $name ) ];
			}
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
			$this->newOptionsFromParameters( $parameters ),
			new JsonBuilder()
		);

		SMWOutputs::requireScript(
			$timelineId,
			$presenter->createJs( $result )
		);

		return $this->createDiv(
			$timelineId,
			$parameters[self::PARAM_WIDTH]->getValue(),
			$parameters[self::PARAM_HEIGHT]->getValue()
		);
	}

	public function createDiv( int $timelineId, string $width, string $height ): string {
		return \Html::element(
			'div',
			[
				'id' => $timelineId,
				'style' => "width: $width; height: $height;"
			],
			'Loading' // TODO
		);
	}

	private function newTimelineId(): string {
		static $timelineNumber = 0;
		return 'modern_timeline' . ++$timelineNumber;
	}

	/**
	 * @param ProcessedParam[] $parameters
	 * @return TimelineOptions
	 */
	private function newOptionsFromParameters( array $parameters ): TimelineOptions {
		$options = new TimelineOptions();

		$options->bookmark = $parameters[self::PARAM_BOOKMARK]->getValue();
		$options->backgroundColor = $parameters[self::PARAM_BACKGROUND]->getValue();
		$options->scaleFactor = $parameters[self::PARAM_SCALE_FACTOR]->getValue();
		$options->position = $parameters[self::PARAM_POSITION]->getValue();
		$options->tickWidth = $parameters[self::PARAM_TICK_WIDTH]->getValue();
		$options->startSlide = $parameters[self::PARAM_START_SLIDE]->getValue();
		$options->startAtEnd = $parameters[self::PARAM_START_AT_END]->getValue();

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