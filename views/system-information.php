<?php
include WPBM_PLUGIN_DIR . 'views/header/admin-header.php';
/**
 * @var array $wp_info
 * @var array $system_info
 * @var array $active_plugins
 * @var array $php_info
 * @var array $disk_info
 */
?>

<div class="container">
    <div class="section">
        <h2>General</h2>
        <table>
            <?php foreach ($system_info as $key => $value): ?>
                <tr>
                    <th><?php echo esc_html($key); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="section">
        <h2>WordPress</h2>
        <table>
            <?php foreach ($wp_info as $key => $value): ?>
                <tr>
                    <th><?php echo esc_html($key); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h2>Active Plugins</h2>
        <table>
            <?php foreach ($active_plugins as $key => $value): ?>
                <tr>
                    <th><?php echo esc_html($value['Name']); ?></th>
                    <td><?php echo esc_html($value['Version']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="section">
        <h2>PHP</h2>
        <table>
            <?php foreach ($php_info as $key => $value): ?>
                <tr>
                    <th><?php echo esc_html($key); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="section">
        <h2>Server Disk</h2>
        <table>
            <?php foreach ($disk_info as $key => $value): ?>
                <tr>
                    <th><?php echo esc_html($key); ?></th>
                    <td><?php echo esc_html($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
