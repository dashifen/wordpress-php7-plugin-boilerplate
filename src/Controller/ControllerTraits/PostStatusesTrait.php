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
		
		$options = [];
		foreach ($postStatuses as $postStatus) {
			$args = $this->getPostStatusArguments($postStatus);
			add_action("init", function () use ($postStatus, $args) {
				register_post_status($postStatus, $args);
			});
			
			$options[$postStatus] = $args["label"];
		}
		
		add_action("post_submitbox_misc_actions",
			function (\WP_Post $post) use ($options) {
				// registering our post status tells WordPress all about it,
				// but WordPress doesn't automatically add them to the <select>
				// elements in the DOM.  so, we do that here.  for more info
				// see https://core.trac.wordpress.org/ticket/12706.
				
				$jsonOptions = "{";
				$optionFormat = '"%s": { "display": "%s", "selected": %d },';
				foreach ($options as $status => $display) {
					$selected = (int)$post->post_status === $status;
					
					// for each of our options, we use the above format to
					// create a series of JSON strings which we can inject
					// into our JavaScript below.
					
					$jsonOptions .= sprintf($optionFormat, $status, $display, $selected);
				}
				
				// the loop above adds an extra comma to our JSON string.
				// we'll replace that comma with a the closing curly brace
				// to end said string.
				
				$jsonOptions = preg_replace("/,$/", "}", $jsonOptions);
				ob_start(); ?>

                <script id="php7BoilerplateAddPostStatuses">
					(function ($) {

						// we'll add our statuses into the scope of this
						// anonymous functions.  that way, it's accessible
						// to the other functions, anonymous or otherwise,
						// herein.  but, it won't conflict with any other
						// variable named statuses outside this scope.

						var statuses = <?= $jsonOptions ?>;

						$(document).ready(function () {
							var statusSelect = $("#post_status");
							if (statusSelect.length > 0) {

								// as long as we have a status <select> in
								// the DOM, we'll want to do some work to make
                                // our custom statuses work.

								setDisplayedStatus(statusSelect);
								$(".save-post-status").click(setHiddenStatus);
								addCustomStatuses(statusSelect);
							}
						});
						
						function setDisplayedStatus(statusSelect) {
							var status = statusSelect.val();
							
							// as long as our status is in our list of custom
                            // statuses, we want to make sure that the on-
                            // screen display of the posts's status matches
                            // the display of the selected option.
                            
                            if ($.inArray(status, statuses)) {
                                var display = statusSelect.find("option[value=" + status + "]").text();
                                $("#post-status-display").text(display);
                            }
						}
						
						function setHiddenStatus() {
							var status = $("#post_status").val();

							// as long as the status that's selected is a part
							// of our list of statuses, we'll want to set the
							// the value of the #hidden_post_status field to
							// the selected status.

							if ($.inArray(status, statuses)) {
								$("#hidden_post_status").val(status);
							}
						}

						function addCustomStatuses(statusSelect) {
							for(status in statuses) {
								if (statuses.hasOwnProperty(status)) {

									// for each of our custom statuses, we
									// create an <option>.  if our status is
									// selected, then we set that property.
									// otherwise, we set various attributes
									// and then append it to our <select>
									// element.

									var option = $("<option>")
										.prop("selected", statuses[status].selected)
										.text(statuses[status].display)
										.attr("value", status)
										.data("custom", true);

									statusSelect.append(option);
								}
							}

							// in case we need to do anything else after we've
							// changed the DOM, we fire this event, too.  then,
							// other JS can watch for it and handle any clean
							// up or whatever when it's caught.

							var event = new jQuery.Event("postStatusesAdded");
							statusSelect.trigger(event);
						}
					})(jQuery);
                </script>
				
				<?php echo ob_get_clean();
				
			}
		);
	}
}
