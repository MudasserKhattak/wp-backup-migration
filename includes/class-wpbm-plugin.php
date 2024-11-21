<?php

namespace WPBM;

class WPBM_Plugin {

    protected $loader;

    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wpbm-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wpbm-admin.php';
        $this->loader = new WPBM_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new WPBM_Admin();

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'handle_form_submission');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('wp_enqueue_script', $plugin_admin, 'enqueue_scripts');
        //add_filter('script_loader_tag', [$this, 'addTypeModuleAttribute'], 10, 2);
    }

    public function run() {
        $this->loader->run();
    }

    public function addTypeModuleAttribute($tag, $handle) {
        if ( $handle !== 'wpbm-admin-script' ) {
            return $tag;
        }

        $new_tag = str_replace("type='text/javascript'", '', $tag);
        $new_tag = str_replace(" src", " type='module' src", $new_tag);
        return $new_tag;
    }
}
