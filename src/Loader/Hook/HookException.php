<?php

namespace Dashifen\WPPB\Loader\Hook;

use Dashifen\Exception\Exception;

class HookException extends Exception {
	public const UNKNOWN_HANDLER = 1;
	public const SHORTCODE_PRIORITY_CALL = 2;
	public const SHORTCODE_ARGCOUNT_CALL = 3;
}
