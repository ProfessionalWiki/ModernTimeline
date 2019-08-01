<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\JsonBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ModernTimeline\JsonBuilder
 */
class JsonBuilderTest extends TestCase {

	public function testFoo() {
		$this->assertTrue( class_exists( JsonBuilder::class ) );
	}

}
