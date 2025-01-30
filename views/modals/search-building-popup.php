<div id="buildingPopup" class="position-absolute mt-2 p-2 bg-white shadow z-index-1000 d-none" style="width: 300px;">
    <div class="mb-3" style="max-height: 200px; overflow-y: auto;">
        <p class="form-label pb-2 text-secondary border-bottom">Result</p>
        <div id="resultContainer_building" class="list-group"></div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('building');
        const popup = document.getElementById('buildingPopup');
        const resultContainer = document.getElementById('resultContainer_building');

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();

            if (query.length >= 2) {
                popup.classList.remove('d-none');
                popup.style.top = (searchInput.getBoundingClientRect().top + (window.pageYOffset || document.documentElement.scrollTop) - 170) + 'px';
                popup.style.left = (searchInput.getBoundingClientRect().left + (window.pageXOffset || document.documentElement.scrollLeft) - 300) + 'px';
                // make api call
                searchItems(query);
            } else {
                popup.classList.add('d-none');
                resultContainer.innerHTML = ''; // Clear results if the input is too short
            }
        })

        // Function to fetch items based on search query
        const searchItems = (query) => {
            // webhookUrl REST API endpoint for Smart Process Automation or custom entity
            const webhookUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list';

            const data = {
                "entityTypeId": 1092,
                "select": ["id", "ufCrm24Building"],
                "filter": {
                    "%ufCrm24Building": query
                }

            };

            // Make the API request
            // Fetch data from the Webhook
            fetch(webhookUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Tell the server we are sending JSON
                        'Accept': 'application/json' // Tell the server we expect JSON back
                    },
                    body: JSON.stringify(data) // Convert JavaScript object to JSON string
                })
                .then(response => response.json())
                .then(data => {

                    // Clear previous results
                    resultContainer.innerHTML = '';

                    if (data.error) {
                        console.error('Error:', data.error);
                        resultContainer.innerHTML = '<p>Error fetching data.</p>';
                        return;
                    }

                    // Check if there are any results
                    const items = data.result.items;
                    if (items.length > 0) {
                        // Display results
                        items.forEach(item => {
                            const itemElement = document.createElement('li');
                            itemElement.classList.add('list-group-item');
                            itemElement.style.cursor = 'pointer';
                            itemElement.innerHTML = `${item.ufCrm24Building}`;
                            itemElement.addEventListener('click', function() {
                                searchInput.value = item.ufCrm24Building;
                                popup.classList.add('d-none');
                                resultContainer.innerHTML = ''; // Clear results if the input is too short
                            });
                            resultContainer.appendChild(itemElement);
                        });
                    } else {
                        resultContainer.innerHTML = '<p>No items found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultContainer.innerHTML = '<p>Error fetching data.</p>';
                });
        };
    });
</script>