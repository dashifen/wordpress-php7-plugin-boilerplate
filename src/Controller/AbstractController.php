<?php

namespace Dashifen\WPPB\Controller;

use Dashifen\WPPB\Component\Backend\BackendInterface;
use Dashifen\WPPB\Component\ComponentInterface;
use Dashifen\WPPB\Loader\LoaderInterface;

/**
 * Class Controller
 * @package Dashifen\WPPB\Controller
 */
abstract class AbstractController implements ControllerInterface {
	/**
	 * @var string $version
	 */
	protected $version;
	
	/**
	 * @var LoaderInterface $loader
	 */
	protected $loader;
	
	/**
	 * @var array $settings
	 */
	protected $settings = [];
	
	/**
	 * AbstractController constructor.
	 *
	 * @param string          $version
	 * @param LoaderInterface $loader
	 * @param bool            $initHooks
	 */
	public function __construct(string $version, LoaderInterface $loader, bool $initHooks = true) {
		$this->loader = $loader;
		$this->setPluginVersion($version);
		
		// most of the time, when we instantiate our Controller we do want
		// to initialize our hooks.  however, when this object is used within
		// our Activator and other similar objects, we do not.  our parameter
		// tells us what to do.
		
		if ($initHooks) {
			$this->defineActivationHooks();
			$this->defineFrontendHooks();
			$this->defineBackendHooks();
		}
	}
	
	/**
	 * @return string
	 */
	abstract public function getPluginName(): string;
	
	/**
	 * @return string
	 */
	public function getPluginSanitizedName(): string {
		return strtolower(preg_replace("/\W+/", "-", $this->getPluginName()));
	}
	
	/**
	 * Defines hooks using the Backend object for the activate,
	 * deactivate, and uninstall actions of this plugin.
	 *
	 * @return void
	 */
	protected function defineActivationHooks(): void {
		$backend = $this->getPluginBackend();
		$pluginName = $this->getPluginFilename();
		$handlers = ["activate", "deactivate", "uninstall"];
		foreach ($handlers as $handler) {
			
			// for each of our handlers, we hook an action handler to our
			// backend component.  the purpose of the BackendInterface is
			// to guarantee that we have three methods, one for each of
			// these hooks.
			
			$hook = $handler . "_" . $pluginName;
			$this->loader->addAction($hook, $backend, $handler);
		}
	}
	
	/**
	 * @return string
	 */
	abstract public function getPluginFilename(): string;
	
	/**
	 * @return string
	 */
	public function getPluginVersion(): string {
		return $this->version;
	}
	
	/**
	 * @param string $version
	 *
	 * @return void
	 */
	public function setPluginVersion(string $version): void {
		$this->version = $version;
	}
	
	/**
	 * @return void
	 */
	abstract protected function defineFrontendHooks(): void;
	
	/**
	 * @return void
	 */
	abstract protected function defineBackendHooks(): void;
	
	/**
	 * @return void
	 */
	public function attachHooks(): void {
		$this->loader->attach();
	}
	
	/**
	 * @return array
	 */
	public function getPluginSettings(): array {
		
		// this isn't a simple getter because we want it to more
		// intelligently produce our plugin settings.  if our settings
		// have been posted here, we use them.  otherwise, we attempt to
		// get them out of the database defaulting to an empty array if
		// they do not yet exist.  finally, we will ensure that the
		// default settings exist at a minimum before returning them to
		// the calling scope.
		
		$settingsSlug = $this->getPluginSettingsSlug();
		$settings = $_POST[$settingsSlug] ?? get_option($settingsSlug, []);
		$settings = wp_parse_args($settings, $this->getPluginDefaultSettings());
		return $settings;
	}
	
	/**
	 * @return string
	 */
	abstract public function getPluginSettingsSlug(): string;
	
	/**
	 * @return array
	 */
	abstract protected function getPluginDefaultSettings(): array;
	
	/**
	 * @return ComponentInterface
	 */
	abstract public function getPluginFrontend(): ComponentInterface;
	
	/**
	 * @return BackendInterface
	 */
	abstract public function getPluginBackend(): BackendInterface;
}
