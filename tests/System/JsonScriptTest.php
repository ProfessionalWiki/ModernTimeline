<?php

declare( strict_types = 1 );

namespace ModernTimeline\Tests\System;

use SMW\Tests\Integration\JSONScript\JsonTestCaseScriptRunnerTest;

class JsonScriptTest extends JsonTestCaseScriptRunnerTest {

	protected function getTestCaseLocation() {
		return __DIR__ . '/JsonScript';
	}

}
