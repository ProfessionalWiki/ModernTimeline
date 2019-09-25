<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

class ResultFormatRegistrator {

	private $registry;

	private $name;
	private $nameMessageKey;
	private $parameterDefinitions;
	private $constructionFunction;

	public function __construct( callable $registry ) {
		$this->registry = $registry;
	}

	public function withName( string $name ): self {
		$this->name = $name;
		return $this;
	}

	public function andMessageKey( string $nameMessageKey ): self {
		$this->nameMessageKey = $nameMessageKey;
		return $this;
	}

	public function andParameterDefinitions( array $parameterDefinitions ): self {
		$this->parameterDefinitions = $parameterDefinitions;
		return $this;
	}

	public function andPrinterBuilder( callable $constructionFunction ): self {
		$this->constructionFunction = $constructionFunction;
		return $this;
	}

	public function register() {
		call_user_func( $this->registry, $this->newPrinterInfo() );
	}

	private function newPrinterInfo(): ResultFormat {
		return new ResultFormat(
			$this->name,
			$this->nameMessageKey,
			$this->parameterDefinitions,
			$this->constructionFunction
		);
	}

}
