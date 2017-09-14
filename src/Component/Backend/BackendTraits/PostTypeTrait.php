<?php

namespace Dashifen\WPPB\Component\Backend\BackendTraits;

trait PostTypeTrait {
	/**
	 * @return string
	 */
	abstract public function getPostType(): string;
	
	/**
	 * @return string
	 */
	abstract public function getPostTypeSlug(): string;
	
	/**
	 * @return void
	 */
	abstract public function registerPostType(): void;
}
