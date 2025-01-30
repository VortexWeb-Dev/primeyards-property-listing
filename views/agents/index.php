<div class="w-4/5 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Agents</h1>
        <button type="button" onclick="toggleModal(true)" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none ">
            Add Agent
        </button>
    </div>

    <!-- Loading -->
    <?php include_once('views/components/loading.php'); ?>

    <div id="agent-table" class="flex flex-col hidden">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Mobile</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">License</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody id="agent-list" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php include 'views/components/pagination.php'; ?>

    <!-- Modals -->
    <?php include 'views/modals/add-agent.php'; ?>
</div>


<script>
    let currentPage = 1;
    const pageSize = 50;
    let totalPages = 0;

    async function fetchAgents(page = 1) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const entityTypeId = 1040;
        const apiUrl = `${baseUrl}/crm.item.list?entityTypeId=${entityTypeId}&order[id]=desc&select[0]=id&select[1]=ufCrm8AgentName&select[2]=ufCrm8AgentEmail&select[3]=ufCrm8AgentMobile&select[4]=ufCrm8AgentLicense&select[5]=ufCrm8AgentPhoto&start=${(page - 1) * pageSize}`;

        const loading = document.getElementById('loading');
        const agentTable = document.getElementById('agent-table');
        const agentList = document.getElementById('agent-list');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        try {
            loading.classList.remove('hidden');
            agentTable.classList.add('hidden');
            pagination.classList.add('hidden');


            const response = await fetch(apiUrl, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            const agents = data.result?.items || [];
            const totalCount = data.total || 0;

            totalPages = Math.ceil(totalCount / pageSize);

            prevPage.disabled = page === 1;
            nextPage.disabled = page === totalPages || totalPages === 0;
            pageInfo.textContent = `Page ${page} of ${totalPages}`;

            agentList.innerHTML = agents
                .map(
                    (agent) => `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${agent.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 flex items-center space-x-2">
                        <img 
                            class="w-10 h-10 object-cover rounded-full" 
                            src="${agent.ufCrm8AgentPhoto || './assets/images/agent-placeholder.webp'}" 
                            alt="${agent.ufCrm8AgentName || 'Agent'}" />
                        <span>${agent.ufCrm8AgentName || 'Agent'}</span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${agent.ufCrm8AgentEmail.toLowerCase() || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${agent.ufCrm8AgentMobile || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">${agent.ufCrm8AgentLicense || ''}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                        <button onclick="deleteAgent(${agent.id})" type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Delete</button>
                    </td>
                </tr>`
                )
                .join('');

            return agents;
        } catch (error) {
            console.error('Error fetching agents:', error);
            return [];
        } finally {
            loading.classList.add('hidden');
            agentTable.classList.remove('hidden');
            pagination.classList.remove('hidden');

        }
    }

    function changePage(direction) {
        if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }
        fetchAgents(currentPage);
    }

    async function deleteAgent(agentId) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const apiUrl = `${baseUrl}/crm.item.delete?entityTypeId=1040&id=${agentId}`;

        try {
            if (confirm('Are you sure you want to delete this agent?')) {
                await fetch(apiUrl, {
                    method: 'GET'
                });
                location.reload();
            }
        } catch (error) {
            console.error('Error deleting agent:', error);
        }
    }

    fetchAgents(currentPage);
</script>