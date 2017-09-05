<?php

namespace Dashifen\WPPB\Controller\InterfaceExtensions;

use Dashifen\WPPB\Controller\ControllerInterface;

/**
 * Interface PostTypeControllerInterface
 * @package Dashifen\WPPB\Controller\InterfaceExtensions
 */
interface PostTypeControllerInterface extends ControllerInterface {
	/**
	 * @return string
	 */
	public function getPluginPostType(): string;
	
	/**
	 * @return string
	 */
	public function getPluginPostTypeSlug(): string;
	
	/**
	 * @return void
	 */
	public function registerPostType(): void;
}
