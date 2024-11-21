<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!defined('WPBM_PLUGIN_DIR')) {
    define('WPBM_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

if (!defined('WPBM_PLUGIN_URL')) {
    define('WPBM_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('WPBM_BACKUP_DIR')) {
    define('WPBM_BACKUP_DIR', WP_CONTENT_DIR . '/uploads/wp-backup-migration');
}

if (!defined('WPBM_DB_BACKUP_FILE')) {
    define('WPBM_DB_BACKUP_FILE', WPBM_BACKUP_DIR . '/db-backup-' . time() . '.sql');
}

if (!defined('WPBM_FILES_BACKUP_DIR')) {
    define('WPBM_FILES_BACKUP_DIR', WPBM_BACKUP_DIR . '/files-backup-' . time());
}
