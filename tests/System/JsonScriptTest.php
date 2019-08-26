<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\System;

use SMW\Tests\Integration\JSONScript\JsonTestCaseScriptRunnerTest;

class JsonScriptTest extends JsonTestCaseScriptRunnerTest {

	public function setUp() {
		if ( version_compare( SMW_VERSION, '3.1c', '<' ) ) {
			$this->markTestSkipped( 'SMW version too old' );
		}

		parent::setUp();
	}

	protected function getTestCaseLocation() {
		return __DIR__ . '/JsonScript';
	}

}
