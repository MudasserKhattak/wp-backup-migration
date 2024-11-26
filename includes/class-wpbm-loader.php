<?php

namespace WPBM;

/**
 * Register all actions and filters for the plugin
 */
class WPBM_Loader {

    /**
     * The array of actions registered with WordPress
     *
     * @var array
     */
    protected $actions;

    /**
     * Initialize the collections used to maintain the actions.
     * @return void
     */
    public function __construct() {
        $this->actions = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param string $hook The name of the WordPress action that is being registered.
     * @param object $component A reference to the instance of the object on which the action is defined.
     * @param string $callback The name of the function definition on the $component.
     */
    public function add_action($hook, $component, $callback) {
        $this->actions[] = array(
            'hook'      => $hook,
            'component' => $component,
            'callback'  => $callback,
        );
    }

    /**
     * Register the actions with WordPress.
     * @return void
     */
    public function run() {
        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']));
        }
    }
}
