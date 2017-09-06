<?php

namespace Dashifen\WPPB\Controller\BackendTraits;

trait PostTypeTrait {
	/**
	 * @return string
	 */
	abstract public function getPluginPostType(): string;
	
	/**
	 * @return string
	 */
	abstract public function getPluginPostTypeSlug(): string;
	
	/**
	 * @return void
	 */
	abstract public function registerPostType(): void;
}
