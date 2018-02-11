<?php

namespace Dashifen\WPPB\Controller;

use Dashifen\WPPB\Component\Backend\BackendInterface;
use Dashifen\WPPB\Component\ComponentInterface;
use Dashifen\WPPB\Loader\LoaderInterface;

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
	 * @return LoaderInterface
	 */
	public function getLoader(): LoaderInterface;
	
	/**
	 * @return array
	 */
	public function getSettings(): array;
	
	/**
	 * @param string $setting
	 *
	 * @return mixed
	 * @throws ControllerException
	 */
	public function getSetting(string $setting);
	
	/**
	 * @return string
	 */
	public function getSettingsSlug(): string;
	
	/**
	 * @return BackendInterface|null
	 */
	public function getBackend(): ?BackendInterface;
	
	/**
	 * @return ComponentInterface|null
	 */
	public function getFrontend(): ?ComponentInterface;
	
	/**
	 * @return void
	 */
	public function attachHooks(): void;
}
