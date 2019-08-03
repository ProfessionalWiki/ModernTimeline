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

	public function testFoo() {
		$this->assertEquals(
			[
				'hash_bookmark' => false,
				'default_bg_color' => 'white',
				'scale_factor' => 2,
				'timenav_position' => 'bottom',
				'optimal_tick_width' => 100,
				'start_at_slide' => 0,
				'start_at_end' => false,
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

		$this->assertSame( '100%', $parameters['width'] );
		$this->assertSame( '300px', $parameters['height'] );
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

}
