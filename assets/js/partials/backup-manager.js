export default class BackupManager {
  constructor() {
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
}
