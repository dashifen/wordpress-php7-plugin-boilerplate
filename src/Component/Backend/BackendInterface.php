<?php

namespace Dashifen\WPPB\Component\Backend;

use Dashifen\WPPB\Component\ComponentInterface;

/**
 * Interface BackendInterface
 * @package Dashifen\WPPB\Component\Backend
 */
interface BackendInterface extends ComponentInterface {
	/**
	 * @return void
	 */
	public function activate(): void;
	
	/**
	 * @return void
	 */
	public function deactivate(): void;
	
	/**
	 * @return void
	 */
	public function uninstall(): void;
}
