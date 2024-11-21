
<?php include WPBM_PLUGIN_DIR . 'views/header/admin-header.php'; ?>

<div class="features">
    <div class="feature-card">
      <button id="add-new-backup-btn" class="feature-button">Create Backup</button>
    </div>
</div>

<?php include WPBM_PLUGIN_DIR . 'views/backup/create-backup.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const featureButton = document.querySelector('#add-new-backup-btn');
    const createBackupContainer = document.querySelector('.create-backup-container');
    const closeButton = document.querySelector('#create-backup-btn-close');

    featureButton.addEventListener('click', () => {
      createBackupContainer.classList.remove('hidden');
    });

    closeButton.addEventListener('click', () => {
      createBackupContainer.classList.add('hidden');
    });
  });
</script>
