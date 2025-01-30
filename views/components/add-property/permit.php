<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold">Property Permit</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in any of the permit details</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4">
        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="rera_permit_number" class="block text-sm font-medium mb-2">RERA Permit Number <span class="text-danger">*</span></label>
            <input type="text" id="rera_permit_number" name="rera_permit_number" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="rera_issue_date" class="block text-sm font-medium mb-2">RERA Permit Issue Date</label>
            <input type="date" id="rera_issue_date" name="rera_issue_date" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="rera_expiration_date" class="block text-sm font-medium mb-2">RERA Permit Expiration Date</label>
            <input type="date" id="rera_expiration_date" name="rera_expiration_date" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="dtcm_permit_number" class="block text-sm font-medium mb-2">DTCM Permit Number</label>
            <input type="text" id="dtcm_permit_number" name="dtcm_permit_number" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>

    </div>
</div>