<?php

namespace Dashifen\WPPB\Component\Backend\Deactivator;

use Dashifen\WPPB\Controller\ControllerInterface;

/**
 * Class AbstractDeactivator
 * @package Dashifen\WPPB\Component\Backend\Deactivator
 */
abstract class AbstractDeactivator implements DeactivatorInterface {
	
	/**
	 * @var ControllerInterface $controller
	 */
	protected $controller;
	
	/**
	 * AbstractDeactivator constructor.
	 *
	 * @param ControllerInterface $controller
	 */
	public function __construct(ControllerInterface $controller) {
		$this->controller = $controller;
	}
	
	/**
	 * @return void
	 */
	abstract public function deactivate(): void;
}
