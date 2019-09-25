<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

interface SimpleResultPrinter {

	public function getNameMessageKey(): string;

	public function getParameterDefinitions(): array;

	// TODO: add parameter for non-global side effects
	public function getResult( SimpleQueryResult $result ): string;

}



class SimplePrinterRegistry {

	public function register( string $nameMessageKey, array $parameterDefinitions, callable $constructionFunction ) {

	}

}

class SimplePrinterInfo {

	private $nameMessageKey;
	private $parameterDefinitions;
	private $constructionFunction;

	public function __construct( string $nameMessageKey, array $parameterDefinitions, callable $constructionFunction ) {
		$this->nameMessageKey = $nameMessageKey;
		$this->parameterDefinitions = $parameterDefinitions;
		$this->constructionFunction = $constructionFunction;
	}

	public function getNameMessageKey(): string {
		return $this->nameMessageKey;
	}

	public function getParameterDefinitions(): array {
		return $this->parameterDefinitions;
	}

	public function buildPrinter(): SimpleResultPrinter {
		return call_user_func( $this->constructionFunction );
	}

}
