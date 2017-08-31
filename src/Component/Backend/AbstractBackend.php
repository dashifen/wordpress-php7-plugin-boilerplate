<?php

namespace Dashifen\WPPB\Component\Backend;

use Dashifen\WPPB\Component\Backend\Activator\ActivatorInterface;
use Dashifen\WPPB\Component\Backend\Deactivator\DeactivatorInterface;
use Dashifen\WPPB\Component\Backend\Uninstaller\UninstallerInterface;
use Dashifen\WPPB\Component\Component;

/**
 * Class AbstractBackend
 * @package Dashifen\WPPB\Component\Backend
 */
abstract class AbstractBackend extends Component implements BackendInterface {
	public function activate(ActivatorInterface $activator): void {
		$activator->activate();
	}
	
	public function deactivate(DeactivatorInterface $deactivator): void {
		$deactivator->deactivate();
	}
	
	public function uninstall(UninstallerInterface $uninstaller): void {
		$uninstaller->uninstall();
	}
}
