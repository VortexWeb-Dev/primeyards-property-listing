<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold">Specifications</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in all the required fields</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4">
        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="title_deed" class="block text-sm font-medium mb-2">Title Deed</label>
            <input type="text" id="title_deed" name="title_deed" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="property_type" class="block text-sm font-medium mb-2">Property Type <span class="text-danger">*</span></label>
            <select id="property_type" name="property_type" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
                <option value="">Please select</option>
                <option value="AP">Apartment / Flat</option>
                <option value="TH">Townhouse</option>
                <option value="VH">Villa / House</option>
                <option value="PH">Penthouse</option>
                <option value="LP">Residential Land</option>
                <option value="FF">Full Floor</option>
                <option value="BU">Bulk Units</option>
                <option value="CD">Compound</option>
                <option value="DX">Duplex</option>
                <option value="FA">Factory</option>
                <option value="FA">Farm</option>
                <option value="HA">Hotel Apartment</option>
                <option value="HF">Half Floor</option>
                <option value="LC">Labor Camp</option>
                <option value="LP">Land / Plot</option>
                <option value="OF">Office Space</option>
                <option value="OF">Business Centre</option>
                <option value="RE">Retail</option>
                <option value="RE">Restaurant</option>
                <option value="SA">Staff Accommodation</option>
                <option value="WB">Whole Building</option>
                <option value="SH">Shop</option>
                <option value="SR">Show Room</option>
                <option value="OF">Co-working Space</option>
                <option value="WH">Storage</option>
                <option value="WH">Warehouse</option>
                <option value="LP">Commercial Land</option>
                <option value="FF">Commercial Floor</option>
                <option value="WB">Commercial Building</option>
                <option value="FF">Residential Floor</option>
            </select>
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="offering_type" class="block text-sm font-medium mb-2">Offering Type <span class="text-danger">*</span></label>
            <select id="offering_type" name="offering_type" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
                <option value="">Please select</option>
                <option value="CS">Commercial Sale</option>
                <option value="CR">Commercial Rent</option>
                <option value="RS">Residential Sale</option>
                <option value="RR">Residential Rent</option>
            </select>
        </div>

        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="size" class="block text-sm font-medium mb-2">Size (Sq.ft) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" id="size" name="size" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="unit_no" class="block text-sm font-medium mb-2">Unit No.</label>
            <input type="text" id="unit_no" name="unit_no" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="bedrooms" class="block text-sm font-medium mb-2">No. of Bedrooms <span class="text-danger">*</span></label>
            <select id="bedrooms" name="bedrooms" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
                <option value="">Please select</option>
                <option value="0">Studio</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">10+</option>
            </select>
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="bathrooms" class="block text-sm font-medium mb-2">No. of Bathrooms <span class="text-danger">*</span></label>
            <input type="number" id="bathrooms" name="bathrooms" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="parkings" class="block text-sm font-medium mb-2">No. of Parking Spaces</label>
            <input type="number" id="parkings" name="parkings" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="furnished" class="block text-sm font-medium mb-2">Furnished?</label>
            <select id="furnished" name="furnished" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="unfurnished">Unfurnished</option>
                <option value="semi-furnished">Semi-furnished</option>
                <option value="furnished">Furnished</option>
            </select>
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="total_plot_size" class="block text-sm font-medium mb-2">Total Plot Size (Sq.ft)</label>
            <input type="number" step="0.01" id="total_plot_size" name="total_plot_size" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="lot_size" class="block text-sm font-medium mb-2">Lot Size (Sq.ft)</label>
            <input type="number" step="0.01" id="lot_size" name="lot_size" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="buildup_area" class="block text-sm font-medium mb-2">Build-up Area</label>
            <input type="text" id="buildup_area" name="buildup_area" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="layout_type" class="block text-sm font-medium mb-2">Layout Type</label>
            <input type="text" id="layout_type" name="layout_type" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="project_name" class="block text-sm font-medium mb-2">Project Name</label>
            <input type="text" id="project_name" name="project_name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="project_status" class="block text-sm font-medium mb-2">Project Status</label>
            <select id="project_status" name="project_status" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="ready_secondary">Ready Secondary</option>
                <option value="offplan_secondary">Off-Plan Secondary</option>
                <option value="ready_primary">Ready Primary</option>
                <option value="offplan_primary">Off-Plan Primary</option>
            </select>
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="sale_type" class="block text-sm font-medium mb-2">Sale Type (if off-plan)</label>
            <select id="sale_type" name="sale_type" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="free_hold">Free hold</option>
                <option value="New">New</option>
                <option value="Resale">Resale</option>
            </select>
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="developer" class="block text-sm font-medium mb-2">Developer</label>
            <select id="developer" name="developer" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
            </select>
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="build_year" class="block text-sm font-medium mb-2">Build Year</label>
            <input type="number" id="build_year" name="build_year" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="ownership" class="block text-sm font-medium mb-2">Ownership</label>
            <select id="ownership" name="ownership" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="free_hold">Free hold</option>
                <option value="none_hold">None hold</option>
                <option value="lease_hold">Lease hold</option>
            </select>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const developerSelect = document.getElementById('developer');

        const url = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list?entityTypeId=1036&select[0]=ID&select[1]=ufCrm6DeveloperName&order[ufCrm6DeveloperName]=asc';

        const fetchAndDisplayOptions = async () => {
            try {

                let developers = [];

                const response = await fetch(url);
                const data = await response.json();
                const total = data.total;

                for (let i = 0; i < Math.ceil(total / 50); i++) {
                    const response = await fetch(`${url}&start=${i * 50}`);
                    const data = await response.json();

                    developers = developers.concat(data.result.items);
                }

                developers.forEach(developer => {
                    const option = document.createElement('option');
                    option.value = developer.ufCrm6DeveloperName;
                    option.textContent = developer.ufCrm6DeveloperName;
                    developerSelect.appendChild(option);
                });

            } catch (error) {
                console.error('Error fetching developers:', error);
            }
        };

        fetchAndDisplayOptions();

    });
</script>