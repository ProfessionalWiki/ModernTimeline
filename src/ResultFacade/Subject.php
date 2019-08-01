<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

use SMW\DIWikiPage;

/**
 * Data from a single subject (page or subobject)
 */
class Subject {

	private $wikiPage;
	private $propertyValueCollections;

	/**
	 * @param DIWikiPage $wikiPage
	 * @param PropertyValueCollection[] $propertyValueCollections
	 */
	public function __construct( DIWikiPage $wikiPage, array $propertyValueCollections ) {
		$this->wikiPage = $wikiPage;
		$this->propertyValueCollections = $propertyValueCollections;
	}

	public function getWikiPage(): DIWikiPage {
		return $this->wikiPage;
	}

	/**
	 * @return PropertyValueCollection[]
	 */
	public function getPropertyValueCollections(): array {
		return $this->propertyValueCollections;
	}



}