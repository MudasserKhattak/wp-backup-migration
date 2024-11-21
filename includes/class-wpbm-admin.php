<?php

namespace WPBM;

class WPBM_Admin {

    public function __construct() {
        $this->load_dependencies();
    }

    private function load_dependencies() {
        require_once WPBM_PLUGIN_DIR . 'includes/class-wpbm-system-info.php';
    }

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

    public function backup_migration_page() {
        include WPBM_PLUGIN_DIR . 'views/admin-page.php';
    }

    public function system_info_page() {
        $system_info = new WPBM_System_Info();
        $system_info->display_system_information();
    }

    public function enqueue_scripts() {
        /*wp_localize_script('wpbm-admin-script', 'wpbm', array(
            'nonce'  => wp_create_nonce('wpbm-nonce'),
            'ajaxUrl'=> admin_url('admin-ajax.php'),
        ));*/
        wp_enqueue_style('wpbm-admin-style', WPBM_ASSETS_URL . 'css/admin-style.css', rand(111,9999), 'all');
        wp_enqueue_script('wpbm-admin-script', WPBM_ASSETS_URL . 'js/admin-script.js', array(), rand(111,9999), true);
    }
}
