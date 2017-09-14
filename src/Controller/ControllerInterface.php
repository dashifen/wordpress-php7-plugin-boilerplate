<?php

namespace Dashifen\WPPB\Controller;

use Dashifen\WPPB\Component\Backend\BackendInterface;
use Dashifen\WPPB\Component\ComponentInterface;

interface ControllerInterface {
	/**
	 * @return string
	 */
	public function getName(): string;
	
	/**
	 * @return string
	 */
	public function getSanitizedName(): string;
	
	/**
	 * @return string
	 */
	public function getFilename(): string;
	
	/**
	 * @return string
	 */
	public function getVersion(): string;
	
	/**
	 * @param string $version
	 *
	 * @return void
	 */
	public function setVersion(string $version): void;
	
	/**
	 * @return array
	 */
	public function getSettings(): array;
	
	/**
	 * @return string
	 */
	public function getSettingsSlug(): string;
	
	/**
	 * @return BackendInterface
	 */
	public function getBackend(): BackendInterface;
	
	/**
	 * @return ComponentInterface
	 */
	public function getFrontend(): ComponentInterface;
	
	/**
	 * @return void
	 */
	public function attachHooks(): void;
}
