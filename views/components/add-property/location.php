<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold">Location</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in all the required fields</p>
    <div class="grid grid-cols-2 gap-6 my-4">
        <!-- Property Finder Column -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Property Finder</h3>
            <div class="mb-4">
                <label for="pf_location" class="block text-sm font-medium mb-2">Location <span class="text-danger">*</span></label>
                <input type="text" id="pf_location" name="pf_location" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search for a location">
                <?php include './views/modals/search-pf-location-popup.php' ?>

            </div>
            <div class="flex justify-between w-[100%] gap-4">
                <div>
                    <label for="pf_city" class="block text-sm font-medium mb-2">City</label>
                    <input type="text" id="pf_city" name="pf_city" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="pf_community" class="block text-sm font-medium mb-2">Community</label>
                    <input type="text" id="pf_community" name="pf_community" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="pf_subcommunity" class="block text-sm font-medium mb-2">Sub Community</label>
                    <input type="text" id="pf_subcommunity" name="pf_subcommunity" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="pf_building" class="block text-sm font-medium mb-2">Building/Tower</label>
                    <input type="text" id="pf_building" name="pf_building" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
            </div>
        </div>

        <!-- Bayut Column -->
        <div>
            <h3 class="text-lg font-semibold mb-3">Bayut</h3>
            <div class="mb-4">
                <label for="bayut_location" class="block text-sm font-medium mb-2">Location</label>
                <input type="text" id="bayut_location" name="bayut_location" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search for a location">
                <?php include './views/modals/search-bayut-location-popup.php' ?>
            </div>
            <div class="flex justify-between w-[100%] gap-4">
                <div>
                    <label for="bayut_city" class="block text-sm font-medium mb-2">City</label>
                    <input type="text" id="bayut_city" name="bayut_city" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="bayut_community" class="block text-sm font-medium mb-2">Community</label>
                    <input type="text" id="bayut_community" name="bayut_community" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="bayut_subcommunity" class="block text-sm font-medium mb-2">Sub Community</label>
                    <input type="text" id="bayut_subcommunity" name="bayut_subcommunity" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
                <div>
                    <label for="bayut_building" class="block text-sm font-medium mb-2">Building/Tower</label>
                    <input type="text" id="bayut_building" name="bayut_building" readonly class="py-3 px-4 block w-full border-gray-300 rounded-lg text-sm bg-gray-100 cursor-not-allowed">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4">
            <!-- Column 1 -->
            <div class="max-w-sm">
                <label for="latitude" class="block text-sm font-medium mb-2">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            </div>

            <!-- Column 2 -->
            <div class="max-w-sm">
                <label for="longitude" class="block text-sm font-medium mb-2">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            </div>
        </div>
    </div>
</div>