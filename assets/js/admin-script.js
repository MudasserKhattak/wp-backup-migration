document.addEventListener('DOMContentLoaded', () => {
  console.log("Admin script loaded");
  const featureButton = document.querySelector('#add-new-backup-btn');
  const createBackupContainer = document.querySelector('.create-backup-container');
  const closeButton = document.querySelector('#create-backup-btn-close');

  featureButton.addEventListener('click', () => {
    createBackupContainer.classList.remove('hidden');
  });

  closeButton.addEventListener('click', () => {
    createBackupContainer.classList.add('hidden');
  });

  const fullSiteBtn = document.getElementById('fullSiteBtn');
  const databaseOnlyBtn = document.getElementById('databaseOnlyBtn');
  const mediaOnlyBtn = document.getElementById('mediaOnlyBtn');
  const customBtn = document.getElementById('customBtn');

  const databaseCheckbox = document.getElementById('databaseCheckbox');
  const coreCheckbox = document.getElementById('coreCheckbox');
  const pluginsCheckbox = document.getElementById('pluginsCheckbox');
  const onlyActivePluginsCheckbox = document.getElementById('onlyActivePluginsCheckbox');
  const mediaCheckbox = document.getElementById('mediaCheckbox');
  const themesCheckbox = document.getElementById('themesCheckbox');
  const onlyActiveThemesCheckbox = document.getElementById('onlyActiveThemesCheckbox');
  const otherCheckbox = document.getElementById('otherCheckbox');

  fullSiteBtn.addEventListener('click', () => {
    databaseCheckbox.checked = true;
    coreCheckbox.checked = true;
    pluginsCheckbox.checked = true;
    onlyActivePluginsCheckbox.checked = false;
    mediaCheckbox.checked = true;
    themesCheckbox.checked = true;
    onlyActiveThemesCheckbox.checked = false;
    otherCheckbox.checked = true;
  });

  databaseOnlyBtn.addEventListener('click', () => {
    databaseCheckbox.checked = true;
    coreCheckbox.checked = false;
    pluginsCheckbox.checked = false;
    onlyActivePluginsCheckbox.checked = false;
    mediaCheckbox.checked = false;
    themesCheckbox.checked = false;
    onlyActiveThemesCheckbox.checked = false;
    otherCheckbox.checked = false;
  });

  mediaOnlyBtn.addEventListener('click', () => {
    databaseCheckbox.checked = false;
    coreCheckbox.checked = false;
    pluginsCheckbox.checked = false;
    onlyActivePluginsCheckbox.checked = false;
    mediaCheckbox.checked = true;
    themesCheckbox.checked = false;
    onlyActiveThemesCheckbox.checked = false;
    otherCheckbox.checked = false;
  });

  customBtn.addEventListener('click', () => {
    databaseCheckbox.checked = true;
    coreCheckbox.checked = false;
    pluginsCheckbox.checked = true;
    onlyActivePluginsCheckbox.checked = true;
    mediaCheckbox.checked = true;
    themesCheckbox.checked = false;
    onlyActiveThemesCheckbox.checked = true;
    otherCheckbox.checked = false;
  });
});
