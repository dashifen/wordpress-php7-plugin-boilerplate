<?php

namespace Dashifen\WPPB\Loader;

use Dashifen\WPPB\Component\ComponentInterface;
use Dashifen\WPPB\Loader\Hook\Hook;
use Dashifen\WPPB\Loader\Hook\HookInterface;
use Dashifen\WPPB\Loader\Hook\Shortcode;

/**
 * Class Loader
 * @package Dashifen\WPPB\Loader
 */
class Loader implements LoaderInterface {
	/**
	 * @var Hook[] $actions
	 */
	protected $actions = [];
	
	/**
	 * @var Hook[] $filters
	 */
	protected $filters = [];
	
	/**
	 * @var Shortcode[] $shortcodes
	 */
	protected $shortcodes = [];
	
	/**
	 * @param string             $hook
	 * @param ComponentInterface $component
	 * @param string             $handler
	 * @param int                $priority
	 * @param int                $argCount
	 *
	 * @return void
	 */
	public function addAction(string $hook, ComponentInterface $component, string $handler, int $priority = 10, int $argCount = 1): void {
		$this->actions[] = new Hook($hook, $component, $handler, $priority, $argCount);
	}
	
	public function addFilter(string $hook, ComponentInterface $component, string $handler, int $priority = 10, int $argCount = 1): void {
		$this->filters[] = new Hook($hook, $component, $handler, $priority, $argCount);
	}
	
	public function addShortcode(string $shortcode, ComponentInterface $component, string $handler): void {
		$this->shortcodes[] = new Shortcode($shortcode, $component, $handler);
	}
	
	/**
	 * @return void
	 * @throws LoaderException
	 */
	public function attach(): void {
		if ($this->isLoaderEmpty()) {
			throw new LoaderException("Cannot attach with an empty loader.",
				LoaderException::EMPTY_LOADER);
		}
		
		$hookLists = [
			"add_action"    => $this->actions,
			"add_filter"    => $this->filters,
			"add_shortcode" => $this->shortcodes,
		];
		
		foreach ($hookLists as $wpAttachFunc => $hooks) {
			$isShortcode = $wpAttachFunc === "add_shortcode";
			
			foreach ($hooks as $hook) {
				
				// here we get our arguments for the WordPress attachment
				// function we call.  since add_action(), add_filter(), and
				// add_shortcode() have different arguments, we'll let the
				// method below sort things out.  then, we tell WordPress
				// about our plugin's behavior using a variable variable
				// called as a variadic function (see https://goo.gl/tGt2JM).
				
				$arguments = $this->getAttachmentArguments($hook, $isShortcode);
				$wpAttachFunc(...$arguments);
			}
		}
	}
	
	/**
	 * @return bool
	 */
	protected function isLoaderEmpty(): bool {
		
		// our loader is empty if we've not added any actions, filters, and
		// shortcodes.  we don't care what type of WordPress interface we're
		// working with here, just that at least one exists.
		
		$count = 0;
		$lists = [$this->actions, $this->filters, $this->shortcodes];
		foreach ($lists as $list) {
			$count += sizeof($list);
		}
		
		// now, the answer to our question -- is this loader empty -- should
		// be true when it is empty.  so, if $count is zero, we return true.
		// otherwise, false.
		
		return $count === 0;
	}
	
	/**
	 * @param HookInterface $hook
	 * @param bool          $isShortcode
	 *
	 * @return array
	 */
	protected function getAttachmentArguments(HookInterface $hook, bool $isShortcode): array {
		
		// both shortcodes and non-shortcodes are attached using a hook and a
		// callback to start.  then, non-shortcodes also get a priority and an
		// argument count.  we can build that array as follows and return it
		// to the calling scope.
		
		$arguments[] = $hook->getHook();
		$arguments[] = [
			$hook->getComponent(),
			$hook->getHandler(),
		];
		
		if (!$isShortcode) {
			
			// if this isn't a shortcode, then we want to add our
			// priority and argument count to our list of arguments,
			// too.
			
			$arguments[] = $hook->getPriority();
			$arguments[] = $hook->getArgCount();
		}
		
		return $arguments;
	}
}
