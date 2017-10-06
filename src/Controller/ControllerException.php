<?php

namespace Dashifen\WPPB\Controller;

use Dashifen\Exception\Exception;

/**
 * Class ControllerException
 * @package Dashifen\WPPB\Controller
 */
class ControllerException extends Exception {
	public const UNKNOWN_ROLE = 1;
	public const UNKNOWN_STATUS = 2;
	public const MISSING_METHOD = 3;
	public const UNKNOWN_SETTING = 4;
}
