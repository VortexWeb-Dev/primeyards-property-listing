<!-- Add PfLocation Modal -->
<div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Add PF Location</h3>

        <form id="addPfLocationForm" onsubmit="handleAddLocation(event)">
            <div class="mb-4">
                <label for="city" class="block text-sm font-semibold text-gray-800">City <span class="text-danger">*</span></label>
                <input oninput="updateLocation()" type="text" id="city" name="city" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:border-blue-500" placeholder="City">
            </div>
            <div class="mb-4">
                <label for="community" class="block text-sm font-semibold text-gray-800">Community</label>
                <input oninput="updateLocation()" type="text" id="community" name="community" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:border-blue-500" placeholder="Community">
            </div>
            <div class="mb-4">
                <label for="subCommunity" class="block text-sm font-semibold text-gray-800">Sub Community</label>
                <input oninput="updateLocation()" type="text" id="subCommunity" name="subCommunity" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:border-blue-500" placeholder="Sub Community">
            </div>
            <div class="mb-4">
                <label for="building" class="block text-sm font-semibold text-gray-800">Building/Tower</label>
                <input oninput="updateLocation()" type="text" id="building" name="building" class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:border-blue-500" placeholder="Building/Tower">
            </div>
            <div class="mb-4">
                <label for="location" class="block text-sm font-semibold text-gray-800">Location</label>
                <input type="text" id="location" name="location" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none" placeholder="City - Community - Sub Community - Building/Tower" readonly>
            </div>

            <div class="flex justify-end space-x-2">
                <button
                    type="button"
                    onclick="toggleModal(false)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Add PF Location
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateLocation() {
        const city = document.getElementById("city").value.trim();
        const community = document.getElementById("community").value.trim();
        const subCommunity = document.getElementById("subCommunity").value.trim();
        const building = document.getElementById("building").value.trim();

        const locationInput = document.getElementById("location");
        const parts = [city, community, subCommunity, building].filter(part => part);

        locationInput.value = parts.join(" - ");
    }

    async function addItem(entityTypeId, fields) {
        try {
            const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.add?entityTypeId=${entityTypeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    fields,
                }),
            });

            if (response.ok) {
                toggleModal(false);
                location.reload();
            } else {
                console.error('Failed to add item');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function handleAddLocation(e) {
        e.preventDefault();

        const form = document.getElementById('addPfLocationForm');
        const formData = new FormData(form);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const locationParts = data.location.split('-');

        if (locationParts.length < 3) {
            alert('Please enter a valid location format (City - Community - Sub Community - Building/Tower)');
            return;
        }

        data.city = data.city.trim();
        data.community = data.community.trim();
        data.subCommunity = data.subCommunity.trim();
        data.building = data.building.trim();

        const fields = {
            "ufCrm12Location": data.location,
            "ufCrm12City": data.city,
            "ufCrm12Community": data.community,
            "ufCrm12SubCommunity": data.subCommunity,
            "ufCrm12Building": data.building,
        };

        addItem(1048, fields);
    }
</script>