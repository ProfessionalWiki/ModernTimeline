<?php

namespace ModernTimeline;

use ParamProcessor\ProcessedParam;

class TimelineOptions {

	public const PARAM_WIDTH = 'width';
	public const PARAM_HEIGHT = 'height';
	private const PARAM_BOOKMARK = 'bookmark';
	private const PARAM_BACKGROUND = 'background';
	private const PARAM_SCALE_FACTOR = 'scale factor';
	private const PARAM_POSITION = 'position';
	private const PARAM_TICK_WIDTH = 'tick width';
	private const PARAM_START_SLIDE = 'start slide';
	private const PARAM_START_AT_END = 'start at end';

	public static function getTimelineParameterDefinitions(): array {
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
	 * @param ProcessedParam[] $parameters
	 * @return array
	 */
	public static function processedParamsToJson( array $parameters ): array {
		return [
			'hash_bookmark' => $parameters[self::PARAM_BOOKMARK]->getValue(),
			'default_bg_color' => $parameters[self::PARAM_BACKGROUND]->getValue(),
			'scale_factor' => $parameters[self::PARAM_SCALE_FACTOR]->getValue(),
			'timenav_position' => $parameters[self::PARAM_POSITION]->getValue(),
			'optimal_tick_width' => $parameters[self::PARAM_TICK_WIDTH]->getValue(),
			'start_at_slide' => $parameters[self::PARAM_START_SLIDE]->getValue(),
			'start_at_end' => $parameters[self::PARAM_START_AT_END]->getValue(),
		];
	}

}