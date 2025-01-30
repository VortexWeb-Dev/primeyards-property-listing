<div class="bg-white shadow-md rounded-lg p-6 ">
    <h2 class="text-2xl font-semibold">Photos and Videos</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in all the required fields</p>

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : null;

    if ($page === 'edit-property') {
        include_once('views/components/edit-listing-image-shuffler.php');
    } else {
        include_once('views/components/create-listing-image-shuffler.php');
    } ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4">
        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="video_tour_url" class="block text-sm font-medium mb-2">Video Tour URL</label>
            <input type="url" id="video_tour_url" name="video_tour_url" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="360_view_url" class="block text-sm font-medium mb-2">360 View URL</label>
            <input type="url" id="360_view_url" name="360_view_url" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="qr_code_url" class="block text-sm font-medium mb-2">QR Code (Property Booster)</label>
            <input type="url" id="qr_code_url" name="qr_code_url" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
    </div>
</div>