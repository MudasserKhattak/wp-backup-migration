
<?php include WPBM_PLUGIN_DIR . 'views/header/admin-header.php'; ?>

<div class="features">
    <div class="feature-card">
        <button id="add-new-backup-btn" class="backup-button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Create Backup
        </button>
    </div>
</div>

<?php include WPBM_PLUGIN_DIR . 'views/backup/create-backup.php'; ?>
