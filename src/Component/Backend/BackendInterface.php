<?php

namespace Dashifen\WPPB\Component\Backend;
use Dashifen\WPPB\Component\Backend\Activator\ActivatorInterface;
use Dashifen\WPPB\Component\Backend\Deactivator\DeactivatorInterface;
use Dashifen\WPPB\Component\Backend\Uninstaller\UninstallerInterface;

/**
 * Interface BackendInterface
 * @package Dashifen\WPPB\Component\Backend
 */
interface BackendInterface {
	/**
	 * @param ActivatorInterface $activator
	 *
	 * @return void
	 */
	public function activate(ActivatorInterface $activator): void;
	
	/**
	 * @param DeactivatorInterface $deactivator
	 *
	 * @return void
	 */
	public function deactivate(DeactivatorInterface $deactivator): void;
	
	/**
	 * @param UninstallerInterface $uninstaller
	 *
	 * @return void
	 */
	public function uninstall(UninstallerInterface $uninstaller): void;
}
