import BackupManager from './partials/backup-manager';

console.log('admin-script.js loaded');
document.addEventListener('DOMContentLoaded', () => {
  const createBackup = document.querySelector('#add-new-backup-btn');
  console.log(createBackup);
  createBackup.addEventListener('click', () => {
    console.log('clicked');
    new BackupManager();
  });
});
