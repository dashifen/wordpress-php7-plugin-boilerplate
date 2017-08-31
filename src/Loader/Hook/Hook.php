<?php

namespace Dashifen\WPPB\Loader\Hook;

use Dashifen\WPPB\Component\ComponentInterface;

/**
 * Class Hook
 *
 * @package Dashifen\ProtectedPages\Includes
 */
class Hook implements HookInterface {
	/**
	 * @var string $hook
	 */
	protected $hook;
	
	/**
	 * @var ComponentInterface $component
	 */
	protected $component;
	
	/**
	 * @var string $handler
	 */
	protected $handler;
	
	/**
	 * @var int $priority
	 */
	protected $priority;
	
	/**
	 * @var int $argCount
	 */
	protected $argCount;
	
	/**
	 * ProtectedPagesAction constructor.
	 *
	 * @param string             $hook
	 * @param ComponentInterface $component
	 * @param string             $handler
	 * @param int                $priority
	 * @param int                $argCount
	 *
	 * @throws HookException
	 */
	public function __construct(string $hook, ComponentInterface $component, string $handler, int $priority = 10, int $argCount = 1) {
		if (!$component->hasHookHandler($handler)) {
			throw new HookException("Unknown handler: $handler", HookException::UNKNOWN_HANDLER);
		}
		
		$this->setHook($hook);
		$this->setComponent($component);
		$this->setHandler($handler);
		$this->setPriority($priority);
		$this->setArgCount($argCount);
	}
	
	/**
	 * @return string
	 */
	public function getHook(): string {
		return $this->hook;
	}
	
	/**
	 * @param string $hook
	 */
	public function setHook(string $hook): void {
		$this->hook = $hook;
	}
	
	/**
	 * @return ComponentInterface
	 */
	public function getComponent(): ComponentInterface {
		return $this->component;
	}
	
	/**
	 * @param ComponentInterface $component
	 */
	public function setComponent(ComponentInterface $component): void {
		$this->component = $component;
	}
	
	/**
	 * @return string
	 */
	public function getHandler(): string {
		return $this->handler;
	}
	
	/**
	 * @param string $handler
	 */
	public function setHandler(string $handler): void {
		$this->handler = $handler;
	}
	
	/**
	 * @return int
	 */
	public function getPriority(): int {
		return $this->priority;
	}
	
	/**
	 * @param int $priority
	 */
	public function setPriority(int $priority): void {
		$this->priority = $priority;
	}
	
	/**
	 * @return int
	 */
	public function getArgCount(): int {
		return $this->argCount;
	}
	
	/**
	 * @param int $argCount
	 */
	public function setArgCount(int $argCount): void {
		$this->argCount = $argCount;
	}
}
