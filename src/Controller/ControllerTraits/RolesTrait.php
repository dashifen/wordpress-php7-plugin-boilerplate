<?php

namespace Dashifen\WPPB\Controller\ControllerTraits;

trait RolesTrait {
	/**
	 * Returns an array of the user roles added by this plugin.
	 *
	 * @return array
	 */
	abstract public function getRoleSlugs(): array;
	
	/**
	 * Returns an array of the on-screen display for the user roles
	 * added by this plugin.  This array must be indexed by the names
	 * returned by getRoleSlugs().
	 *
	 * @return array
	 */
	abstract public function getRoleNames(): array;
	
	/**
	 * Returns the on-screen display for the specified role.
	 *
	 * @param string $role
	 *
	 * @return string
	 */
	abstract public function getRoleName(string $role): string;
	
	/**
	 * Returns an array of capabilities for the user roles added by
	 * this plugin.  This array must be indexed by the names returned
	 * by getRoleSlugs() and the values indexed must also be arrays.
	 *
	 * @param string $role
	 *
	 * @return array
	 */
	abstract public function getRoleCapabilities(string $role = null): array;
	
	/**
	 * @return void
	 */
	final protected function initRolesTrait(): void {
		
		// initialzing our RoleTrait is as simple as making sure that
		// we've registered this new user role within the WordPress
		// ecosystem.
		
		$slugs = $this->getRoleSlugs();
		$names = $this->getRoleNames();
		$caps = $this->getRoleCapabilities();
		
		add_action("init", function() use ($slugs, $names, $caps) {
			foreach ($slugs as $slug) {
				add_role($slug, $names[$slug], $caps[$slug]);
			}
		});
	}
}
