<?php

namespace Dashifen\WPPB\Controller\ControllerTraits;

/**
 * Trait PostStatusesTrait
 * @package Dashifen\WPPB\Controller\ControllerTraits
 */
trait PostStatusesTrait {
	/**
	 * Returns an array of the post statuses added by this plugin.
	 * these should be all lowercase and words should be separated by
	 * hyphens (e.g. unread-post and not unreadPost or unread_post).
	 *
	 * @return array
	 */
	abstract public function getPostStatuses(): array;
	
	/**
	 * Given the name of a status returned by getPostStatuses(), this
	 * method returns the arguments that are passed to register_post_status
	 * as its second parameter.  Without a status, returns all such arguments
	 * as an array indexed by our statuses.
	 *
	 * @param string $status
	 *
	 * @return array
	 */
	abstract protected function getPostStatusArguments(string $status = null): array;
	
	/**
	 * When we initialize this trait, we want to register our post statuses
	 * and ensure that they appear in the status drop-downs throughout Word-
	 * Press core.
	 *
	 * @return void
	 */
	final protected function initPostStatusesTrait(): void {
		$postStatuses = $this->getPostStatuses();
		
		// first, we register our statuses.  notice that we directly call the
		// WordPress add_action() function because we want to use anonymous
		// functions here, and there's no good way to add these actions to a
		// LoaderInterface object as a result.  plus, we want these actions to
		// "just happen" without a programmer having to think about them.
		
		foreach ($postStatuses as $postStatus) {
			$args = $this->getPostStatusArguments($postStatus);
			add_action("init", function () use ($postStatus, $args) {
				register_post_status($postStatus, $args);
			});
		}
		
		add_action("post_submitbox_misc_actions", function ($post) use ($postStatuses) {
			/** @var \WP_Post $post */
			
			// registering our post status tells WordPress all about it, but
			// WordPress doesn't automatically add them to the <select> elements
			// in the DOM (see: https://core.trac.wordpress.org/ticket/12706).
			// so, we do that here.
			
			ob_start(); ?>

            <script id="php7BoilerplateAddPostStatuses">
				(function ($) {
					$(document).ready(function () {
						var statusSelect = $("#post_status");
						if (statusSelect.length > 0) {
							<?php foreach ($postStatuses as $postStatus) {
							
                                // because we're foolishly mixing PHP in this
                                // JS block, we need to be careful about how we
                                // print our variables below.  the $text and
                                // $postStatus variables are displayed on
                                // screen as a part of our option, so those
                                // have to be strings.  but, the $selected flag
                                // doesn't need quotes because we want it to be
                                // the Boolean value true or false, not the
                                // strings becuase, in JS, "false" != false.
                                
                                $text = ucwords(str_replace("-", " ", $postStatus));
                                $selected = $postStatus !== $post->post_status
                                    ? "false" : "true"; ?>
    
                                var option = $("<option>")
                                    .prop("selected", <?= $selected ?>)
                                    .attr("value", "<?= $postStatus ?>")
                                    .text("<?= $text ?>");
    
                                statusSelect.append(option);
							
							<?php } ?>
                            
                            // in case something else needs to do work on our
                            // new option, we'll trigger an event here.
                            
                            var event = new jQuery.Event("postStatusesAdded");
                            statusSelect.trigger(event);
						}
					});
				})(jQuery);
            </script>
			
			<?php echo ob_get_clean();
		});
	}
}
