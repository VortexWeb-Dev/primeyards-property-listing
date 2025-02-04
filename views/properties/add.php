<div class="w-4/5 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <form class="w-full space-y-4" id="addPropertyForm" onsubmit="handleAddProperty(event)" enctype="multipart/form-data">
            <!-- Management -->
            <?php include_once('views/components/add-property/management.php'); ?>
            <!-- Specifications -->
            <?php include_once('views/components/add-property/specifications.php'); ?>
            <!-- Property Permit -->
            <?php include_once('views/components/add-property/permit.php'); ?>
            <!-- Pricing -->
            <?php include_once('views/components/add-property/pricing.php'); ?>
            <!-- Title and Description -->
            <?php include_once('views/components/add-property/title.php'); ?>
            <!-- Amenities -->
            <?php include_once('views/components/add-property/amenities.php'); ?>
            <!-- Location -->
            <?php include_once('views/components/add-property/location.php'); ?>
            <!-- Photos and Videos -->
            <?php include_once('views/components/add-property/media.php'); ?>
            <!-- Floor Plan -->
            <?php include_once('views/components/add-property/floorplan.php'); ?>
            <!-- Documents -->
            <?php // include_once('views/components/add-property/documents.php'); 
            ?>
            <!-- Notes -->
            <?php include_once('views/components/add-property/notes.php'); ?>
            <!-- Portals -->
            <?php include_once('views/components/add-property/portals.php'); ?>
            <!-- Status -->
            <?php include_once('views/components/add-property/status.php'); ?>

            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" onclick="window.location.href = 'index.php?page=properties'" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                    Back
                </button>
                <button type="submit" id="submitButton" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("offering_type").addEventListener("change", function() {
        const offeringType = this.value;
        console.log(offeringType);

        if (offeringType == 'RR' || offeringType == 'CR') {
            document.getElementById("rental_period").setAttribute("required", true);
            document.querySelector('label[for="rental_period"]').innerHTML = 'Rental Period (if rental) <span class="text-danger">*</span>';
        } else {
            document.getElementById("rental_period").removeAttribute("required");
            document.querySelector('label[for="rental_period"]').innerHTML = 'Rental Period (if rental)';
        }

        if(offeringType == 'RR' || offeringType == 'RS') {
            document.getElementById("bedrooms").setAttribute("required", true);
            document.querySelector('label[for="bedrooms"]').innerHTML = 'No. of Bedrooms <span class="text-danger">*</span>';

            document.getElementById("bathrooms").setAttribute("required", true);
            document.querySelector('label[for="bathrooms"]').innerHTML = 'No. of Bathrooms <span class="text-danger">*</span>';
        } else {
            document.getElementById("bedrooms").removeAttribute("required");
            document.querySelector('label[for="bedrooms"]').innerHTML = 'No. of Bedrooms';

            document.getElementById("bathrooms").removeAttribute("required");
            document.querySelector('label[for="bathrooms"]').innerHTML = 'No. of Bathrooms';
        }
    })

    async function addItem(entityTypeId, fields) {
        try {
            const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.add?entityTypeId=${entityTypeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    fields
                }),
            });

            if (response.ok) {
                const data = await response.json();
                return data;
            } else {
                const errorDetails = await response.text();
                console.error(`Failed to add item. Status: ${response.status}, Details: ${errorDetails}`);
                return null;
            }
        } catch (error) {
            console.error('Error while adding item:', error);
            return null;
        }
    }

    async function handleAddProperty(e) {
        e.preventDefault();

        document.getElementById('submitButton').disabled = true;
        document.getElementById('submitButton').innerHTML = 'Submitting...';

        const form = document.getElementById('addPropertyForm');
        const formData = new FormData(form);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = typeof value === 'string' ? value.trim() : value;
        });

        const agent = await getAgent(data.listing_agent);

        const fields = {
            "title": data.title_deed,
            "ufCrm14ReferenceNumber": data.reference,
            "ufCrm14OfferingType": data.offering_type,
            "ufCrm14PropertyType": data.property_type,
            "ufCrm14Price": data.price,
            "ufCrm14TitleEn": data.title_en,
            "ufCrm14DescriptionEn": data.description_en,
            "ufCrm14TitleAr": data.title_ar,
            "ufCrm14DescriptionAr": data.description_ar,
            "ufCrm14Size": data.size,
            "ufCrm14Bedroom": data.bedrooms,
            "ufCrm14Bathroom": data.bathrooms,
            "ufCrm14Parking": data.parkings,
            "ufCrm14Geopoints": `${data.latitude}, ${data.longitude}`,
            "ufCrm14PermitNumber": data.dtcm_permit_number,
            "ufCrm14RentalPeriod": data.rental_period,
            "ufCrm14Furnished": data.furnished,
            "ufCrm14TotalPlotSize": data.total_plot_size,
            "ufCrm14LotSize": data.lot_size,
            "ufCrm14BuildupArea": data.buildup_area,
            "ufCrm14LayoutType": data.layout_type,
            "ufCrm14ProjectName": data.project_name,
            "ufCrm14ProjectStatus": data.project_status,
            "ufCrm14Ownership": data.ownership,
            "ufCrm14Developers": data.developer,
            "ufCrm14BuildYear": data.build_year,
            "ufCrm14Availability": data.availability,
            "ufCrm14AvailableFrom": data.available_from,
            "ufCrm14PaymentMethod": data.payment_method,
            "ufCrm14DownPaymentPrice": data.downpayment_price,
            "ufCrm14NoOfCheques": data.cheques,
            "ufCrm14ServiceCharge": data.service_charge,
            "ufCrm14FinancialStatus": data.financial_status,
            "ufCrm14VideoTourUrl": data.video_tour_url,
            "ufCrm_14_360_VIEW_URL": data["360_view_url"],
            "ufCrm14QrCodePropertyBooster": data.qr_code_url,
            "ufCrm14Location": data.pf_location,
            "ufCrm14City": data.pf_city,
            "ufCrm14Community": data.pf_community,
            "ufCrm14SubCommunity": data.pf_subcommunity,
            "ufCrm14Tower": data.pf_building,
            "ufCrm14BayutLocation": data.bayut_location,
            "ufCrm14BayutCity": data.bayut_city,
            "ufCrm14BayutCommunity": data.bayut_community,
            "ufCrm14BayutSubCommunity": data.bayut_subcommunity,
            "ufCrm14BayutTower": data.bayut_building,
            "ufCrm14Latitude": data.latitude,
            "ufCrm14Longitude": data.longitude,
            "ufCrm14Status": data.status,
            "ufCrm14ReraPermitNumber": data.rera_permit_number,
            "ufCrm14ReraPermitIssueDate": data.rera_issue_date,
            "ufCrm14ReraPermitExpirationDate": data.rera_expiration_date,
            "ufCrm14DtcmPermitNumber": data.dtcm_permit_number,
            "ufCrm14ListingOwner": data.listing_owner,
            "ufCrm14LandlordName": data.landlord_name,
            "ufCrm14LandlordEmail": data.landlord_email,
            "ufCrm14LandlordContact": data.landlord_phone,
            "ufCrm14ContractExpiryDate": data.contract_expiry,
            "ufCrm14UnitNo": data.unit_no,
            "ufCrm14SaleType": data.sale_type,
            "ufCrm14BrochureDescription": data.brochure_description_1,
            "ufCrm_14_BROCHUREDESCRIPTION2": data.brochure_description_2,
            "ufCrm14HidePrice": data.hide_price == "on" ? "Y" : "N",
            "ufCrm14PfEnable": data.pf_enable == "on" ? "Y" : "N",
            "ufCrm14BayutEnable": data.bayut_enable == "on" ? "Y" : "N",
            "ufCrm14DubizzleEnable": data.dubizzle_enable == "on" ? "Y" : "N",
            "ufCrm14WebsiteEnable": data.website_enable == "on" ? "Y" : "N",
        };

        if (agent) {
            fields["ufCrm14AgentId"] = agent.ufCrm8AgentId;
            fields["ufCrm14AgentName"] = agent.ufCrm8AgentName;
            fields["ufCrm14AgentEmail"] = agent.ufCrm8AgentEmail;
            fields["ufCrm14AgentPhone"] = agent.ufCrm8AgentMobile;
            fields["ufCrm14AgentPhoto"] = agent.ufCrm8AgentPhoto;
            fields["ufCrm14AgentLicense"] = agent.ufCrm8AgentLicense;
        }

        // Notes
        const notesString = data.notes;
        if (notesString) {
            const notesArray = JSON.parse(notesString);
            if (notesArray) {
                fields["ufCrm14Notes"] = notesArray;
            }
        }

        // Amenities
        const amenitiesString = data.amenities;
        if (amenitiesString) {
            const amenitiesArray = JSON.parse(amenitiesString);
            if (amenitiesArray) {
                fields["ufCrm14Amenities"] = amenitiesArray;
            }
        }

        // Property Photos
        const photos = document.getElementById('selectedImages').value;
        if (photos) {
            const fixedPhotos = photos.replace(/\\'/g, '"');
            const photoArray = JSON.parse(fixedPhotos);
            const watermarkPath = 'assets/images/watermark.webp';
            const uploadedImages = await processBase64Images(photoArray, watermarkPath);

            if (uploadedImages.length > 0) {
                fields["ufCrm14PhotoLinks"] = uploadedImages;
            }
        }

        // Floorplan
        const floorplan = document.getElementById('selectedFloorplan').value;
        if (floorplan) {
            const fixedFloorplan = floorplan.replace(/\\'/g, '"');
            const floorplanArray = JSON.parse(fixedFloorplan);
            const watermarkPath = 'assets/images/watermark.webp';
            const uploadedFloorplan = await processBase64Images(floorplanArray, watermarkPath);

            if (uploadedFloorplan.length > 0) {
                fields["ufCrm14FloorPlan"] = uploadedFloorplan[0];
            }
        }

        // Documents
        // const documents = document.getElementById('documents')?.files;
        // if (documents) {
        //     if (documents.length > 0) {
        //         let documentUrls = [];

        //         for (const document of documents) {
        //             if (document.size > 10485760) {
        //                 alert('File size must be less than 10MB');
        //                 return;
        //             }
        //             const uploadedDocument = await uploadFile(document);
        //             documentUrls.push(uploadedDocument);
        //         }

        //         fields["ufCrm14Documents"] = documentUrls;
        //     }

        // }

        // Add to CRM
        const result = await addItem(1052, fields, '?page=properties');

        // Add to history
        if (result?.result?.item) {
            const newItem = result.result.item;

            const changedById = <?php echo json_encode((int)$currentUser['ID'] ?? ''); ?>;
            const changedByName = <?php echo json_encode(trim(($currentUser['NAME'] ?? '') . ' ' . ($currentUser['LAST_NAME'] ?? ''))); ?>;

            addHistory(845, 1052, newItem.id, "Property", changedById, changedByName);

            window.location.href = 'index.php?page=properties';
        } else {
            console.error("Failed to retrieve item. Invalid response structure:", result);
        }
    }
</script>