<?php

namespace Dashifen\WPPB\Component\Backend\Activator;

use Dashifen\WPPB\Controller\ControllerInterface;

/**
 * Class AbstractActivator
 * @package Dashifen\WPPB\Component\Backend\Activator
 */
abstract class AbstractActivator implements ActivatorInterface {
	
	/**
	 * @var ControllerInterface $controller
	 */
	protected $controller;
	
	/**
	 * AbstractActivator constructor.
	 *
	 * @param ControllerInterface $controller
	 */
	public function __construct(ControllerInterface $controller) {
		$this->controller = $controller;
	}
	
	/**
	 * @return void
	 */
	abstract public function activate(): void;
}
