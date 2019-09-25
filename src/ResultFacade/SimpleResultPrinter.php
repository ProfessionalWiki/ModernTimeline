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

	/**
	 * @var PrinterInfo[]
	 */
	private $printerInfos;

	public function registerPrinter(): SimplePrinterRegistrator {
		return new SimplePrinterRegistrator( function( PrinterInfo $info ) {
			$this->printerInfos[] = $info;
		} );
	}

}

class SimplePrinterRegistrator {

	private $registry;

	private $nameMessageKey;
	private $parameterDefinitions;
	private $constructionFunction;

	public function __construct( callable $registry ) {
		$this->registry = $registry;
	}

	public function withMessageKey( string $nameMessageKey ): self {
		$this->nameMessageKey = $nameMessageKey;
		return $this;
	}

	public function andParameterDefinitions( array $parameterDefinitions ): self {
		$this->parameterDefinitions = $parameterDefinitions;
		return $this;
	}

	public function andConstructionFunction( callable $constructionFunction ): self {
		$this->constructionFunction = $constructionFunction;
		return $this;
	}

	public function register() {
		call_user_func( $this->registry, $this->newPrinterInfo() );
	}

	private function newPrinterInfo(): PrinterInfo {
		return new PrinterInfo(
			$this->nameMessageKey,
			$this->parameterDefinitions,
			$this->constructionFunction
		);
	}

}

class PrinterInfo {

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
