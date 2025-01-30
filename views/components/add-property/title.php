<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold">Title and Description</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in all the required fields</p>
    <div class="grid grid-cols-1 gap-6 my-4">
        <!-- Column 1 -->
        <div>
            <label for="title_en" class="block text-sm font-medium mb-2">Title (English) <span class="text-danger">*</span></label>
            <input type="text" id="title_en" name="title_en" maxlength="50" oninput="updateCharCount('titleEnCount', this.value.length, 50);" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
            <small class="text-xs text-gray-500"><span id="titleEnCount">0</span> / 50 characters</small>
        </div>

        <!-- Column 1 -->
        <div>
            <label for="description_en" class="block text-sm font-medium mb-2">Description (English) <span class="text-danger">*</span></label>
            <textarea id="description_en" name="description_en" maxlength="1500" oninput="updateCharCount('descriptionEnCount', this.value.length, 1500);" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="15" required></textarea>
            <small class="text-xs text-gray-500"><span id="descriptionEnCount">0</span> / 1500 characters</small>
        </div>

        <!-- Column 1 -->
        <div>
            <label for="title_ar" class="block text-sm font-medium mb-2">Title (Arabic)</label>
            <input type="text" id="title_ar" name="title_ar" maxlength="50" oninput="updateCharCount('titleArCount', this.value.length, 50);" lang="ar" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            <small class="text-xs text-gray-500"><span id="titleArCount">0</span> / 50 characters</small>
        </div>

        <!-- Column 1 -->
        <div>
            <label for="description_ar" class="block text-sm font-medium mb-2">Description (Arabic)</label>
            <textarea id="description_ar" name="description_ar" maxlength="1500" oninput="updateCharCount('descriptionArCount', this.value.length, 1500);" lang="ar" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="15"></textarea>
            <small class="text-xs text-gray-500"><span id="descriptionArCount">0</span> / 1500 characters</small>
        </div>

        <!-- Column 1 -->
        <div>
            <label for="brochure_description_1" class="block text-sm font-medium mb-2">Description for Brochure (1)</label>
            <textarea id="brochure_description_1" name="brochure_description_1" maxlength="200" oninput="updateCharCount('brochureDescription1Count', this.value.length, 200);" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="7"></textarea>
            <small class="text-xs text-gray-500"><span id="brochureDescription1Count">0</span> / 200 characters</small>
        </div>

        <!-- Column 1 -->
        <div>
            <label for="brochure_description_2" class="block text-sm font-medium mb-2">Description for Brochure (2)</label>
            <textarea id="brochure_description_2" name="brochure_description_2" maxlength="190" oninput="updateCharCount('brochureDescription2Count', this.value.length, 190);" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" rows="7"></textarea>
            <small class="text-xs text-gray-500"><span id="brochureDescription2Count">0</span> / 190 characters</small>
        </div>

    </div>
</div>