<div class="text-center mb-3">
    <input type="file" class="d-none" id="floorplan" name="floorplan" accept="image/*">
    <label for="floorplan" class="dropzone p-4 d-block">
        <div class="cursor-pointer p-12 flex justify-center bg-white border border-gray-300 rounded-xl" data-hs-file-upload-trigger="">
            <div class="text-center">
                <span class="inline-flex justify-center items-center size-16 bg-gray-100 text-gray-800 rounded-full">
                    <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                    </svg>
                </span>

                <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
                    <span class="pe-1 font-medium text-gray-800">
                        Drop your file here or
                    </span>
                    <span class="bg-white font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">browse</span>
                </div>

                <p class="mt-1 text-xs text-gray-400">
                    Pick a file up to 10MB.
                </p>
            </div>
        </div>
    </label>
    <p class="text-left text-xs text-red-500 font-semibold mt-2 hidden" id="floorplanMessage"></p>
</div>

<input type="hidden" id="selectedFloorplan" name="selectedFloorplan" />
<input type="hidden" id="existingFloorplan" name="existingFloorplan" />

<label class="block text-sm font-medium mb-2">New Floor Plan</label>
<div id="newFloorplanPreviewContainer" class="floorplanPreviewContainer mb-4">
</div>

<label class="block text-sm font-medium mb-2">Existing Floor Plan</label>
<div id="existingFloorplanPreviewContainer" class="floorplanPreviewContainer mb-4">
</div>