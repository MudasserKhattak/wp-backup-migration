<div class="hidden create-backup-container fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 d-none">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Backup Name</h2>

        <div class="mb-4">
            <div class="flex items-center">
                <input type="radio" id="full-site" name="preset" class="mr-2" checked>
                <label for="full-site">Full Site</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="database-only" name="preset" class="mr-2">
                <label for="database-only">Database Only</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="media-only" name="preset" class="mr-2">
                <label for="media-only">Media Only</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="custom" name="preset" class="mr-2">
                <label for="custom">Custom</label>
            </div>
        </div>

        <div class="mb-4">
            <div class="flex items-center mb-2">
                <input type="checkbox" id="database" class="mr-2" checked>
                <label for="database">Database</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="themes" class="mr-2" checked>
                <label for="themes">Themes</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="core" class="mr-2" checked>
                <label for="core">Core</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="plugins" class="mr-2" checked>
                <label for="plugins">Plugins</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="only-active-plugins" class="mr-2">
                <label for="only-active-plugins">Only Active Plugins</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="media" class="mr-2" checked>
                <label for="media">Media</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="checkbox" id="other" class="mr-2" checked>
                <label for="other">Other</label>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="feature-button-primary text-white font-bold py-2 px-4 rounded mr-2">
                Create Backup
            </button>
            <button id="create-backup-btn-close" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                Cancel
            </button>
        </div>
    </div>
</div>
