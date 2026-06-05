<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\DataItems\WikiPage;

/**
 * Data from a single subject (page or subobject)
 */
class Subject {

	private PropertyValueCollections $propertyValueCollections;

	/**
	 * @param WikiPage $wikiPage
	 * @param PropertyValueCollection[] $propertyValueCollections
	 */
	public function __construct(
		private WikiPage $wikiPage,
		array $propertyValueCollections
	) {
		$this->propertyValueCollections = new PropertyValueCollections( $propertyValueCollections );
	}

	public function getWikiPage(): WikiPage {
		return $this->wikiPage;
	}

	public function getPropertyValueCollections(): PropertyValueCollections {
		return $this->propertyValueCollections;
	}

}
