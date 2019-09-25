<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

interface SimpleResultPrinter {

	public function getNameMessageKey(): string;

	public function getParameterDefinitions(): array;

	// TODO: add parameter for non-global side effects
	public function getResult( SimpleQueryResult $result ): string;

}
