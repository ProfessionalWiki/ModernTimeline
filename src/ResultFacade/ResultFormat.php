<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

class ResultFormat {

	/**
	 * @var callable
	 */
	private $constructionFunction;

	public function __construct(
		private string $name,
		private string $nameMessageKey,
		private array $parameterDefinitions,
		callable $presenterBuilder
	) {
		$this->constructionFunction = $presenterBuilder;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getNameMessageKey(): string {
		return $this->nameMessageKey;
	}

	public function getParameterDefinitions(): array {
		return $this->parameterDefinitions;
	}

	public function buildPresenter(): ResultPresenter {
		return call_user_func( $this->constructionFunction );
	}

}
