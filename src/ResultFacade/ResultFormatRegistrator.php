<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

class ResultFormatRegistrator {

	/**
	 * @var callable
	 */
	private $registry;

	private string $name;
	private string $nameMessageKey;
	private array $parameterDefinitions;

	/**
	 * @var callable
	 */
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

	public function andPresenterBuilder( callable $constructionFunction ): self {
		$this->constructionFunction = $constructionFunction;
		return $this;
	}

	public function register(): void {
		call_user_func( $this->registry, $this->newResultFormat() );
	}

	private function newResultFormat(): ResultFormat {
		return new ResultFormat(
			$this->name,
			$this->nameMessageKey,
			$this->parameterDefinitions,
			$this->constructionFunction
		);
	}

}
