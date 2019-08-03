<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Integration;

use ModernTimeline\TimelineOptions;
use ParamProcessor\ParamDefinitionFactory;
use ParamProcessor\ProcessingResult;
use ParamProcessor\Processor;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ModernTimeline\TimelineOptions
 */
class OptionsTest extends TestCase {

	private const DEFAULT_SCALE_FACTOR = 2;
	private const DEFAULT_START_SLIDE = 0;

	public function testDefaultOptions() {
		$this->assertSame(
			[
				'hash_bookmark' => false,
				'default_bg_color' => 'white',
				'scale_factor' => self::DEFAULT_SCALE_FACTOR,
				'timenav_position' => 'bottom',
				'optimal_tick_width' => 100,
				'start_at_slide' => self::DEFAULT_START_SLIDE,
				'start_at_end' => false,
				'duration' => 1000,
			],
			$this->processUserInputToTimelineOptions( [] )
		);
	}

	private function processUserInputToTimelineOptions( array $userInput ): array {
		return TimelineOptions::processedParamsToJson(
			$this->processUserInput( $userInput )->getParameters()
		);
	}

	private function processUserInput( array $userInput ): ProcessingResult {
		$processor = Processor::newDefault();

		$processor->setParameters( $userInput );
		$processor->setParameterDefinitions( $this->getParameterDefinitions() );

		return $processor->processParameters();
	}

	private function getParameterDefinitions(): array {
		return ParamDefinitionFactory::newDefault()->newDefinitionsFromArrays(
			TimelineOptions::getTimelineParameterDefinitions()
		);
	}

	public function testDefaultWidthAndHeight() {
		$parameters = $this->processUserInput( [] )->getParameterArray();

		$this->assertSame( $GLOBALS['wgModernTimelineWidth'], $parameters['width'] );
		$this->assertSame( $GLOBALS['wgModernTimelineHeight'], $parameters['height'] );
	}

	/**
	 * @dataProvider widthProvider
	 */
	public function testWidth( string $input, string $expected ) {
		$parameters = $this->processUserInput( [
			'width' => $input,
		] )->getParameterArray();

		$this->assertSame( $expected, $parameters['width'] );
	}

	public function widthProvider() {
		yield [ '10', '10px' ];
		yield [ '10px', '10px' ];
		yield [ '10%', '10%' ];
		yield [ '10em', '10em' ];
		yield [ '10ex', '10ex' ];
		yield [ 'auto', 'auto' ];
	}

	/**
	 * @dataProvider heightProvider
	 */
	public function testHeight( string $input, string $expected ) {
		$parameters = $this->processUserInput( [
			'height' => $input,
		] )->getParameterArray();

		$this->assertSame( $expected, $parameters['height'] );
	}

	public function heightProvider() {
		yield [ '10', '10px' ];
		yield [ '10px', '10px' ];
		yield [ '10em', '10em' ];
		yield [ '10ex', '10ex' ];
	}

	public function testTooLowScaleFactorDefaults() {
		$this->assertProcesses( 'scale factor', '0', self::DEFAULT_SCALE_FACTOR );
	}

	private function assertProcesses( string $paramName, string $input, $expected ) {
		$parameters = $this->processUserInput( [
			$paramName => $input,
		] )->getParameterArray();

		$this->assertSame( $expected, $parameters[$paramName] );
	}

	public function testTooLowStartSlideDefaults() {
		$this->assertProcesses( 'start slide', '0', 1 );
	}

	public function testStartSlideIsOneBased() {
		$this->assertSame(
			2,
			$this->processUserInputToTimelineOptions( [ 'start slide' => '3' ] )['start_at_slide']
		);
	}

	/**
	 * @dataProvider animationDurationAliasProvider
	 */
	public function testAnimationDurationAliases( string $alias ) {
		$parameters = $this->processUserInput( [
			$alias => '42',
		] )->getParameterArray();

		$this->assertSame( 42, $parameters['animation duration'] );
	}

	public function animationDurationAliasProvider() {
		yield 'automatic alias' => [ 'animationduration' ];
		yield 'manual alias' => [ 'duration' ];
	}

}
