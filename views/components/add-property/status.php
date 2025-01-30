<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Publishing Status</h2>

    <div class="my-4 flex flex-col gap-3">
        <!-- Publish Option -->
        <div class="admin-only border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="PUBLISHED" id="publish-option">
            <input type="radio" name="status" value="PUBLISHED" id="publish" class="peer ">
            <label for="publish" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Publish
            </label>
        </div>

        <!-- Unpublish Option -->
        <div class="border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="UNPUBLISHED" id="unpublish-option">
            <input type="radio" name="status" value="UNPUBLISHED" id="unpublish" class="peer ">
            <label for="unpublish" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Unpublish
            </label>
        </div>

        <!-- Live Option -->
        <div class="border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="LIVE" id="live-option">
            <input type="radio" name="status" value="LIVE" id="live" class="peer">
            <label for="live" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Live
            </label>
        </div>

        <!-- Draft Option -->
        <div class="border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="DRAFT" id="draft-option">
            <input type="radio" name="status" value="DRAFT" id="draft" class="peer">
            <label for="draft" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Save as Draft
            </label>
        </div>

        <!-- Archive Option -->
        <div class="border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="ARCHIVED" id="archive-option">
            <input type="radio" name="status" value="ARCHIVED" id="archive" class="peer">
            <label for="archive" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Archived
            </label>
        </div>

        <!-- Pocket Option -->
        <div class="border border-gray-300 p-4 rounded-md cursor-pointer transition-colors hover:bg-blue-50 flex gap-2 items-center"
            data-status-value="POCKET" id="pocket-option">
            <input type="radio" name="status" value="POCKET" id="pocket" class="peer">
            <label for="pocket" class="text-md text-gray-500 peer-checked:text-blue-600 peer-checked:border-transparent transition-all w-full flex items-center justify-between">
                Save as Pocket Listing
            </label>
        </div>
    </div>
</div>