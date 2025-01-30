<div class="w-4/5 mx-auto py-8">
    <h1 class="text-3xl font-semibold text-gray-800">Reports</h1>

    <div class="container mx-auto flex justify-center gap-6 mt-6">
        <div class="flex flex-col justify-center items-center">
            <h2 class="text-lg text-gray-600">Residential</h2>
            <div id="hs-doughnut-chart"></div>

            <!-- Legend Indicator -->
            <div class="flex justify-center sm:justify-end items-center gap-x-4 mt-3 sm:mt-6">
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">

                        Sale <span id="residential-sale"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">

                        Rent <span id="residential-rent"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">

                        PF <span id="residential-property-finder"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">

                        Bayut <span id="residential-bayut"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">

                        Dubizzle <span id="residential-dubizzle"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Website <span id="residential-website"></span>
                    </span>
                </div>
            </div>
            <!-- End Legend Indicator -->
        </div>
        <div class="flex flex-col justify-center items-center">
            <h2 class="text-lg text-gray-600">Commercial</h2>
            <div id="hs-doughnut-chart-2"></div>

            <!-- Legend Indicator -->
            <div class="flex justify-center sm:justify-end items-center gap-x-4 mt-3 sm:mt-6">
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Sale <span id="commercial-sale"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Rent <span id="commercial-rent"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        PF <span id="commercial-property-finder"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Bayut <span id="commercial-bayut"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Dubizzle <span id="commercial-dubizzle"></span>
                    </span>
                </div>
                <div class="inline-flex items-center">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Website <span id="commercial-website"></span>
                    </span>
                </div>
            </div>
            <!-- End Legend Indicator -->
        </div>
    </div>
</div>

<script src="https://preline.co/assets/js/hs-apexcharts-helpers.js"></script>

<script>
    window.addEventListener('load', async () => {
        // Fetch data for Apex Doughnut Chart
        let baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
        let properties = [];
        const response = await fetch(`${baseUrl}/crm.item.list?entityTypeId=1052&select[0]=ufCrm14OfferingType&select[1]=ufCrm14PfEnable&select[2]=ufCrm14BayutEnable&select[3]=ufCrm14DubizzleEnable&select[4]=ufCrm14WebsiteEnable`);
        const data = await response.json();
        const totalOwners = data.total;

        for (let i = 0; i < Math.ceil(totalOwners / 50); i++) {
            const response = await fetch(`${baseUrl}/crm.item.list?entityTypeId=1052&select[0]=ufCrm14OfferingType&select[1]=ufCrm14PfEnable&select[2]=ufCrm14BayutEnable&select[3]=ufCrm14DubizzleEnable&select[4]=ufCrm14WebsiteEnable&start=${i * 50}`);
            const data = await response.json();
            properties = properties.concat(data.result.items);
        }

        let residentialSale = 0;
        let residentialRent = 0;
        let residentialPropertyFinder = 0;
        let residentialBayut = 0;
        let residentialDubizzle = 0;
        let residentialWebsite = 0;

        let commercialSale = 0;
        let commercialRent = 0;
        let commercialPropertyFinder = 0;
        let commercialBayut = 0;
        let commercialDubizzle = 0;
        let commercialWebsite = 0;

        properties.forEach(property => {
            if (property['ufCrm14OfferingType'] === 'RS' || property['offeringType'] === 'RR') {
                // Residential
                if (property['ufCrm14PfEnable']) residentialPropertyFinder++;
                if (property['ufCrm14BayutEnable']) residentialBayut++;
                if (property['ufCrm14DubizzleEnable']) residentialDubizzle++;
                if (property['ufCrm14WebsiteEnable']) residentialWebsite++;
                if (property['ufCrm14OfferingType'] === 'RS') {
                    residentialSale++;
                } else {
                    residentialRent++;
                }
            } else if (property['ufCrm14OfferingType'] === 'CS' || property['offeringType'] === 'CR') {
                // Commercial
                if (property['ufCrm14PfEnable']) commercialPropertyFinder++;
                if (property['ufCrm14BayutEnable']) commercialBayut++;
                if (property['ufCrm14DubizzleEnable']) commercialDubizzle++;
                if (property['ufCrm14WebsiteEnable']) commercialWebsite++;
                if (property['ufCrm14OfferingType'] === 'CS') {
                    commercialSale++;
                } else {
                    commercialRent++;
                }
            }
        });

        if (residentialSale === 0 && residentialRent === 0 && residentialPropertyFinder === 0 && residentialBayut === 0 && residentialDubizzle === 0 && residentialWebsite === 0) {
            document.getElementById('hs-doughnut-chart').innerHTML = '<p class="text-sm text-center text-gray-600">No data found</p>';
        }

        if (commercialSale === 0 && commercialRent === 0 && commercialPropertyFinder === 0 && commercialBayut === 0 && commercialDubizzle === 0 && commercialWebsite === 0) {
            document.getElementById('hs-doughnut-chart-2').innerHTML = '<p class="text-sm text-center text-gray-600">No data found</p>';
        }

        document.getElementById('residential-sale').textContent = residentialSale;
        document.getElementById('residential-rent').textContent = residentialRent;
        document.getElementById('residential-property-finder').textContent = residentialPropertyFinder;
        document.getElementById('residential-bayut').textContent = residentialBayut;
        document.getElementById('residential-dubizzle').textContent = residentialDubizzle;
        document.getElementById('residential-website').textContent = residentialWebsite;

        document.getElementById('commercial-sale').textContent = commercialSale;
        document.getElementById('commercial-rent').textContent = commercialRent;
        document.getElementById('commercial-property-finder').textContent = commercialPropertyFinder;
        document.getElementById('commercial-bayut').textContent = commercialBayut;
        document.getElementById('commercial-dubizzle').textContent = commercialDubizzle;
        document.getElementById('commercial-website').textContent = commercialWebsite;

        // Apex Doughnut Chart
        (function() {
            // Residential
            buildChart('#hs-doughnut-chart', (mode) => ({
                chart: {
                    height: 230,
                    width: 230,
                    type: 'donut',
                    zoom: {
                        enabled: false
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '76%'
                        }
                    }
                },
                series: [residentialSale || 0, residentialRent || 0, residentialPropertyFinder || 0, residentialBayut || 0, residentialDubizzle || 0, residentialWebsite || 0],
                labels: ['Sale', 'Rent', 'PF', 'Bayut', 'Dubizzle', 'Website'],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 5
                },
                grid: {
                    padding: {
                        top: -12,
                        bottom: -11,
                        left: -12,
                        right: -12
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    custom: function(props) {
                        return buildTooltipForDonut(
                            props,
                            mode === 'dark' ? ['#fff', '#fff', '#000', '#000', '#000', '#000'] : ['#fff', '#fff', '#000', '#000', '#000', '#000']
                        );
                    }
                }
            }), {
                colors: ['#3b82f6', '#22d3ee', '#f97316', '#10b981', '#8b5cf6', '#ec4899'], // Distinct colors for each label
                stroke: {
                    colors: ['rgb(255, 255, 255)'] // Stroke for light mode
                }
            }, {
                colors: ['#2563eb', '#06b6d4', '#ea580c', '#059669', '#7c3aed', '#db2777'], // Distinct colors for dark mode
                stroke: {
                    colors: ['rgb(38, 38, 38)'] // Stroke for dark mode
                }
            });
        })();
        (function() {
            // Commercial
            buildChart('#hs-doughnut-chart-2', (mode) => ({
                chart: {
                    height: 230,
                    width: 230,
                    type: 'donut',
                    zoom: {
                        enabled: false
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '76%'
                        }
                    }
                },
                series: [commercialSale || 0, commercialRent || 0, commercialPropertyFinder || 0, commercialBayut || 0, commercialDubizzle || 0, commercialWebsite || 0],
                labels: ['Sale', 'Rent', 'PF', 'Bayut', 'Dubizzle', 'Website'],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 5
                },
                grid: {
                    padding: {
                        top: -12,
                        bottom: -11,
                        left: -12,
                        right: -12
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    custom: function(props) {
                        return buildTooltipForDonut(
                            props,
                            mode === 'dark' ? ['#fff', '#fff', '#000', '#000', '#000', '#000'] : ['#fff', '#fff', '#000', '#000', '#000', '#000']
                        );
                    }
                }
            }), {
                colors: ['#3b82f6', '#22d3ee', '#f97316', '#10b981', '#8b5cf6', '#ec4899'], // Distinct colors for each label
                stroke: {
                    colors: ['rgb(255, 255, 255)'] // Stroke for light mode
                }
            }, {
                colors: ['#2563eb', '#06b6d4', '#ea580c', '#059669', '#7c3aed', '#db2777'], // Distinct colors for dark mode
                stroke: {
                    colors: ['rgb(38, 38, 38)'] // Stroke for dark mode
                }
            });
        })();
    });
</script>