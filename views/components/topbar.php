<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'properties';
}

?>
<!-- Topbar -->
<div class="w-full border-b py-3 px-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800"><a href="?page=properties">Property Listing</a></h1>
    <div class="text-md">Listings: <span class="ml-2 font-semibold py-1 px-2 bg-blue-600 text-white rounded-lg" id="listingCount">0</span></div>
    <div>
        <!-- Dropdown -->
        <div class="dropdown">
            <button class="btn btn-lg btn-light flex items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-gear"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item <?= $page == 'properties' ? 'active' : '' ?>" href="?page=properties"><i class="fa fa-home me-2"></i> properties</a></li>
                <li><a class="dropdown-item <?= $page == 'agents' ? 'active' : '' ?>" href="?page=agents"><i class="fa fa-user-group me-2"></i> Agents</a></li>
                <li><a class="dropdown-item <?= $page == 'pf-locations' ? 'active' : '' ?>" href="?page=pf-locations"><i class="fa fa-map me-2"></i> PF Locations</a></li>
                <li><a class="dropdown-item <?= $page == 'bayut-locations' ? 'active' : '' ?>" href="?page=bayut-locations"><i class="fa fa-map-pin me-2"></i> Bayut Locations</a></li>
                <li><a class="dropdown-item <?= $page == 'developers' ? 'active' : '' ?>" href="?page=developers"><i class="fa fa-helmet-safety me-2"></i> Developers</a></li>
                <li><a class="dropdown-item <?= $page == 'history' ? 'active' : '' ?>" href="?page=history"><i class="fa fa-history me-2"></i> History</a></li>
                <li><a class="dropdown-item <?= $page == 'reports' ? 'active' : '' ?>" href="?page=reports"><i class="fa fa-chart-line me-2"></i> Reports</a></li>
                <!-- <li><a class="dropdown-item <?= $page == 'settings' ? 'active' : '' ?>" href="?page=settings"><i class="fa fa-cog me-2"></i> Settings</a></li> -->
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#"><i class="fa fa-sign-out-alt me-2"></i> Exit</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    async function getListingCount(page = 1) {
        const apiUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list?entityTypeId=1052&select[0]=id';

        const listngCount = document.getElementById('listingCount');

        try {
            const response = await fetch(apiUrl, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            listngCount.textContent = data.total || 0;
        } catch (error) {
            console.error('Error fetching properties:', error);
        }
    }

    getListingCount();
</script>