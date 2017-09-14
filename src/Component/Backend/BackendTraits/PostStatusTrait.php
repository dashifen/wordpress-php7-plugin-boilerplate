<?php

namespace Dashifen\WPPB\Component\Backend\BackendTraits;

/**
 * Trait PostStatusTrait
 * @package Dashifen\WPPB\Component\Backend\BackendTraits
 */
trait PostStatusTrait {
	/**
	 * @return string
	 */
	abstract public function getPostStatus(): string;
	
	/**
	 * @return string
	 */
	abstract public function registerPostStatus(): string;
	
	/**
	 * @return void
	 */
	abstract protected function addPostStatusToDOM(): void;
}
