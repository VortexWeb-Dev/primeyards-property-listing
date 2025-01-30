<!-- Add Developer Modal -->
<div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Add New Developer</h3>

        <form id="addDeveloperForm" onsubmit="handleAddDeveloper(event)">
            <div class="mb-4">
                <label for="developerName" class="block text-sm font-semibold text-gray-800">Name</label>
                <input type="text" id="developerName" name="developerName" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:border-blue-500" placeholder="John Doe">
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
                    Add Developer
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

    function handleAddDeveloper(e) {
        e.preventDefault();

        const form = document.getElementById('addDeveloperForm');
        const formData = new FormData(form);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const fields = {
            "ufCrm6DeveloperName": data.developerName.trim(),
        };

        addItem(1036, fields);
    }
</script>