<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\System;

use SMW\Tests\Integration\JSONScript\JSONScriptTestCaseRunnerTest;

/**
 * @group Database
 */
class JsonScriptTest extends JSONScriptTestCaseRunnerTest {

	public function setUp(): void {
		if ( substr( SMW_VERSION, 0, 3 ) === '3.0' ) {
			$this->markTestSkipped( 'SMW version too old' );
		}

		parent::setUp();
	}

	protected function getTestCaseLocation() {
		return __DIR__ . '/JsonScript';
	}

}
