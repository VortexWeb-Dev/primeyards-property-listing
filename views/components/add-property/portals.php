<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Portals</h2>

    <div class="my-4 flex gap-8">
        <!-- Property Finder -->
        <div class="w-1/3 flex justify-center items-center">
            <div class="flex flex-col items-center text-center">
                <img class="h-10 w-10 rounded-full object-cover mb-3" src="assets/images/pf.png" alt="Property Finder" title="Property Finder">
                <label for="pf_enable" class="block text-sm font-medium text-gray-700 mb-2">Property Finder</label>
                <input type="checkbox" id="pf_enable" name="pf_enable" class="mt-1 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
            </div>
        </div>

        <!-- Bayut and Dubizzle -->
        <div class="w-1/3 flex flex-col justify-center items-center">
            <div class="flex flex-col items-center text-center mb-4">
                <img class="h-10 w-10 rounded-full object-cover mb-3" src="assets/images/bayut.png" alt="Bayut" title="Bayut">
                <label for="bayut_enable" class="block text-sm font-medium text-gray-700 mb-2">Bayut</label>
                <input type="checkbox" id="bayut_enable" name="bayut_enable" class="mt-1 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
            </div>

            <div class="flex flex-col items-center text-center mb-4">
                <img class="h-10 w-10 rounded-full object-cover mb-3" src="assets/images/dubizzle.png" alt="Dubizzle" title="Dubizzle">
                <label for="dubizzle_enable" class="block text-sm font-medium text-gray-700 mb-2">Dubizzle</label>
                <input type="checkbox" id="dubizzle_enable" name="dubizzle_enable" class="mt-1 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
            </div>

            <!-- Master Toggle for Bayut and Dubizzle -->
            <div class="mt-4 flex items-center gap-2">
                <input type="checkbox" id="toggle_bayut_dubizzle" class="shrink-0 mt-1 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                <label for="toggle_bayut_dubizzle" class="text-sm font-medium text-gray-700">Select Both</label>
            </div>
        </div>

        <!-- Website -->
        <div class="w-1/3 flex justify-center items-center">
            <div class="flex flex-col items-center text-center">
                <img class="h-10 w-10 rounded-full object-cover mb-3" src="assets/images/company-logo.webp" alt="Website" title="Website">
                <label for="website_enable" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                <input type="checkbox" id="website_enable" name="website_enable" class="mt-1 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
            </div>
        </div>
    </div>
</div>