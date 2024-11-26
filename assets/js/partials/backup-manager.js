export default class BackupManager {
  constructor() {
    this.backupUniquePrefix = '';
    this.backupInProgress = false;
    this.featureButton = document.querySelector('#add-new-backup-btn');
    this.createBackupContainer = document.querySelector('.create-backup-container');
    this.closeButton = document.querySelector('#create-backup-btn-close');

    this.fullSiteBtn = document.getElementById('fullSiteBtn');
    this.databaseOnlyBtn = document.getElementById('databaseOnlyBtn');
    this.mediaOnlyBtn = document.getElementById('mediaOnlyBtn');
    this.customBtn = document.getElementById('customBtn');

    this.checkboxes = {
      database: document.getElementById('databaseCheckbox'),
      core: document.getElementById('coreCheckbox'),
      plugins: document.getElementById('pluginsCheckbox'),
      onlyActivePlugins: document.getElementById('onlyActivePluginsCheckbox'),
      media: document.getElementById('mediaCheckbox'),
      themes: document.getElementById('themesCheckbox'),
      onlyActiveThemes: document.getElementById('onlyActiveThemesCheckbox'),
      other: document.getElementById('otherCheckbox')
    };

    this.addEventListeners();
  }

  addEventListeners() {
    this.featureButton.addEventListener('click', () => this.showCreateBackupContainer());
    this.closeButton.addEventListener('click', () => this.hideCreateBackupContainer());

    this.fullSiteBtn.addEventListener('click', () => this.setFullSiteBackup());
    this.databaseOnlyBtn.addEventListener('click', () => this.setDatabaseOnlyBackup());
    this.mediaOnlyBtn.addEventListener('click', () => this.setMediaOnlyBackup());
    this.customBtn.addEventListener('click', () => this.setCustomBackup());
  }

  showCreateBackupContainer() {
    this.createBackupContainer.classList.remove('hidden');
  }

  hideCreateBackupContainer() {
    this.createBackupContainer.classList.add('hidden');
  }

  setFullSiteBackup() {
    this.setCheckboxes({
      database: true,
      core: true,
      plugins: true,
      onlyActivePlugins: false,
      media: true,
      themes: true,
      onlyActiveThemes: false,
      other: true
    });
  }

  setDatabaseOnlyBackup() {
    this.setCheckboxes({
      database: true,
      core: false,
      plugins: false,
      onlyActivePlugins: false,
      media: false,
      themes: false,
      onlyActiveThemes: false,
      other: false
    });
  }

  setMediaOnlyBackup() {
    this.setCheckboxes({
      database: false,
      core: false,
      plugins: false,
      onlyActivePlugins: false,
      media: true,
      themes: false,
      onlyActiveThemes: false,
      other: false
    });
  }

  setCustomBackup() {
    this.setCheckboxes({
      database: true,
      core: false,
      plugins: true,
      onlyActivePlugins: true,
      media: true,
      themes: false,
      onlyActiveThemes: true,
      other: false
    });
  }

  setCheckboxes(settings) {
    for (const [key, value] of Object.entries(settings)) {
      this.checkboxes[key].checked = value;
    }
  }

  createBackup() {
    if (this.backupInProgress) {
      alert('Backup already in progress');
      return;
    }

    // Initiate backup
    $.ajax({
      url: '',
      method: 'POST',
      data: {action: 'initiate_backup'},
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          this.backupUniquePrefix = response.data.unique_prefix;
          this.backupInProgress = true;
          $('#backupProgress').html(`Backup started. Total Tables: ${response.data.total_tables}`);

          // Start backing up chunks
          this.backupNextChunk();
        } else {
          $('#result').html('Backup initiation failed: ' + response.message);
        }
      },
      error: function () {
        $('#result').html('An error occurred during backup initiation.');
      }
    });
  }

  backupNextChunk() {
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        action: 'backup_next_chunk',
        unique_prefix: this.backupUniquePrefix
      },
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          let data = response.data;

          if (data.status === 'completed') {
            $('#backupProgress').html('Backup completed successfully!');
            $('#restorePrefix').val(backupUniquePrefix);
            this.backupInProgress = false;
          } else {
            // Update progress
            $('#backupProgress').html(
                `Backing up table: ${data.table}<br>` +
                `Rows processed: ${data.rows_processed}`
            );

            // Continue backing up next chunk
            this.backupNextChunk();
          }
        } else {
          $('#result').html('Backup chunk failed: ' + response.message);
          this.backupInProgress = false;
        }
      },
      error: function() {
        $('#result').html('An error occurred during backup.');
        this.backupInProgress = false;
      }
    });
  }
}
