<div class="create-backup-container hidden fixed z-50 inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white shadow-lg rounded-lg w-11/12 max-w-lg">
        <div class="px-6 py-5">
            <div class="mb-4">
                <label for="backupName" class="block text-gray-700 text-sm font-bold mb-2">Backup Name</label>
                <input type="text" id="backupName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter a name for your backup">
            </div>
            <div class="flex flex-wrap -mx-2 mb-4">
                <button id="fullSiteBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mx-2 my-1">Full Site</button>
                <button id="databaseOnlyBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mx-2 my-1">Database Only</button>
                <button id="mediaOnlyBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mx-2 my-1">Media Only</button>
                <button id="customBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mx-2 my-1">Custom</button>
            </div>
            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" id="databaseCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Database</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="coreCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Core</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="pluginsCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Plugins</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="onlyActivePluginsCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <span class="text-gray-700">Only Active Plugins</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="mediaCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Media</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="themesCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Themes</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="onlyActiveThemesCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <span class="text-gray-700">Only Active Themes</span>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="otherCheckbox" class="mr-3 w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" checked>
                    <span class="text-gray-700">Other</span>
                </div>
            </div>
            <div class="flex justify-end">
                <button class="backup-button feature-button-primary text-white font-bold py-2 px-4 rounded mr-2">
                    Create Backup
                </button>
                <button id="create-backup-btn-close" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
