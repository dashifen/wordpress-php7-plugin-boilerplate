<?php

namespace Dashifen\WPPB\Component\Backend\Uninstaller;

/**
 * Interface UninstallerInterface
 * @package Dashifen\WPPB\Component\Backend\Uninstaller
 */
interface UninstallerInterface {
	/**
	 * @return void;
	 */
	public function uninstall(): void;
}
