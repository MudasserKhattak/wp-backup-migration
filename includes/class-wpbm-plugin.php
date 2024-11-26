<?php

namespace WPBM;

/**
 * Class WPBM_Plugin
 * @package WPBM
 */
class WPBM_Plugin {
    /**
     * @var WPBM_Loader
     */
    protected $loader;

    /**
     * WPBM_Plugin constructor.
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     * @return void
     */
    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wpbm-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wpbm-admin.php';
        $this->loader = new WPBM_Loader();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     * @return void
     */
    private function define_admin_hooks() {
        $plugin_admin = new WPBM_Admin();

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'handle_form_submission');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('wp_enqueue_script', $plugin_admin, 'enqueue_scripts');
    }

    public function run() {
        $this->loader->run();
    }
}
