<?php

declare( strict_types = 1 );

namespace ModernTimeline\ResultFacade;

interface ResultPresenter {

	// TODO: add parameter for non-global side effects
	public function presentResult( SimpleQueryResult $result ): string;

}
