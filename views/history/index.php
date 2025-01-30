<div class="w-4/5 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">History</h1>
    </div>

    <!-- Loading -->
    <?php include_once('views/components/loading.php'); ?>

    <div id="record-table" class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Entity</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Entity Name</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Action</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Changed By ID</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Changed By Name</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Note</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody id="record-list" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php include 'views/components/pagination.php'; ?>
</div>


<script>
    let currentPage = 1;
    const pageSize = 50;
    let totalPages = 0;

    async function fetchRecords(page = 1) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const entityTypeId = 1108;
        const apiUrl = `${baseUrl}/crm.item.list?entityTypeId=${entityTypeId}&order[id]=desc&select[0]=id&select[1]=ufCrm27Entity&select[2]=ufCrm27Item&select[3]=ufCrm27EntityName&select[4]=ufCrm27Action&select[5]=ufCrm27ChangedBy&select[6]=ufCrm27ChangedByName&select[7]=createdTime&select[8]=ufCrm27Note&start=${(page - 1) * pageSize}`;

        const loading = document.getElementById('loading');
        const recordTable = document.getElementById('record-table');
        const recordList = document.getElementById('record-list');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        try {
            loading.classList.remove('hidden');
            recordTable.classList.add('hidden');
            pagination.classList.add('hidden');


            const response = await fetch(apiUrl, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            const records = data.result?.items || [];
            const totalCount = data.total || 0;

            totalPages = Math.ceil(totalCount / pageSize);

            prevPage.disabled = page === 1;
            nextPage.disabled = page === totalPages || totalPages === 0;
            pageInfo.textContent = `Page ${page} of ${totalPages}`;

            recordList.innerHTML = records
                .map(
                    (record) => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${record.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${record.ufCrm27Entity || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><a href="https://primeyards.bitrix24.com/crm/type/${record.ufCrm27Entity}/details/${record.ufCrm27Item}/" target="_blank">${record.ufCrm27Item || 'N/A'}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${record.ufCrm27EntityName || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${historyActionMapping[record.ufCrm27Action] || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><a href="https://primeyards.bitrix24.com/company/personal/user/${record.ufCrm27ChangedBy}/" target="_blank">${record.ufCrm27ChangedBy || 'N/A'}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${record.ufCrm27ChangedByName || 'N/A'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-800">${record.ufCrm27Note || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${formatDateTime(record.createdTime) || 'N/A'}</td>
                </tr>`
                )
                .join('');

            return records;
        } catch (error) {
            console.error('Error fetching records:', error);
            return [];
        } finally {
            loading.classList.add('hidden');
            recordTable.classList.remove('hidden');
            pagination.classList.remove('hidden');

        }
    }

    function changePage(direction) {
        if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }
        fetchRecords(currentPage);
    }

    fetchRecords(currentPage);
</script>