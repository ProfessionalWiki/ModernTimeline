<?php

declare( strict_types = 1 );

namespace ModernTimeline;

use SMW\Query\QueryResult;

class ResultPresenter {

	private $id = 'modern_timeline'; // TODO: make unique

	public function __construct(  ) {

	}

	public function present( QueryResult $results ): string {
		$resultText = '';

		while ( $object = $results->getNext() ) {
			foreach ( $object as $propertyValues ) {
				$resultText .= $propertyValues->getContent()[0]->getTitle()->getPrefixedText() . "<br>";
				break;
			}

		}

		return $this->createDiv() . $this->createJs();
	}

	private function createDiv(): string {
		return \Html::element(
			'div',
			[
				'id' => $this->id,
				'style' => 'width: 100%; height: 600px'
			],
			'Loading' // TODO
		);
	}

	private function createJs(): string {
		// https://timeline.knightlab.com/docs/json-format.html
		$timelineData = [
			'events' => [
				[
					'start_date' => [
						'year' => 2019
					]
				]
			]
		];

		$json = json_encode( $timelineData );

		return \Html::rawElement(
			'script',
			[
				'type' => 'text/javascript'
			],
			"window.modernTimeline = { {$this->id}: $json };"
		);
	}

}