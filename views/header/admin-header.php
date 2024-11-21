<div class="main-header-container">
    <div class="main-header">
        <div class="header-container">
            <div class="header-title">WP Backup & Migration</div>
        </div>
    </div>
    <?php
        $active_page = isset($_GET['page']) ? $_GET['page'] : '';
    ?>
    <div class="tabs">
        <li><a href="#" class="<?php echo $active_page === 'backup' ? 'active' : '' ?>">Backup & Migration</a></li>
        <li><a href="#" class="<?php echo $active_page === 'settings' ? 'active' : '' ?>">Settings</a></li>
        <li><a href="<?php echo esc_url(admin_url("admin.php?page=wpbm-system-info")) ?>" class="<?php echo $active_page === 'wpbm-system-info' ? 'active' : '' ?>">System Info</a></li>
    </div>
</div>


