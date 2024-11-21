import BackupManager from './partials/backup-manager.js';

console.log('admin-script.js loaded');
document.addEventListener('DOMContentLoaded', () => {
  new BackupManager();
});
