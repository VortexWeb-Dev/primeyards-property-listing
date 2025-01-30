<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold">Pricing</h2>
    <p class="text-sm text-gray-500 mb-4">Please fill in all the required fields</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-4">
        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="price" class="block text-sm font-medium mb-2">Price <span class="text-danger">*</span></label>
            <input type="number" step="0.01" id="price" name="price" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="rental_period" class="block text-sm font-medium mb-2">Rental Period (if rental)</label>
            <select id="rental_period" name="rental_period" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="Y">Yearly</option>
                <option value="M">Monthly</option>
                <option value="W">Weekly</option>
                <option value="D">Daily</option>
            </select>
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="hide_price" class="block text-sm font-medium mb-2">Hide Price? (Property Finder only)</label>
            <div class="flex">
                <input type="checkbox" id="hide_price" name="hide_price" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="hs-default-checkbox">
            </div>
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="payment_method" class="block text-sm font-medium mb-2">Payment Method</label>
            <input type="text" id="payment_method" name="payment_method" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="downpayment_price" class="block text-sm font-medium mb-2">Down Payment Price</label>
            <input type="number" step="0.01" id="downpayment_price" name="downpayment_price" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 3 -->
        <div class="max-w-sm">
            <label for="cheques" class="block text-sm font-medium mb-2">No. of Cheques</label>
            <select id="cheques" name="cheques" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
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
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>

        <!-- Column 1 -->
        <div class="max-w-sm">
            <label for="service_charge" class="block text-sm font-medium mb-2">Service Charge</label>
            <input type="number" step="0.01" id="service_charge" name="service_charge" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
        <!-- Column 2 -->
        <div class="max-w-sm">
            <label for="financial_status" class="block text-sm font-medium mb-2">Financial Status</label>
            <select id="financial_status" name="financial_status" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                <option value="">Please select</option>
                <option value="mortgaged">Mortgaged</option>
                <option value="cash">Cash</option>
            </select>
        </div>

    </div>
</div>