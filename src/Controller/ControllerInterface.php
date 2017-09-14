<?php

namespace Dashifen\WPPB\Controller;

use Dashifen\WPPB\Component\Backend\BackendInterface;
use Dashifen\WPPB\Component\ComponentInterface;

interface ControllerInterface {
	/**
	 * @return string
	 */
	public function getPluginName(): string;
	
	/**
	 * @return string
	 */
	public function getPluginSanitizedName(): string;
	
	/**
	 * @return string
	 */
	public function getPluginFilename(): string;
	
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
	 * @return string
	 */
	public function getPluginSettingsSlug(): string;
	
	/**
	 * @return BackendInterface
	 */
	public function getPluginBackend(): BackendInterface;
	
	/**
	 * @return ComponentInterface
	 */
	public function getPluginFrontend(): ComponentInterface;
	
	/**
	 * @return void
	 */
	public function attachHooks(): void;
}
