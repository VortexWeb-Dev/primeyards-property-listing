<div class="text-center mb-3">
    <input type="file" class="d-none" id="floorplan" name="floorplan" accept="image/*">
    <label for="floorplan" class="dropzone d-block">
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
<div id="floorplanPreviewContainer" class="floorplanPreviewContainer"></div>
<input type="hidden" id="selectedFloorplan" name="selectedFloorplan" />


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let floorplanLink = [];
        let selectedFiles = [];
        const previewContainer = document.getElementById('floorplanPreviewContainer');
        const selectedFloorplanInput = document.getElementById('selectedFloorplan');

        function addSwapy() {
            const swapy = Swapy.createSwapy(previewContainer, {
                animation: 'dynamic',
                swapMode: 'drop'
            });

            swapy.onSwap((event) => {});

            swapy.onSwapStart(() => {});

            swapy.onSwapEnd((event) => {

                floorplanLink = [];

                event.data.map.forEach((item, index) => {
                    let element = document.querySelector(`[data-swapy-item="${item}"]`);
                    floorplanLink.push(element.querySelector('img').src);
                });


                updateSelectedImagesInput();
            });
        }

        document.getElementById("floorplan").addEventListener("change", function(event) {
            const files = Array.from(event.target.files);
            selectedFiles = [];

            files.forEach((file) => {
                if (file.size >= 10 * 1024 * 1024) {
                    // alert(`The file "${file.name}" is too large (10MB or greater). Please select a smaller file.`);
                    document.getElementById("floorplanMessage").classList.remove('hidden');
                    document.getElementById("floorplanMessage").textContent = `The file "${file.name}" is too large (10MB or greater). Please select a smaller file.`;
                } else if (!selectedFiles.some((f) => f.name === file.name)) {
                    selectedFiles.push(file);
                    document.getElementById("floorplanMessage").classList.add('hidden');
                }
            });

            updatePhotoPreview();
        });


        function updatePhotoPreview() {
            const promises = selectedFiles.map((file) => {
                return new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(e) {
                        floorplanLink.push(e.target.result);
                        resolve();
                    };
                });
            });

            Promise.all(promises).then(() => {
                previewImages(floorplanLink);
            });
        }

        function previewImages(floorplanLink) {
            const numImageLinks = floorplanLink.length;
            previewContainer.innerHTML = "";

            let row = document.createElement('div');
            row.classList.add('shuffle-row');

            for (let i = 0; i < numImageLinks; i++) {
                if (i % 3 === 0 && i !== 0) {
                    previewContainer.appendChild(row);
                    row = document.createElement('div');
                    row.classList.add('shuffle-row');
                }

                const slot = document.createElement('div');
                slot.classList.add('slot');
                slot.setAttribute('data-swapy-slot', i + 1);

                const item = document.createElement('div');
                item.classList.add('item');
                item.setAttribute('data-swapy-item', String.fromCharCode(97 + i));

                const image = document.createElement('div');
                const img = document.createElement('img');
                img.src = floorplanLink[i];

                image.appendChild(img);
                item.appendChild(image);
                slot.appendChild(item);

                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "&times;";
                removeBtn.classList.add("position-absolute", "top-0", "end-0", "btn", "btn-sm", "btn-danger", "m-1");
                removeBtn.style.zIndex = "1";
                removeBtn.onclick = function() {
                    selectedFiles.splice(i, 1);
                    floorplanLink.splice(i, 1);

                    previewImages(floorplanLink);

                };

                item.appendChild(removeBtn);

                row.appendChild(slot);
            }

            previewContainer.appendChild(row);
            addSwapy();

            updateSelectedImagesInput();
        }

        function updateSelectedImagesInput() {
            selectedFloorplanInput.value = JSON.stringify(floorplanLink);
        }
    });
</script>