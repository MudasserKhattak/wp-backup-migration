<?php

namespace WPBM;

/**
 * Class WPBM_Admin
 * @package WPBM
 */
class WPBM_Admin {

    /**
     * WPBM_Admin constructor.
     */
    public function __construct() {
        $this->load_dependencies();
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load the required dependencies for this plugin.
     * @return void
     */
    private function load_dependencies() {
        require_once WPBM_PLUGIN_DIR . 'includes/class-wpbm-system-info.php';
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     * @return void
     */
    public function add_admin_menu() {
        add_menu_page(
            'WP Backup Migration',
            'Backup Migration',
            'manage_options',
            'wpbm-backup-migration',
            array($this, 'backup_migration_page')
        );

        add_submenu_page(
            'wpbm-backup-migration',
            'Backup',
            'Backup',
            'manage_options',
            'wpbm-backup-migration',
            array($this, 'backup_migration_page')
        );


        // add settings page
        add_submenu_page(
            'wpbm-backup-migration',
            'Settings',
            'Settings',
            'manage_options',
            'wpbm-settings',
            array($this, 'settings_page')
        );

        add_submenu_page(
            'wpbm-backup-migration',
            'System Info',
            'System Info',
            'manage_options',
            'wpbm-system-info',
            array($this, 'system_info_page')
        );
    }

    /**
     *
     * @return void
     */
    public function backup_migration_page() {
        include WPBM_PLUGIN_DIR . 'views/admin-page.php';
    }

    /**
     * @return void
     */
    public function system_info_page() {
        $system_info = new WPBM_System_Info();
        $system_info->display_system_information();
    }

    /**
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_script('wpbm-admin-script', WPBM_ASSETS_URL . 'js/admin-script.js', array(), null, true);
        wp_localize_script('wpbm-admin-script', 'wpbm', array(
            'nonce'  => wp_create_nonce('wpbm-nonce'),
            'ajaxUrl'=> admin_url('admin-ajax.php'),
        ));
        wp_enqueue_style('wpbm-admin-style', WPBM_ASSETS_URL . 'css/admin-style.css');
        add_filter('script_loader_tag', [$this, 'addTypeModuleAttribute'], 10, 2);
    }

    /**
     * @param string $tag
     * @param string $handle
     * @return string
     */
    public function addTypeModuleAttribute($tag, $handle) {
        if ($handle !== 'wpbm-admin-script') {
            return $tag;
        }

        $new_tag = str_replace("type='text/javascript'", '', $tag);
        $new_tag = str_replace(" src", " type='module' src", $new_tag);
        return $new_tag;
    }
}
