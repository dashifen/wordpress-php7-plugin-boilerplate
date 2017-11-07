<?php

namespace Dashifen\WPPB\Controller\ControllerTraits;

use Dashifen\WPPB\Controller\ControllerException;

trait PostTypesTrait {
	/**
	 * returns an array of our post types in the format needed for the
	 * first parameter to register_post_type().
	 *
	 * @return array
	 */
	abstract public function getPostTypes(): array;
	
	/**
	 * given an $index, returns that post type from the array returned by
	 * getPostTypes().
	 *
	 * @param int $index
	 *
	 * @return string
	 * @throws ControllerException
	 */
	final public function getPostType(int $index): string {
		$types = $this->getPostTypes();
		if (!isset($types[$index])) {
			throw new ControllerException("Unknown type.",
				ControllerException::UNKNOWN_TYPE);
		}
		
		return $types[$index];
	}
	
	/**
	 * Returns an array suitable for use as the labels for a post type.
	 *
	 * @param string $postType
	 *
	 * @return array
	 */
	abstract public function getPostTypeLabels(string $postType): array;
	
	/**
	 * Returns an array of arguments suitable for use in register_post_types().
	 * This array shouldn't include the label, lables, or rewrite indices.
	 * Additionally, the register_meta_box_cb index will be ignored in favor
	 * of the getPostTypeMetaBoxCallback() method.
	 *
	 * @param string $postType
	 *
	 * @return array
	 */
	abstract public function getPostTypeArgs(string $postType): array;
	
	/**
	 * Returns an array for use as a post types rewrite index when it's
	 * registered.
	 *
	 * @param string $postType
	 *
	 * @return array
	 */
	abstract public function getPostTypeRewrite(string $postType): array;
	
	/**
	 * Returns the name of the post type's metabox callback or null if
	 * this type doesn't need one.
	 *
	 * @param string $postType
	 *
	 * @return string|null
	 */
	abstract public function getPostTypeMetaBoxCallback(string $postType): ?string;
	
	/**
	 * Called automatically when the plugins are loaded, this method
	 * registers our post types for the users of this boilerplate.
	 *
	 * @return void
	 */
	final protected function initPostTypesTrait() {
		add_action("init", function () {
			$postTypes = $this->getPostTypes();
			foreach ($postTypes as $postType) {
				$this->registerPostType($postType);
			}
		});
	}
	
	/**
	 * @param string $postType
	 *
	 * @return void
	 */
	final public function registerPostType(string $postType): void {
		
		// we make this a public method because we use it in our
		// initialization method below but frequently from the activation
		// action of the plugin itself so that we can flush permalinks
		// based on our new types.
		
		$args = $this->getPostTypeArgs($postType);
		$args["labels"] = $this->getPostTypeLabels($postType);
		$args["rewrite"] = $this->getPostTypeRewrite($postType);
		unset($args["label"], $args["register_meta_box_cb"]);
		
		register_post_type($postType, $args);
	}
}
