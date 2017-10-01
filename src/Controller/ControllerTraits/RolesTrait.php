<?php

namespace Dashifen\WPPB\Controller\ControllerTraits;

use Dashifen\WPPB\Controller\ControllerException;

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
	 * @throws ControllerException
	 */
	final protected function initRolesTrait(): void {
		
		// initialzing our RoleTrait is as simple as making sure that
		// we've registered this new user role within the WordPress
		// ecosystem.
		
		$slugs = $this->getRoleSlugs();
		$names = $this->getRoleNames();
		$caps = $this->getRoleCapabilities();
		
		// the adding of a role is saved in the database, so it only needs
		// to be done when our plugin is activated.  we remove it when it's
		// deactivated.  to do that, we need to get the plugin's filename
		// from the controller to which we're attached.
		
		if (!method_exists($this, "getFilename")) {
			throw new ControllerException("Missing method: getFilename",
				ControllerException::MISSING_METHOD);
		}
		
		$plugin = $this->getFilename();
		
		add_action("activate_$plugin", function() use ($slugs, $names, $caps) {
			
			// when activating, we loop over our $slugs and use them to
			// add each role to WordPress as follows:
			
			foreach ($slugs as $slug) {
				add_role($slug, $names[$slug], $caps[$slug]);
			}
		});
		
		add_action("deactivate_$plugin", function() use ($slugs) {
			
			// conversely, when deactivating, we want to remove those roles
			// which is even easier.
			
			foreach ($slugs as $slug) {
				remove_role($slug);
			}
		});
	}
}
