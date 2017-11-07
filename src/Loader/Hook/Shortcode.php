<?php

namespace Dashifen\WPPB\Loader\Hook;

/**
 * Class Shortcode
 *
 * @package Dashifen\WPPB\Loader\Hook
 */
class Shortcode extends Hook {
	/**
	 * @return int
	 * @throws HookException
	 */
	public function getPriority(): int {
		throw new HookException("Shortcodes don't use priorities.",
			HookException::SHORTCODE_PRIORITY_CALL);
	}
	
	/**
	 * @return int
	 * @throws HookException
	 */
	public function getArgCount(): int {
		
		// shortcodes always have three parameters:  the shortcode's
		// attributes, the content between the shortcode tags, and the
		// name of the shortcode.  we may not need to use all three of
		// them, but we'll always pass them to the calling scope.
		
		return 3;
	}
}
