<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\DIWikiPage;

/**
 * Data from a single subject (page or subobject)
 */
class Subject {

	private PropertyValueCollections $propertyValueCollections;

	/**
	 * @param DIWikiPage $wikiPage
	 * @param PropertyValueCollection[] $propertyValueCollections
	 */
	public function __construct(
		private DIWikiPage $wikiPage,
		array $propertyValueCollections
	) {
		$this->propertyValueCollections = new PropertyValueCollections( $propertyValueCollections );
	}

	public function getWikiPage(): DIWikiPage {
		return $this->wikiPage;
	}

	public function getPropertyValueCollections(): PropertyValueCollections {
		return $this->propertyValueCollections;
	}

}
