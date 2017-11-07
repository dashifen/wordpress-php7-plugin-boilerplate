<?php

namespace Dashifen\WPPB\Controller\ControllerTraits;

use Dashifen\WPPB\Controller\ControllerException;

trait TaxonomiesTrait {
	/**
	 * Returns an array of taxonomies registered within this plugin
	 * where the name of the taxonomies are the values of the array.
	 *
	 * @return array
	 */
	abstract public function getTaxonomies(): array;
	
	/**
	 * Given an index, return that taxonomy from the list of taxonomies
	 * provided by getTaxonomies().  It is recommended to specify a const
	 * value for each taxonomy to avoid errors.
	 *
	 * @param int $index
	 *
	 * @return string
	 * @throws ControllerException
	 */
	final public function getTaxonomy(int $index): string {
		$taxonomies = $this->getTaxonomies();
		if ($index >= sizeof($taxonomies)) {
			throw new ControllerException("Unknown taxonomy",
				ControllerException::UNKNOWN_TAX);
		}
		
		return $taxonomies[$index];
	}
	
	/**
	 * Given the name of a taxonomy, returns the post types to which it
	 * should be linked.
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	abstract public function getTaxonomyTypes(string $taxonomy): array;
	
	/**
	 * Given the name of a taxonomy, returns the array of labels for it
	 * based on the needs of the register_taxonomy WordPress function.
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	abstract public function getTaxonomyLabels(string $taxonomy): array;
	
	/**
	 * Given the name of a taxonomy, returns the array of arguments for the
	 * register_taxonomy() WordPress function.  this array should not have the
	 * labels or rewrite indices; if it does, they'll likely be overwritten by
	 * the results of other methods herein.
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	abstract public function getTaxonomyArgs(string $taxonomy): array;
	
	/**
	 * Given the name of a taxonomy, returns the rewrite array for use within
	 * the arguments to the register_taxonomy WordPress function.
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	abstract public function getTaxonomyRewrite(string $taxonomy): array;
	
	/**
	 * Initializes this trait and registers these taxonomies using the
	 * appropriate WordPress action hook.
	 *
	 * @return void
	 */
	final protected function initTaxonomiesTrait(): void {
		
		// notice that this action is added at the 15th priority.  since
		// taxonomies and post types are used in conjuction with each other,
		// we want to be sure that our types are registered before we start
		// to link taxonomies to them.  so, the PostTypesTrait leaves its
		// registration at priority 10.  then, this init action will process
		// at 15.
		
		add_action("init", function () {
			foreach ($this->getTaxonomies() as $taxonomy) {
				$this->registerTaxonomy($taxonomy);
			}
		}, 15);
	}
	
	/**
	 * Given the the name of a taxonomy, accumulates the arguments for the
	 * WordPress register_taxonomy() function and then calls it.
	 *
	 * @param string $taxonomy
	 *
	 * @return void
	 */
	final public function registerTaxonomy(string $taxonomy): void {
		
		// this method is public since it's likely that the Activator of a
		// plugin will want to register taxonomies and then flush the rewrite
		// rules to update permalinks.
		
		$args = $this->getTaxonomyArgs($taxonomy);
		$args["labels"] = $this->getTaxonomyLabels($taxonomy);
		$args["rewrite"] = $this->getTaxonomyRewrite($taxonomy);
		
		register_taxonomy($taxonomy, $this->getTaxonomyTypes($taxonomy), $args);
	}
}
