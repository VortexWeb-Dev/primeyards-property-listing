<div id="locationPopup" class="absolute mt-2 p-2 bg-white shadow-lg z-50 hidden" style="width: 800px;">
    <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
        <p class="text-sm font-semibold text-gray-500 border-b pb-2">Result</p>
        <ul id="result-container" class="list-group bg-white z-10"></ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById('pf_location');
        const popup = document.getElementById('locationPopup');
        const resultContainer = document.getElementById('result-container');
        const pfCity = document.getElementById('pf_city');
        const pfCommunity = document.getElementById('pf_community');
        const pfSubCommunity = document.getElementById('pf_subcommunity');
        const pfBuilding = document.getElementById('pf_building');

        const togglePopup = (show) => {
            popup.classList.toggle('hidden', !show);
        };

        const positionPopup = () => {
            const rect = searchInput.getBoundingClientRect();
            popup.style.top = `${rect.top + window.pageYOffset + 30}px`;
            popup.style.left = `${rect.left + window.pageXOffset}px`;
        };

        const resetFormFields = () => {
            pfCity.value = '';
            pfCommunity.value = '';
            pfSubCommunity.value = '';
            pfBuilding.value = '';
        };

        const autofillLocation = (location, city, community, subCommunity, building) => {
            pfCity.value = city === '-' ? '' : city ?? '';
            pfCommunity.value = community === '-' ? '' : community ?? '';
            pfSubCommunity.value = subCommunity === '-' ? '' : subCommunity ?? '';
            pfBuilding.value = building === '-' ? '' : building ?? '';
        };

        const searchItems = async (query) => {
            const webhookUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list';
            const data = {
                entityTypeId: 1048,
                select: ["id", "ufCrm12Location", "ufCrm12City", "ufCrm12Community", "ufCrm12SubCommunity", "ufCrm12Building"],
                filter: {
                    "%ufCrm12Location": query
                }
            };

            try {
                const response = await fetch(webhookUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                if (result.error) {
                    throw new Error(result.error);
                }

                updateResultContainer(result.result.items);
            } catch (error) {
                console.error('Error:', error);
                resultContainer.innerHTML = '<p>Error fetching data.</p>';
            }
        };

        const updateResultContainer = (items) => {
            resultContainer.innerHTML = '';
            if (items.length > 0) {
                items.forEach(item => {
                    const itemElement = document.createElement('li');
                    itemElement.classList.add('p-2', 'cursor-pointer', 'border-b', 'hover:bg-gray-100', 'text-gray-700');
                    itemElement.innerText = item.ufCrm12Location;

                    itemElement.addEventListener('click', () => {
                        searchInput.value = item.ufCrm12Location;
                        togglePopup(false);
                        autofillLocation(item.ufCrm12Location, item.ufCrm12City, item.ufCrm12Community, item.ufCrm12SubCommunity, item.ufCrm12Building);
                    });

                    resultContainer.appendChild(itemElement);
                });
            } else {
                resultContainer.innerHTML = '<p class="text-center text-gray-500">No items found.</p>';
            }

        };

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            if (query.length >= 2) {
                togglePopup(true);
                positionPopup();
                searchItems(query);
            } else {
                togglePopup(false);
                resultContainer.innerHTML = '';
                resetFormFields();
            }
        });
    });
</script>