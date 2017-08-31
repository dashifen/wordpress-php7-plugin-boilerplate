<?php

namespace Dashifen\WPPB\Component\Backend\Deactivator;

/**
 * Interface DeactivatorInterface
 * @package Dashifen\WPPB\Component\Backend\Deactivator
 */
interface DeactivatorInterface {
	/**
	 * @return void
	 */
	public function deactivate(): void;
}
