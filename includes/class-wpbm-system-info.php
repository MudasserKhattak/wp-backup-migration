<?php
namespace WPBM;

/**
 * System Information
 */
class WPBM_System_Info {

    /**
     * Display System Information
     */
    public function display_system_information() {
        $system_info    = $this->get_system_info();
        $wp_info        = $this->get_wp_info();
        $active_plugins = $this->get_active_plugins();
        $php_info       = $this->get_php_info();
        $disk_info      = $this->get_server_disk();
        include WPBM_PLUGIN_DIR . 'views/system-information.php';
    }

    /**
     * Get System Information
     * @return array
     */
    private function get_system_info() {
        return [
            'Operating System' => php_uname('s'),
            'Timezone' => date_default_timezone_get() . ' This is a WordPress Setting',
            'Server Time' => date('Y-m-d H:i:s'),
            'Web Server' => $_SERVER['SERVER_SOFTWARE'],
            'Loaded PHP INI' => php_ini_loaded_file(),
            'Server IP' => $_SERVER['SERVER_ADDR'],
            'Outbound IP' => $this->get_outbound_ip(),
            'Client IP' => $_SERVER['REMOTE_ADDR'],
            'Host' => gethostname()
        ];
    }

    /**
     * Get WordPress Information
     * @return array
     */
    private function get_wp_info()
    {
        return [
            'WordPress Version' => get_bloginfo('version'),
            'Language' => get_bloginfo('language'),
            'Database Version' => $GLOBALS['wp_version'],
            'Database Charset' => DB_CHARSET,
            'Database Collate' => DB_COLLATE,
            'Single Site' => is_multisite() ? 'No' : 'Yes',
            'Debug Mode' => WP_DEBUG ? 'Yes' : 'No',
            'Memory Limit' => WP_MEMORY_LIMIT,
            'Max Upload Size' => size_format(wp_max_upload_size()),
            'Permalink Structure' => get_option('permalink_structure'),
            'Active Theme' => wp_get_theme()->get('Name'),
            'Theme Version' => wp_get_theme()->get('Version'),
        ];
    }

    /**
     * Get Outbound IP
     * @return string
     */
    private function get_outbound_ip() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ipecho.net/plain");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $outbound_ip = curl_exec($ch);
        curl_close($ch);
        return $outbound_ip;
    }

    /**
     * Get Active Plugins
     * @return array
     */
    private function get_active_plugins() {
        $active_plugins = get_option('active_plugins');
        $plugins = [];
        foreach ($active_plugins as $plugin) {
            $data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
            $plugins[] = $data;
        }
        return $plugins;
    }

    /**
     * Get PHP Information
     * @return array
     */
    private function get_php_info()
    {
        return [
            'PHP Version' => phpversion(),
            'PHP SAPI' => php_sapi_name(),
            'User' => get_current_user(),
            'Memory Limit' => ini_get('memory_limit'),
            'Memory In Use' => memory_get_usage(),
            'Max Execution Time' => ini_get('max_execution_time'),
            'open_basedir' => ini_get('open_basedir') ? ini_get('open_basedir') : 'No Value',
            'Shell (shell_exec)' => function_exists('shell_exec') ? 'Is Supported' : 'Not Supported',
            'Shell (popen)' => function_exists('popen') ? 'Is Supported' : 'Not Supported',
            'Shell (exec)' => function_exists('exec') ? 'Is Supported' : 'Not Supported',
            'Shell Exec Zip' => function_exists('exec') && function_exists('zip_open') ? 'Is Supported' : 'Not Supported',
            'Suhosin Extension' => extension_loaded('suhosin') ? 'Enabled' : 'Disabled',
            'Architecture' => PHP_INT_SIZE * 8 . '-bit',
            'Error Log File' => ini_get('error_log')
        ];
    }

    /**
     * Get Server Disk Information
     * @return array
     */
    private function get_server_disk()
    {
        $total_space = disk_total_space('/');
        $free_space = disk_free_space('/');
        $used_space = $total_space - $free_space;
        $percent_free = round($free_space / $total_space * 100, 2);
        return [
            'Free Space' => $percent_free . '% -- ' . size_format($free_space) . ' from ' . size_format($total_space),
            'Note' => 'This value is the physical servers hard-drive allocation. On shared hosts check your control panel for the "TRUE" disk space quota value.'
        ];
    }
}
