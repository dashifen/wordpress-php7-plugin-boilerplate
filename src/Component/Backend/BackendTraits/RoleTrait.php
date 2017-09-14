<?php

namespace Dashifen\WPPB\Component\Backend\BackendTraits;

trait RoleTrait {
	/**
	 * @return string
	 */
	abstract public function getRoleSlug(): string;
	
	/**
	 * @return string
	 */
	abstract public function getRoleName(): string;
}
