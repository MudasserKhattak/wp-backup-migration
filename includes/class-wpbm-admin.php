<?php

class WPBM_Admin {

    public function add_admin_menu() {
        add_menu_page('WP Backup and Migration', 'Backup & Migration', 'manage_options', 'wp-backup-migration', array($this, 'admin_page'));
    }

    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>WP Backup and Migration</h1>
            <form method="post">
                <h2>Backup</h2>
                <input type="submit" name="wpbm_backup" value="Backup Now" class="button button-primary">
                <h2>Migration</h2>
                <input type="text" name="new_host" placeholder="New Host">
                <input type="text" name="new_user" placeholder="New User">
                <input type="password" name="new_password" placeholder="New Password">
                <input type="text" name="new_db" placeholder="New Database">
                <input type="text" name="new_server_path" placeholder="New Server Path">
                <input type="submit" name="wpbm_migrate" value="Migrate Now" class="button button-primary">
            </form>
        </div>
        <?php
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
}
