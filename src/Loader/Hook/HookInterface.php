<?php

namespace Dashifen\WPPB\Loader\Hook;

use Dashifen\WPPB\Component\ComponentInterface;

/**
 * Interface HookInterface
 *
 * @package Dashifen\WPPB\Loader\Hook
 */
interface HookInterface {
	/**
	 * @return string
	 */
	public function getHook(): string;
	
	/**
	 * @param string $hook
	 *
	 * @return void
	 */
	public function setHook(string $hook): void;
	
	/**
	 * @return ComponentInterface
	 */
	public function getComponent(): ComponentInterface;
	
	/**
	 * @param ComponentInterface $component
	 *
	 * @return void
	 */
	public function setComponent(ComponentInterface $component): void;
	
	/**
	 * @return string
	 */
	public function getHandler(): string;
	
	/**
	 * @param string $handler
	 *
	 * @return void
	 */
	public function setHandler(string $handler): void;
	
	/**
	 * @return int
	 */
	public function getPriority(): int;
	
	/**
	 * @param int $priority
	 *
	 * @return void
	 */
	public function setPriority(int $priority): void;
	
	/**
	 * @return int
	 */
	public function getArgCount(): int;
	
	/**
	 * @param int $argCount
	 *
	 * @return void
	 */
	public function setArgCount(int $argCount): void;
}
