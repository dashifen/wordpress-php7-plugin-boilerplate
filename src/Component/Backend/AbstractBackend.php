<?php

namespace Dashifen\WPPB\Component\Backend;

use Dashifen\WPPB\Component\AbstractComponent;
use Dashifen\WPPB\Component\Backend\Activator\ActivatorInterface;
use Dashifen\WPPB\Component\Backend\Deactivator\DeactivatorInterface;
use Dashifen\WPPB\Component\Backend\Uninstaller\UninstallerInterface;
use Dashifen\WPPB\Controller\ControllerInterface;

/**
 * Class AbstractBackend
 * @package Dashifen\WPPB\Component\Backend
 */
abstract class AbstractBackend extends AbstractComponent implements BackendInterface {
	/**
	 * @var ActivatorInterface $activator
	 */
	protected $activator;
	
	/**
	 * @var DeactivatorInterface $deactivator
	 */
	protected $deactivator;
	
	/**
	 * @var UninstallerInterface $uninstaller
	 */
	protected $uninstaller;
	
	public function __construct(
		ControllerInterface $controller,
		ActivatorInterface $activator,
		DeactivatorInterface $deactivator,
		UninstallerInterface $uninstaller
	) {
		parent::__construct($controller);
		
		// our parent can handle what needs to be done with the controller,
		// so we just make sure that we "remember" our state-changing objects.
		
		$this->activator = $activator;
		$this->deactivator = $deactivator;
		$this->uninstaller = $uninstaller;
	}
	
	public function activate(): void {
		$this->activator->activate();
	}
	
	public function deactivate(): void {
		$this->deactivator->deactivate();
	}
	
	public function uninstall(): void {
		$this->uninstaller->uninstall();
	}
}
