<?php

namespace WPBM;

class WPBM_Loader {

    protected $actions;

    public function __construct() {
        $this->actions = array();
    }

    public function add_action($hook, $component, $callback) {
        $this->actions[] = array(
            'hook'      => $hook,
            'component' => $component,
            'callback'  => $callback,
        );
    }

    public function run() {
        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']));
        }
    }
}
