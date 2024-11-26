<?php

namespace WPBM\Core;

use WPBM\Core\DI\ServiceProvider;

/**
 * Class WPBMServiceProvider
 * @package WPBM\Core
 */
class WPBMServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register your services here
        /*$this->container->singleton('LoggerInterface', function () {
            //return new \YourNamespace\FileLogger();
        });*/
    }
}
