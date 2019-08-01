<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\Unit;

use ModernTimeline\JsonBuilder;
use PHPUnit\Framework\TestCase;

class DummyTest extends TestCase {

	public function testFoo() {
		$this->assertTrue( class_exists( JsonBuilder::class ) );
	}

}
