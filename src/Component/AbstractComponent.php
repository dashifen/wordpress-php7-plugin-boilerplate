<?php

namespace Dashifen\WPPB\Component;

use Dashifen\WPPB\Controller\ControllerInterface;
use Dashifen\WPPB\Loader\Hook\HookInterface;

/**
 * Class AbstractComponent
 *
 * This is a strange class:  it has no abstract methods but we still make
 * it abstract.  This is to help those using this boilerplate since all of
 * the other foundational objects within it are abstract.  That way, this
 * isn't the only concrete class in the bunch.
 *
 * @package Dashifen\WPPB
 */
abstract class AbstractComponent implements ComponentInterface {
	/**
	 * @var ControllerInterface $controller
	 */
	protected $controller;
	
	/**
	 * @var HookInterface[] $attachment
	 */
	protected $attachments = [];
	
	/**
	 * Component constructor.
	 *
	 * @param ControllerInterface $controller
	 */
	public function __construct(ControllerInterface $controller) {
		$this->controller = $controller;
	}
	
	/**
	 * @param string $handler
	 * @param array  $arguments
	 *
	 * @return mixed
	 * @throws ComponentException
	 */
	public function __call(string $handler, array $arguments) {
		if (!$this->hasHookHandler($handler)) {
			throw new ComponentException("Unknown handler: $handler",
				ComponentException::UNKNOWN_HANDLER);
		}
		
		// now that we know the handler exists, we can do two more checks:
		// that it was "attached" to this Component and that our attached
		// handler expects the same number of arguments that we've received.
		
		if (!$this->hasAttachedHookHandler($handler)) {
			throw new ComponentException("Unattached handler: $handler",
				ComponentException::UNATTACHED_HANDLER);
		}
		
		$actualArgCount = sizeof($arguments);
		if (!$this->hasExpectedArgCount($handler, $actualArgCount)) {
			$message = $this->getExpectedArgCountMessage($handler, $actualArgCount);
			throw new ComponentException($message, ComponentException::ARGUMENT_COUNT_MISMATCH);
		}
		
		// if we made it all the way through those two tests, then we can
		// call our handler.  since our handlers are written to look like
		// "normal" WordPress actions and filters, we'll unpack our list of
		// arguments; see variadic functions (https://goo.gl/tGt2JM) for
		// more information.
		
		return $this->{$handler}(...$arguments);
	}
	
	/**
	 * @param string $handler
	 *
	 * @return bool
	 */
	public function hasHookHandler(string $handler): bool {
		return method_exists($this, $handler);
	}
	
	/**
	 * @param string $handler
	 *
	 * @return bool
	 */
	protected function hasAttachedHookHandler(string $handler): bool {
		return isset($this->attachments[$handler]);
	}
	
	/**
	 * @param string $handler
	 * @param int    $actualArgCount
	 *
	 *
	 * @return bool
	 */
	protected function hasExpectedArgCount(string $handler, int $actualArgCount): bool {
		$expectedArgCount = $this->attachments[$handler]->getArgCount();
		return $actualArgCount <=> $expectedArgCount === 0;
	}
	
	/**
	 * @param string $handler
	 * @param int    $actualArgCount
	 *
	 * @return string
	 */
	protected function getExpectedArgCountMessage(string $handler, int $actualArgCount): string {
		$expectedArgCount = $this->attachments[$handler]->getArgCount();
		$message = $actualArgCount <=> $expectedArgCount === -1
			? "Not enough arguments for %s.  Received %d; expected %d"
			: "Too many arguments for %s.  Received %d; expected %d";
		
		$message = sprintf($message, $handler, $actualArgCount,
			$expectedArgCount);
		
		return $message;
	}
	
	/**
	 * @param HookInterface $hook
	 *
	 * @return void
	 * @throws ComponentException
	 */
	public function attachHook(HookInterface $hook): void {
		
		// to attach a hook to our component, we want to index our
		// $attachments property using the handler within $hook.  if
		// a handler already has a hook, we have a problem -- each
		// handler must be unique and it had better exist, too.
		
		$handler = $hook->getHandler();
		
		if (!$this->hasHookHandler($handler)) {
			throw new ComponentException("Unknown handler: $handler",
				ComponentException::UNKNOWN_HANDLER);
		}
		
		if (isset($this->attachments[$handler])) {
			throw new ComponentException("Duplicated handler: $handler",
				ComponentException::DUPLICATED_HANDLER);
		}
		
		$this->attachments[$handler] = $hook;
	}
}
