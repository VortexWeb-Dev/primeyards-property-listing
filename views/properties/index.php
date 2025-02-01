<?php include 'views/components/index-buttons.php'; ?>

<div class="w-4/5 mx-auto mb-8 px-4">
    <!-- Loading -->
    <?php include_once('views/components/loading.php'); ?>

    <div id="property-table" class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 table-responsive">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 py-3 text-start">
                                    <label for="hs-at-with-checkboxes-main" class="flex">
                                        <input id="select-all" onclick="toggleCheckboxes(this)" type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-main">
                                        <span class="sr-only">Checkbox</span>
                                    </label>
                                </th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Actions</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Reference</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase max-w-[200px]">Property Details</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Unit Type</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Size</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Unit Status</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Location</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Listing Agent and Owner</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase min-w-[200px]">Published Portals</th>
                                <th scope="col" class="px-3 py-3 text-start text-xs font-medium text-gray-500 uppercase">Created On</th>
                            </tr>
                        </thead>
                        <tbody id="property-list" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php include 'views/components/pagination.php'; ?>

    <!-- Modals -->
    <?php include 'views/modals/filter.php'; ?>
    <?php include 'views/modals/refresh-listing.php'; ?>
    <?php
    if ($isAdmin) {
        include 'views/modals/transfer-to-agent.php';
        include 'views/modals/transfer-to-owner.php';
    }
    ?>
</div>


<script>
    let currentPage = 1;
    const pageSize = 50;
    let totalPages = 0;

    const isAdmin = localStorage.getItem('isAdmin') === 'true';

    async function fetchProperties(page = 1, filters = null) {
        const baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        const entityTypeId = 1052;
        const fields = [
            'id', 'ufCrm14ReferenceNumber', 'ufCrm14OfferingType', 'ufCrm14PropertyType', 'ufCrm14Price', 'ufCrm14TitleEn', 'ufCrm14DescriptionEn', 'ufCrm14Size', 'ufCrm14Bedroom', 'ufCrm14Bathroom', 'ufCrm14PhotoLinks', 'ufCrm14AgentName', 'ufCrm14City', 'ufCrm14Community', 'ufCrm14SubCommunity', 'ufCrm14Tower', 'ufCrm14PfEnable', 'ufCrm14BayutEnable', 'ufCrm14DubizzleEnable', 'ufCrm14WebsiteEnable', 'ufCrm14ListingOwner', 'ufCrm14Status', 'ufCrm14RentalPeriod', 'createdTime'
        ];
        const orderBy = {
            id: 'desc'
        };
        const start = (page - 1) * pageSize;

        function buildApiUrl(baseUrl, entityTypeId, fields, orderBy, start, filters) {
            const selectParams = fields.map((field, index) => `select[${index}]=${field}`).join('&');

            const orderParams = Object.entries(orderBy)
                .map(([key, value]) => `order[${key}]=${value}`)
                .join('&');

            if (filters) {
                const filterParams = Object.entries(filters)
                    .map(([key, value]) => `filter[${key}]=${value}`)
                    .join('&');

                return `${baseUrl}/crm.item.list?entityTypeId=${entityTypeId}&${selectParams}&${orderParams}&start=${start}&${filterParams}`;
            }

            return `${baseUrl}/crm.item.list?entityTypeId=${entityTypeId}&${selectParams}&${orderParams}&start=${start}`;
        }

        // Generate the API URL
        const apiUrl = buildApiUrl(baseUrl, entityTypeId, fields, orderBy, start, filters);

        const loading = document.getElementById('loading');
        const propertyTable = document.getElementById('property-table');
        const propertyList = document.getElementById('property-list');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        try {
            loading.classList.remove('hidden');
            propertyTable.classList.add('hidden');
            pagination.classList.add('hidden');


            const response = await fetch(apiUrl, {
                method: 'GET'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            const properties = data.result?.items || [];
            const totalCount = data.total || 0;

            totalPages = Math.ceil(totalCount / pageSize);

            prevPage.disabled = page === 1;
            nextPage.disabled = page === totalPages || totalPages === 0;
            pageInfo.textContent = `Page ${page} of ${totalPages}`;

            propertyList.innerHTML = properties
                .map(
                    (property) => `
                <tr>
                    <td class="size-sm whitespace-nowrap">
                        <div class="ps-6 py-3">
                            <label for="hs-at-with-checkboxes-1" class="flex">
                            <input type="checkbox" name="property_ids[]" value="${property.id}" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-1">
                            <span class="sr-only">Checkbox</span>
                            </label>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu shadow absolute z-10" style="max-height: 50vh; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #6B7280 #f9fafb; font-size:medium;">
                                <li><a class="dropdown-item" href="?page=edit-property&id=${property.id}"><i class="fa-solid fa-edit me-2"></i>Edit</a></li>
                                <li><a class="dropdown-item" href="?page=view-property&id=${property.id}"><i class="fa-solid fa-eye me-2"></i>View Details</a></li>
                                <li><button class="dropdown-item" onclick="handleAction('duplicate', ${property.id})"><i class="fa-solid fa-copy me-2"></i>Duplicate Listing</button></li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#referenceModal" data-property-id="${property.id}" data-reference="${property.ufCrm14ReferenceNumber}">
                                        <i class="fa-solid fa-sync me-2"></i>Refresh Listing
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" target="_blank" href="download-pdf.php?type=logged&id=${property.id}"><i class="fa-solid fa-print me-2"></i>Download PDF as Logged-In Agent</a></li>
                                <li><a class="dropdown-item" target="_blank" href="download-pdf.php?type=agent&id=${property.id}"><i class="fa-solid fa-print me-2"></i>Download PDF as Listing Agent</a></li>
                                <li><a class="dropdown-item" target="_blank" href="download-pdf.php?type=owner&id=${property.id}"><i class="fa-solid fa-print me-2"></i>Download PDF as Listing Owner</a></li>
                                ${isAdmin ? `
                                <li><hr class="dropdown-divider"></li>
                                <li><button class="dropdown-item" onclick="handleAction('publish', ${property.id})"><i class="fa-solid fa-bullhorn me-2"></i>Publish to all</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('publish', ${property.id}, 'pf')"><i class="fa-solid fa-search me-2"></i>Publish to PF</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('publish', ${property.id}, 'bayut')"><i class="fa-solid fa-building me-2"></i>Publish to Bayut</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('publish', ${property.id}, 'dubizzle')"><i class="fa-solid fa-home me-2"></i>Publish to Dubizzle</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('publish', ${property.id}, 'website')"><i class="fa-solid fa-globe me-2"></i>Publish to Website</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><button class="dropdown-item" onclick="handleAction('unpublish', ${property.id})"><i class="fa-solid fa-archive me-2"></i>Unpublish from all</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('unpublish', ${property.id}, 'pf')"><i class="fa-solid fa-search me-2"></i>Unpublish from PF</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('unpublish', ${property.id}, 'bayut')"><i class="fa-solid fa-building me-2"></i>Unpublish from Bayut</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('unpublish', ${property.id}, 'dubizzle')"><i class="fa-solid fa-home me-2"></i>Unpublish from Dubizzle</button></li>
                                <li><button class="dropdown-item" onclick="handleAction('unpublish', ${property.id}, 'website')"><i class="fa-solid fa-globe me-2"></i>Unpublish from Website</button></li>
                                ` : ''}
                                <li><hr class="dropdown-divider"></li>
                                <li><button class="dropdown-item text-danger" onclick="handleAction('archive', ${property.id})"><i class="fa-solid fa-archive me-2"></i>Archive</button></li>
                                <li><button class="dropdown-item text-danger" onclick="handleAction('delete', ${property.id})"><i class="fa-solid fa-trash me-2"></i>Delete</button></li>
                            </ul>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800 text-wrap">${property.ufCrm14ReferenceNumber || 'N/A'}</td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <div class="flex">
                            <img class="w-20 h-20 rounded object-cover mr-4" src="${property.ufCrm14PhotoLinks[0] || 'https://via.placeholder.com/150'}" alt="${property.ufCrm14TitleEn || 'N/A'}">
                            <div class="text-sm">
                                <p class="text-gray-800 font-semibold">${property.ufCrm14TitleEn || 'N/A'}</p>
                                <p class="text-gray-400 text-wrap max-w-full truncate">${property.ufCrm14DescriptionEn.slice(0, 60) + '...' || 'N/A'}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <div class="flex flex-col items-start gap-1">
                            <span class="text-sm text-muted" title="Bathrooms"><i class="fa-solid fa-bath mr-1"></i>${property.ufCrm14Bathroom || 'N/A'}</span>
                            <span class="text-sm text-muted" title="Bedrooms"><i class="fa-solid fa-bed mr-1"></i>${property.ufCrm14Bedroom === 0 ? 'Studio' : property.ufCrm14Bedroom === 11 ? '10+' : property.ufCrm14Bedroom || 'N/A'}</span>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <div class="flex flex-col items-start gap-1">
                            <span class="text-sm text-muted" title="Bathrooms"><i class="fa-solid fa-ruler-combined mr-1"></i>${property.ufCrm14Size + ' sqft' || 'N/A'}</span>
                            <span class="text-sm text-muted" title="Bedrooms"><i class="fa-solid fa-ruler-horizontal mr-1"></i>${sqftToSqm(property.ufCrm14Size) + ' sqm' || 'N/A'}</span>
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        ${
                            property.ufCrm14Price 
                                ? `${formatPrice(property.ufCrm14Price)}${property.ufCrm14OfferingType === 'RR' || property.ufCrm14OfferingType === 'CR' 
                                    ? `/${property.ufCrm14RentalPeriod === 'Y' ? 'Year' : property.ufCrm14RentalPeriod === 'M' ? 'Month' : property.ufCrm14RentalPeriod === 'W' ? 'Week' : property.ufCrm14RentalPeriod === 'D' ? 'Day' : ''} - Rent`
                                    : (property.ufCrm14OfferingType === 'CS' || property.ufCrm14OfferingType === 'RS' ? ' - Sale' : '')}`
                                : ''
                        }
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        ${getStatusBadge(property.ufCrm14Status)}
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <p>
                            ${[
                                property.ufCrm14City,
                                property.ufCrm14Community,
                            ]
                            .filter(Boolean)
                            .join(' - ') || ''}
                        </p>
                        <p>
                            ${[
                                property.ufCrm14SubCommunity,
                                property.ufCrm14Tower
                            ]
                            .filter(Boolean)
                            .join(' - ') || ''}
                        </p>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <p class="">${property.ufCrm14AgentName || ''}</p> 
                        <p class="">${property.ufCrm14ListingOwner || ''}</p> 
                    </td>
                   <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <div class="flex gap-1">
                            ${property.ufCrm14PfEnable === "Y" ? '<img class="w-8 h-8 rounded-full object-cover" src="assets/images/pf.png" alt="Property Finder" title="Property Finder">' : ''}
                            ${property.ufCrm14BayutEnable === "Y" ? '<img class="w-8 h-8 rounded-full object-cover" src="assets/images/bayut.png" alt="Bayut" title="Bayut">' : ''}
                            ${property.ufCrm14DubizzleEnable === "Y" ? '<img class="w-8 h-8 rounded-full object-cover" src="assets/images/dubizzle.png" alt="Dubizzle" title="Dubizzle">' : ''}
                            ${property.ufCrm14WebsiteEnable === "Y" ? '<img class="w-8 h-8 rounded-full object-cover" src="assets/images/company-logo.webp" alt="Prime Yards" title="Prime Yards">' : ''}
                        </div>
                    </td>
                    <td class="px-3 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                        <p class="">${formatDate(property.createdTime) || ''}</p> 
                    </td>

                </tr>`
                )
                .join('');

            return properties;
        } catch (error) {
            console.error('Error fetching properties:', error);
            return [];
        } finally {
            loading.classList.add('hidden');
            propertyTable.classList.remove('hidden');
            pagination.classList.remove('hidden');

        }
    }

    function changePage(direction) {
        if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }
        fetchProperties(currentPage);
    }

    function toggleCheckboxes(source) {
        const checkboxes = document.querySelectorAll('input[name="property_ids[]"]');

        checkboxes.forEach((checkbox) => {
            checkbox.checked = source.checked;
        });
    }

    function formatPrice(amount, locale = 'en-US', currency = 'AED') {
        if (isNaN(amount)) {
            return 'Invalid amount';
        }

        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
    }

    function getStatusBadge(status) {
        switch (status) {
            case 'PUBLISHED':
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-green-50 text-green-800">Published</span>';
            case 'UNPUBLISHED':
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-red-50 text-red-800">Unpublished</span>';
            case 'LIVE':
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-blue-50 text-blue-800">Live</span>';
            case 'DRAFT':
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-gray-50 text-gray-800">Draft</span>';
            case 'ARCHIVED':
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-gray-50 text-gray-800">Archived</span>';
            default:
                return '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-2 border rounded-full text-xs font-medium bg-gray-50 text-gray-800">' + status + '</span>';
        }
    }

    fetchProperties(currentPage);
</script>