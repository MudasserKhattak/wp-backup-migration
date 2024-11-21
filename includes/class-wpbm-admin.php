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
            'WP Backup and Migration',
            'Backup & Migration',
            'manage_options',
            'wp-backup-migration',
            array($this, 'admin_page')
        );

        add_submenu_page(
            'wp-backup-migration',
            'System Info',
            'System Info',
            'manage_options',
            'wpbm-system-info',
            array($this, 'system_info_page')
        );
    }

    public function admin_page() {
        include WPBM_PLUGIN_DIR . 'views/admin-page.php';
    }

    public function system_info_page() {
        $system_info = new WPBM_System_Info();
        $system_info->display_system_information();
    }

    public function handle_form_submission() {
        if (isset($_POST['wpbm_backup'])) {
            $this->backup_database();
            $this->backup_files();
            echo '<div class="updated"><p>Backup completed successfully.</p></div>';
        }

        if (isset($_POST['wpbm_migrate'])) {
            $new_host = sanitize_text_field($_POST['new_host']);
            $new_user = sanitize_text_field($_POST['new_user']);
            $new_password = sanitize_text_field($_POST['new_password']);
            $new_db = sanitize_text_field($_POST['new_db']);
            $new_server_path = sanitize_text_field($_POST['new_server_path']);
            $this->migrate_database($new_host, $new_user, $new_password, $new_db);
            $this->migrate_files($new_server_path);
            echo '<div class="updated"><p>Migration completed successfully.</p></div>';
        }
    }

    private function backup_database() {
        global $wpdb;
        $command = sprintf('mysqldump --user=%s --password=%s --host=%s %s > %s', DB_USER, DB_PASSWORD, DB_HOST, DB_NAME, WPBM_DB_BACKUP_FILE);
        system($command);
    }

    private function backup_files() {
        $command = sprintf('cp -r %s %s', ABSPATH, WPBM_FILES_BACKUP_DIR);
        system($command);
    }

    private function migrate_database($new_host, $new_user, $new_password, $new_db) {
        $command = sprintf('mysql --user=%s --password=%s --host=%s %s < %s', $new_user, $new_password, $new_host, $new_db, WPBM_DB_BACKUP_FILE);
        system($command);
    }

    private function migrate_files($new_server_path) {
        $command = sprintf('scp -r %s %s', WPBM_FILES_BACKUP_DIR, $new_server_path);
        system($command);
    }

    public function enqueue_scripts() {
        wp_enqueue_style('wpbm-admin-style', WPBM_ASSETS_URL . 'css/admin-style.css');
        wp_enqueue_script('wpbm-admin-script', WPBM_ASSETS_URL . 'js/admin-script.js', array('jquery'), null, true);
    }
}
