<?php

namespace Dashifen\WPPB\Controller\BackendTraits;

trait UserRoleTrait {
	/**
	 * @return string
	 */
	abstract public function getUserRoleSlug(): string;
	
	/**
	 * @return string
	 */
	abstract public function getUserRoleName(): string;
}
