<?php

namespace Dashifen\WPPB\Component\Backend\Uninstaller;

use Dashifen\WPPB\Controller\ControllerInterface;

abstract class AbstractUninstaller implements UninstallerInterface {
	/**
	 * @var ControllerInterface
	 */
	protected $controller;
	
	/**
	 * AbstractUninstaller constructor.
	 *
	 * @param ControllerInterface $controller
	 */
	public function __construct(ControllerInterface $controller) {
		$this->controller = $controller;
	}
	
	/**
	 * @return void
	 */
	abstract public function uninstall(): void;
}
