<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use Traversable;

class PropertyValueCollections implements \IteratorAggregate {

	/**
	 * @param PropertyValueCollection[] $propertyValueCollections
	 */
	public function __construct(
		private array $propertyValueCollections
	) {
	}

	/**
	 * @return PropertyValueCollection[]
	 */
	public function toArray(): array {
		return $this->propertyValueCollections;
	}

	public function getIterator(): Traversable {
		return new \ArrayIterator( $this->propertyValueCollections );
	}

}
