<?php

namespace WPBM\Core\DI;

/**
 * Class ServiceProvider
 * @package WPBM\Core\DI
 */
abstract class ServiceProvider
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    abstract public function register();
}
