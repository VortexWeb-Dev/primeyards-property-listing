<div class="w-4/5 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Bayut Locations</h1>
        <button type="button" onclick="toggleModal(true)" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none">
            Add Location
        </button>
    </div>

    <!-- Loading -->
    <?php include_once('views/components/loading.php'); ?>

    <div id="location-table" class="flex flex-col hidden">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody id="location-list" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php include 'views/components/pagination.php'; ?>

    <!-- Modals -->
    <?php include 'views/modals/add-bayut-location.php'; ?>
</div>


<script>
    let currentPage = 1;
    const pageSize = 50;
    let totalPages = 0;

    async function fetchLocations(page = 1) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const entityTypeId = 1044;
        const apiUrl = `${baseUrl}/crm.item.list?entityTypeId=${entityTypeId}&order[id]=desc&select[0]=id&select[1]=ufCrm10Location&start=${(page - 1) * pageSize}`;

        const loading = document.getElementById('loading');
        const locationTable = document.getElementById('location-table');
        const locationList = document.getElementById('location-list');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        try {
            loading.classList.remove('hidden');
            locationTable.classList.add('hidden');
            pagination.classList.add('hidden');


            const response = await fetch(apiUrl, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            const locations = data.result?.items || [];
            const totalCount = data.total || 0;

            totalPages = Math.ceil(totalCount / pageSize);

            prevPage.disabled = page === 1;
            nextPage.disabled = page === totalPages || totalPages === 0;
            pageInfo.textContent = `Page ${page} of ${totalPages}`;

            locationList.innerHTML = locations
                .map(
                    (location) => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${location.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${location.ufCrm10Location || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                        <button onclick="deleteLocation(${location.id})" type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                    </td>
                </tr>`
                )
                .join('');

            return locations;
        } catch (error) {
            console.error('Error fetching locations:', error);
            return [];
        } finally {
            loading.classList.add('hidden');
            locationTable.classList.remove('hidden');
            pagination.classList.remove('hidden');

        }
    }

    function changePage(direction) {
        if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }
        fetchLocations(currentPage);
    }

    async function deleteLocation(locationId) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const apiUrl = `${baseUrl}/crm.item.delete?entityTypeId=1044&id=${locationId}`;

        try {
            if (confirm('Are you sure you want to delete this location?')) {
                await fetch(apiUrl, {
                    method: 'GET'
                });
                location.reload();
            }
        } catch (error) {
            console.error('Error deleting location:', error);
        }
    }

    fetchLocations(currentPage);
</script>