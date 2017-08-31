<?php

namespace Dashifen\WPPB\Component;
use Dashifen\WPPB\Loader\Hook\HookInterface;

/**
 * Interface PluginInterface
 *
 * @package Dashifen\WPPB
 */
interface ComponentInterface {
    /**
     * @param string $handler
     * @param array  $arguments
     *
     * @return mixed
     * @throws ComponentException
     */
	public function __call(string $handler, array $arguments);

    /**
     * @param string $handler
     *
     * @return bool
     */
    public function hasHookHandler(string $handler): bool;

    /**
     * @param HookInterface $hook
     *
     * @return void
     * @throws ComponentException
     */
    public function attachHook(HookInterface $hook): void;
}
