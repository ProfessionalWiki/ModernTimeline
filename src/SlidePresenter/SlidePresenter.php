<?php

declare( strict_types = 1 );

namespace ModernTimeline\SlidePresenter;

use ModernTimeline\ResultFacade\Subject;

interface SlidePresenter {

	public function getText( Subject $subject ): string;

}
