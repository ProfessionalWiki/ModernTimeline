<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use ModernTimeline\ResultFacade\ResultSimplifier;
use ModernTimeline\ResultFacade\ResultFormatRegistry;
use ModernTimeline\ResultFacade\SimpleQueryResult;
use ModernTimeline\ResultFacade\SubjectCollection;
use ParamProcessor\Param;
use ParamProcessor\ProcessedParam;
use ParamProcessor\ProcessingResult;
use SMW\Parser\RecursiveTextProcessor;
use SMW\Query\ResultPrinter;
use SMWQuery;
use SMWQueryResult;

class ModernTimelinePrinter implements ResultPrinter {

	private $simplePrinter;

	public function __construct() {
		$registry = new ResultFormatRegistry();

		$registry->newFormat()
			->withName( 'moderntimeline' )
			->andMessageKey( 'modern-timeline-format-name' )
			->andParameterDefinitions( TimelineOptions::getTimelineParameterDefinitions() )
			->andPrinterBuilder( function() {
				return new TimelinePresenter();
			} )
			->register();

		$this->simplePrinter = $registry->getFormatByName( 'moderntimeline' )->buildPrinter();
	}

	public function getName(): string {
		return wfMessage( $this->simplePrinter->getNameMessageKey() )->text();
	}

	public function getParamDefinitions( array $definitions ) {
		return array_merge( $definitions, $this->simplePrinter->getParameterDefinitions() );
	}

	/**
	 * @param SMWQueryResult $result
	 * @param Param[] $parameters
	 * @param int $outputMode
	 *
	 * @return string
	 */
	public function getResult( SMWQueryResult $result, array $parameters, $outputMode ): string {
		return $this->simplePrinter->getResult(
			new SimpleQueryResult(
				$this->simplifyResult( $result ),
				$this->newProcessingResultFromParams( $parameters )
			)
		);
	}

	private function simplifyResult( SMWQueryResult $result ): SubjectCollection {
		return ( new ResultSimplifier() )->newSubjectCollection( $result );
	}

	/**
	 * This is code copied over from ParamProcessor to go from the deprecated Param[] to ProcessingResult.
	 * Once the main ResultPrinter interface has been migrated away from Param this can be removed.
	 */
	private function newProcessingResultFromParams( array $params ): ProcessingResult {
		$parameters = [];

		foreach ( $params as $param ) {
			$processedParam = new ProcessedParam(
				$param->getName(),
				$param->getValue(),
				$param->wasSetToDefault()
			);

			if ( !$param->wasSetToDefault() ) {
				$processedParam->setOriginalName( $param->getOriginalName() );
				$processedParam->setOriginalValue( $param->getOriginalValue() );
			}

			$parameters[$processedParam->getName()] = $processedParam;
		}

		return new ProcessingResult(
			$parameters,
			[]
		);
	}

	public function getQueryMode( $context ): int {
		return SMWQuery::MODE_INSTANCES;
	}

	public function setShowErrors( $show ) {
	}

	public function isExportFormat(): bool {
		return false;
	}

	public function getDefaultSort(): string {
		return 'ASC';
	}

	public function isDeferrable(): bool {
		return false;
	}

	public function supportsRecursiveAnnotation(): bool {
		return false;
	}

	public function setRecursiveTextProcessor( RecursiveTextProcessor $recursiveTextProcessor ) {
	}
}
