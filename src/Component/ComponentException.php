<?php

namespace Dashifen\WPPB\Component;

use Dashifen\Exception\Exception;

/**
 * Class ComponentException
 * @package Dashifen\WPPB\Component
 */
class ComponentException extends Exception {
	public const UNKNOWN_HANDLER = 1;
	public const DUPLICATED_HANDLER = 2;
	public const UNATTACHED_HANDLER = 3;
	public const ARGUMENT_COUNT_MISMATCH = 4;
}
