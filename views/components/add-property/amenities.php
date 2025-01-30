<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6">Amenities</h2>

    <div class="my-4 flex justify-between gap-6">
        <div class="w-full md:w-1/2 border rounded-lg p-4" style="max-height: 20rem; overflow-y: auto;">
            <label class="block text-sm font-medium mb-2">Available Amenities</label>
            <ul id="availableAmenities" class="list-none p-0 space-y-2">
                <!-- Available amenities will be displayed here -->
            </ul>
        </div>

        <div class="w-full md:w-1/2 border rounded-lg p-4" style="max-height: 20rem; overflow-y: auto;">
            <label class="block text-sm font-medium mb-2">Selected Amenities</label>
            <ul id="selectedAmenities" class="list-none p-0 space-y-2">
                <!-- Selected amenities will be displayed here -->
            </ul>
        </div>
    </div>

    <input type="hidden" name="amenities" id="amenitiesInput">
</div>

<script>
    const amenities = [{
            id: 'GV',
            label: 'Golf view'
        },
        {
            id: 'CW',
            label: 'City view'
        },
        {
            id: 'NO',
            label: 'North orientation'
        },
        {
            id: 'SO',
            label: 'South orientation'
        },
        {
            id: 'EO',
            label: 'East orientation'
        },
        {
            id: 'WO',
            label: 'West orientation'
        },
        {
            id: 'NS',
            label: 'Near school'
        },
        {
            id: 'HO',
            label: 'Near hospital'
        },
        {
            id: 'TR',
            label: 'Terrace'
        },
        {
            id: 'NM',
            label: 'Near mosque'
        },
        {
            id: 'SM',
            label: 'Near supermarket'
        },
        {
            id: 'ML',
            label: 'Near mall'
        },
        {
            id: 'PT',
            label: 'Near public transportation'
        },
        {
            id: 'MO',
            label: 'Near metro'
        },
        {
            id: 'VT',
            label: 'Near veterinary'
        },
        {
            id: 'BC',
            label: 'Beach access'
        },
        {
            id: 'PK',
            label: 'Public parks'
        },
        {
            id: 'RT',
            label: 'Near restaurants'
        },
        {
            id: 'NG',
            label: 'Near Golf'
        },
        {
            id: 'AP',
            label: 'Near airport'
        },
        {
            id: 'CS',
            label: 'Concierge Service'
        },
        {
            id: 'SS',
            label: 'Spa'
        },
        {
            id: 'SY',
            label: 'Shared Gym'
        },
        {
            id: 'MS',
            label: 'Maid Service'
        },
        {
            id: 'WC',
            label: 'Walk-in Closet'
        },
        {
            id: 'HT',
            label: 'Heating'
        },
        {
            id: 'GF',
            label: 'Ground floor'
        },
        {
            id: 'SV',
            label: 'Server room'
        },
        {
            id: 'DN',
            label: 'Pantry'
        },
        {
            id: 'RA',
            label: 'Reception area'
        },
        {
            id: 'VP',
            label: 'Visitors parking'
        },
        {
            id: 'OP',
            label: 'Office partitions'
        },
        {
            id: 'SH',
            label: 'Core and Shell'
        },
        {
            id: 'CD',
            label: 'Children daycare'
        },
        {
            id: 'CL',
            label: 'Cleaning services'
        },
        {
            id: 'NH',
            label: 'Near Hotel'
        },
        {
            id: 'CR',
            label: 'Conference room'
        },
        {
            id: 'BL',
            label: 'View of Landmark'
        },
        {
            id: 'PR',
            label: 'Children Play Area'
        },
        {
            id: 'BH',
            label: 'Beach Access'
        }
    ];

    let selectedAmenities = [];

    function renderAmenities() {
        const availableAmenitiesContainer = document.getElementById("availableAmenities");
        availableAmenitiesContainer.innerHTML = "";

        amenities.forEach(amenity => {
            const li = document.createElement("li");
            li.classList.add("text-gray-700", "p-2", "flex", "justify-between", "items-center", "mb-2", "bg-gray-100", "rounded-md", "cursor-pointer", "hover:bg-gray-200");
            li.textContent = amenity.label;
            li.dataset.id = amenity.id;

            li.onclick = () => selectAmenity(amenity);

            availableAmenitiesContainer.appendChild(li);
        });
    }

    function selectAmenity(amenity) {
        if (selectedAmenities.some(a => a.id === amenity.id)) {
            alert("Amenity is already selected.");
            return;
        }

        selectedAmenities.push(amenity);
        updateSelectedAmenities();
        updateAvailableAmenities();
        updateAmenitiesInput();
    }

    function updateSelectedAmenities() {
        const selectedAmenitiesContainer = document.getElementById("selectedAmenities");
        selectedAmenitiesContainer.innerHTML = "";

        selectedAmenities.forEach(amenity => {
            const li = document.createElement("li");
            li.classList.add("text-gray-700", "p-2", "flex", "justify-between", "items-center", "mb-2", "bg-gray-100", "rounded-md");

            li.innerHTML = `
                ${amenity.label}
                <button type="button" class="text-red-500 hover:text-red-700" onclick="removeAmenity('${amenity.id}')">×</button>
            `;

            selectedAmenitiesContainer.appendChild(li);
        });
    }

    function updateAvailableAmenities() {
        const availableAmenitiesContainer = document.getElementById("availableAmenities");
        availableAmenitiesContainer.innerHTML = "";

        amenities.forEach(amenity => {
            if (!selectedAmenities.some(a => a.id === amenity.id)) {
                const li = document.createElement("li");
                li.classList.add("text-gray-700", "p-2", "flex", "justify-between", "items-center", "mb-2", "bg-gray-100", "rounded-md", "cursor-pointer", "hover:bg-gray-200");
                li.textContent = amenity.label;
                li.dataset.id = amenity.id;

                li.onclick = () => selectAmenity(amenity);

                availableAmenitiesContainer.appendChild(li);
            }
        });
    }

    function removeAmenity(amenityId) {
        selectedAmenities = selectedAmenities.filter(a => a.id !== amenityId);

        const amenitiesList = document.getElementById("selectedAmenities");
        const itemToRemove = Array.from(amenitiesList.children).find(li =>
            li.textContent.trim().includes(getAmenityName(amenityId))
        );

        if (itemToRemove) {
            itemToRemove.remove();
        }

        updateAmenitiesInput();
    }


    function updateAmenitiesInput() {
        let selectedAmenities = [];
        const amenitiesList = document.getElementById("selectedAmenities").children;

        for (let i = 0; i < amenitiesList.length; i++) {
            selectedAmenities.push(getAmenityId(amenitiesList[i].textContent.trim().replace("×", "").trim()));
        }

        document.getElementById("amenitiesInput").value = JSON.stringify(selectedAmenities);

    }

    renderAmenities();
</script>