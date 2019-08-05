<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ParamProcessor\ParameterTypes;
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
	private const PARAM_TRANSITION_DURATION = 'transition duration';
	private const PARAM_NAV_HEIGHT = 'navigation height';
	private const PARAM_TEMPLATE = 'template';

	public static function getTimelineParameterDefinitions(): array {
		$definitions = [];

		$definitions[self::PARAM_WIDTH] = [
			'type' => ParameterTypes::DIMENSION,
			'allowauto' => true,
			'units' => [ 'px', 'ex', 'em', '%', '' ],
			'default' => $GLOBALS['wgModernTimelineWidth'],
		];

		$definitions[self::PARAM_HEIGHT] = [
			'type' => ParameterTypes::DIMENSION,
			'units' => [ 'px', 'ex', 'em', '' ],
			'default' => $GLOBALS['wgModernTimelineHeight'],
		];

		$definitions[self::PARAM_BOOKMARK] = [
			'type' => ParameterTypes::BOOLEAN,
			'default' => $GLOBALS['wgModernTimelineBookmark'],
		];

		$definitions[self::PARAM_BACKGROUND] = [
			'type' => ParameterTypes::STRING,
			'default' => $GLOBALS['wgModernTimelineBackground'],
		];

		$definitions[self::PARAM_SCALE_FACTOR] = [
			'type' => ParameterTypes::INTEGER,
			'default' => $GLOBALS['wgModernTimelineScaleFactor'],
			'lowerbound' => 1
		];

		$definitions[self::PARAM_POSITION] = [
			'type' => ParameterTypes::STRING,
			'default' => $GLOBALS['wgModernTimelinePosition'],
			'values' => [ 'top', 'bottom' ],
		];

		$definitions[self::PARAM_TICK_WIDTH] = [
			'type' => ParameterTypes::INTEGER,
			'default' => $GLOBALS['wgModernTimelineTickWidth']
		];

		$definitions[self::PARAM_START_SLIDE] = [
			'type' => ParameterTypes::INTEGER,
			'default' => $GLOBALS['wgModernTimelineStartSlide'],
			'lowerbound' => 1
		];

		$definitions[self::PARAM_START_AT_END] = [
			'type' => ParameterTypes::BOOLEAN,
			'default' => $GLOBALS['wgModernTimelineStartAtEnd']
		];

		$definitions[self::PARAM_TRANSITION_DURATION] = [
			'type' => ParameterTypes::INTEGER,
			'aliases' => 'duration',
			'default' => $GLOBALS['wgModernTimelineTransitionDuration'],
			'lowerbound' => 1
		];

		$definitions[self::PARAM_NAV_HEIGHT] = [
			'type' => ParameterTypes::DIMENSION,
			'units' => [ 'px', '%' ],
			'default' => $GLOBALS['wgModernTimelineNavHeight'],
		];

		$definitions[self::PARAM_TEMPLATE] = [
			'type' => ParameterTypes::STRING,
			'default' => $GLOBALS['wgModernTimelineTemplate']
		];

		foreach ( $definitions as $name => $definition ) {
			$definitions[$name]['message'] = 'modern-timeline-param-' . str_replace( ' ', '-', $name );

			if ( strpos( $name, ' ' ) !== false ) {
				$definitions[$name]['aliases'] = array_merge(
					array_key_exists( 'aliases', $definitions[$name] ) ? (array)$definitions[$name]['aliases'] : [],
					[ str_replace( ' ', '', $name ) ]
				);
			}
		}

		return $definitions;
	}

	/**
	 * @param ProcessedParam[] $parameters
	 * @return array
	 */
	public static function processedParamsToJson( array $parameters ): array {
		$json = [
			'hash_bookmark' => $parameters[self::PARAM_BOOKMARK]->getValue(),
			'default_bg_color' => $parameters[self::PARAM_BACKGROUND]->getValue(),
			'scale_factor' => $parameters[self::PARAM_SCALE_FACTOR]->getValue(),
			'timenav_position' => $parameters[self::PARAM_POSITION]->getValue(),
			'optimal_tick_width' => $parameters[self::PARAM_TICK_WIDTH]->getValue(),
			'start_at_slide' => self::getStartAtSlide( $parameters ),
			'start_at_end' => $parameters[self::PARAM_START_AT_END]->getValue(),
			'duration' => $parameters[self::PARAM_TRANSITION_DURATION]->getValue(),
			'base_class' => "modern_timeline",
		];

		$height = $parameters[self::PARAM_NAV_HEIGHT]->getValue();

		if ( strpos( $height, '%' ) === false ) {
			$json['timenav_height'] = (int)substr( $height, 0, -2 );
		}
		else {
			$json['timenav_height_percentage'] = (int)substr( $height, 0, -1 );
		}

		return $json;
	}

	private static function getStartAtSlide( array $parameters ): int {
		return $parameters[self::PARAM_START_SLIDE]->getValue() - 1;
	}

}