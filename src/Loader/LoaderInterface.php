<?php

namespace Dashifen\WPPB\Loader;

use Dashifen\WPPB\Component\ComponentInterface;

/**
 * Interface LoaderInterface
 *
 * @package Dashifen\WPPB\Loader
 */
interface LoaderInterface {
	/**
	 * @param string             $hook
	 * @param ComponentInterface $component
	 * @param string             $handler
	 * @param int                $priority
	 * @param int                $argCount
	 *
	 * @return void
	 */
	public function addAction(string $hook, ComponentInterface $component, string $handler, int $priority = 10, int $argCount = 1): void;
	
	/**
	 * @param string             $hook
	 * @param ComponentInterface $component
	 * @param string             $handler
	 * @param int                $priority
	 * @param int                $argCount
	 *
	 * @return void
	 */
	public function addFilter(string $hook, ComponentInterface $component, string $handler, int $priority = 10, int $argCount = 1): void;
	
	/**
	 * @param string             $shortcode
	 * @param ComponentInterface $component
	 * @param string             $handler
	 *
	 * @return void
	 */
	public function addShortcode(string $shortcode, ComponentInterface $component, string $handler): void;
	
	/**
	 * @return void
	 * @throws LoaderException
	 */
	public function attach(): void;
}
