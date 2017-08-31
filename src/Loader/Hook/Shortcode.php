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
		throw new HookException("Shortcodes don't use argument counts.",
			HookException::SHORTCODE_ARGCOUNT_CALL);
	}
}
