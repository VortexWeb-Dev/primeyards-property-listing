<div class="text-center mb-3">
    <input type="file" class="d-none" id="documents" name="documents[]" accept="application/pdf" multiple>
    <label for="documents" class="dropzone d-block">
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
</div>

<input type="hidden" id="selectedDocuments" name="selectedDocuments" />
<input type="hidden" id="existingDocuments" name="existingDocuments" />

<label class="block text-sm font-medium mb-2">Existing Documents</label>
<div class="col-12">
    <div id="file-list" class="d-flex flex-column gap-2">

    </div>
</div>

<label class="block text-sm font-medium mb-2">New Documents</label>
<div class="col-12">
    <div id="new-file-list" class="d-flex flex-column gap-2">

    </div>
</div>

<!-- Modal for Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">File Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="filePreview" style="width: 100%; height: 500px;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>


<script>
    const fileInput = document.getElementById("documents");
    const fileList = document.getElementById("new-file-list");
    const oldFileList = document.getElementById("file-list");
    const documentsArray = []; // Array to keep track of files

    fileInput.addEventListener("change", () => {
        const newFiles = Array.from(fileInput.files); // Get newly selected files
        documentsArray.push(...newFiles); // Add them to the files array

        updateFileList(); // Refresh the displayed file list
    });

    function updateFileList() {
        fileList.innerHTML = ""; // Clear the list
        documentsArray.forEach((file, index) => {
            const fileRow = document.createElement("div");
            fileRow.className = "p-2 flex justify-between items-center bg-gray-100 border border-gray-300 rounded-lg mb-2";

            const fileName = document.createElement("div");
            fileName.innerHTML = `<i class="fas fa-file mr-2"></i> ${file.name}`;

            const actions = document.createElement("div");
            actions.innerHTML = `
            <button type="button" class="px-3 py-1 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition" onclick="previewFile(${index})">
                <i class="fas fa-eye"></i>
            </button>
            <button type="button" class="px-3 py-1 ml-2 text-sm font-medium text-green-600 border border-green-600 rounded hover:bg-green-600 hover:text-white transition" onclick="downloadFile(${index})">
                <i class="fas fa-download"></i>
            </button>
            <button type="button" class="px-3 py-1 ml-2 text-sm font-medium text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white transition" onclick="removeFile(${index})">
                <i class="fas fa-times"></i>
            </button>
        `;

            fileRow.appendChild(fileName);
            fileRow.appendChild(actions);
            fileList.appendChild(fileRow);
        });

        // Update the input's file list
        const dataTransfer = new DataTransfer();
        documentsArray.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function previewFile(index) {
        const file = documentsArray[index];
        if (file) {
            const fileURL = URL.createObjectURL(file);
            const previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
            document.getElementById("filePreview").src = fileURL;
            previewModal.show();
        }
    }

    function removeFile(index) {
        documentsArray.splice(index, 1); // Remove the file from the array
        updateFileList(); // Refresh the file list
    }

    function downloadFile(index) {
        const file = documentsArray[index];
        if (file) {
            const fileURL = URL.createObjectURL(file);
            const link = document.createElement("a");
            link.href = fileURL;
            link.download = file.name;
            link.click();
            URL.revokeObjectURL(fileURL);
        }
    }
</script>