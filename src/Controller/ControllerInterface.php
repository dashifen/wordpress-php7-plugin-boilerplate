<?php

namespace Dashifen\WPPB\Controller;

interface ControllerInterface {
	/**
	 * @return string
	 */
	public function getPluginName(): string;
	
	/**
	 * @return string
	 */
	public function getPluginVersion(): string;
	
	/**
	 * @param string $version
	 *
	 * @return void
	 */
	public function setPluginVersion(string $version): void;
	
	/**
	 * @return array
	 */
	public function getPluginSettings(): array;
	
	/**
	 * @return void
	 */
	public function attachHooks(): void;
}
