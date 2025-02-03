<div class="w-4/5 mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <form class="w-full space-y-4" id="editPropertyForm" onsubmit="handleEditProperty(event)">
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
    })

    async function updateItem(entityTypeId, fields, id) {
        try {
            const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.update?entityTypeId=${entityTypeId}&id=${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    fields,
                }),
            });

            if (response.ok) {
                const data = await response.json();
                return data;
            } else {
                const errorDetails = await response.text();
                console.error(`Failed to update item. Status: ${response.status}, Details: ${errorDetails}`);
                return null;
            }
        } catch (error) {
            console.error('Error while updating item:', error);
            return null;
        }
    }

    async function handleEditProperty(e) {
        e.preventDefault();

        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.innerHTML = 'Updating...';

        const form = document.getElementById('editPropertyForm');
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
            "ufCrm14City": data.bayut_city,
            "ufCrm14Community": data.bayut_community,
            "ufCrm14SubCommunity": data.bayut_subcommunity,
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

            "ufCrm14HidePrice": data.hide_price === "on" ? "Y" : "N",
            "ufCrm14PfEnable": data.pf_enable === "on" ? "Y" : "N",
            "ufCrm14BayutEnable": data.bayut_enable === "on" ? "Y" : "N",
            "ufCrm14DubizzleEnable": data.dubizzle_enable === "on" ? "Y" : "N",
            "ufCrm14WebsiteEnable": data.website_enable === "on" ? "Y" : "N",
        };

        if (agent) {
            Object.assign(fields, {
                "ufCrm14AgentId": agent.ufCrm8AgentId,
                "ufCrm14AgentName": agent.ufCrm8AgentName,
                "ufCrm14AgentEmail": agent.ufCrm8AgentEmail,
                "ufCrm14AgentPhone": agent.ufCrm8AgentMobile,
                "ufCrm14AgentPhoto": agent.ufCrm8AgentPhoto,
                "ufCrm14AgentLicense": agent.ufCrm8AgentLicense,
            });
        }

        const notesString = data.notes;
        if (notesString) {
            const notesArray = JSON.parse(notesString);
            fields["ufCrm14Notes"] = notesArray;
        }

        const amenitiesString = data.amenities;
        if (amenitiesString) {
            const amenitiesArray = JSON.parse(amenitiesString);
            fields["ufCrm14Amenities"] = amenitiesArray;
        }

        const photos = document.getElementById('selectedImages').value;
        const existingPhotosString = document.getElementById('existingPhotos').value;

        if (existingPhotosString) {
            const existingPhotos = JSON.parse(existingPhotosString) || [];

            if (photos.length > 0) {
                const fixedPhotos = photos.replace(/\\'/g, '"');
                const photoArray = JSON.parse(fixedPhotos);
                const watermarkPath = 'assets/images/watermark.webp';
                const uploadedImages = await processBase64Images(photoArray, watermarkPath);

                fields["ufCrm14PhotoLinks"] = uploadedImages.length > 0 ? [...existingPhotos, ...uploadedImages] : [...existingPhotos];
            } else {
                fields["ufCrm14PhotoLinks"] = [...existingPhotos];
            }
        }

        const floorplans = document.getElementById('selectedFloorplan').value;
        const existingFloorplansString = document.getElementById('existingFloorplan').value;

        if (existingFloorplansString || floorplans.length > 0) {
            const existingFloorplans = JSON.parse(existingFloorplansString || "[]");

            if (floorplans.length > 0) {

                const fixedFloorplans = floorplans.replace(/\\'/g, '"');
                const floorplanArray = JSON.parse(fixedFloorplans);
                const watermarkPath = 'assets/images/watermark.webp';
                const uploadedFloorplans = await processBase64Images(floorplanArray, watermarkPath);


                fields["ufCrm14FloorPlan"] = uploadedFloorplans.length > 0 ?
                    uploadedFloorplans[0] :
                    existingFloorplans[0] || null;
            } else {

                fields["ufCrm14FloorPlan"] = existingFloorplans[0] || null;
            }
        } else {

            fields["ufCrm14FloorPlan"] = null;
        }

        const result = await updateItem(1052, fields, <?php echo $_GET['id']; ?>);

        // Add to history
        if (result?.result?.item) {
            const updatedItem = result.result.item;

            const changedById = <?php echo json_encode((int)$currentUser['ID'] ?? ''); ?>;
            const changedByName = <?php echo json_encode(trim(($currentUser['NAME'] ?? '') . ' ' . ($currentUser['LAST_NAME'] ?? ''))); ?>;

            addHistory(846, 1052, updatedItem.id, "Property", changedById, changedByName);

            window.location.href = 'index.php?page=properties';
        } else {
            console.error("Failed to retrieve item. Invalid response structure:", result);
        }
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const property = await fetchProperty(<?php echo $_GET['id']; ?>);

        const containers = [{
                type: "photos",
                newLinks: [],
                selectedFiles: [],
                existingLinks: property['ufCrm14PhotoLinks'] || [],
                newPreviewContainer: document.getElementById('newPhotoPreviewContainer'),
                existingPreviewContainer: document.getElementById('existingPhotoPreviewContainer'),
                selectedInput: document.getElementById('selectedImages'),
                existingInput: document.getElementById('existingPhotos'),
            },
            {
                type: "floorplan",
                newLinks: [],
                selectedFiles: [],
                existingLinks: property['ufCrm14FloorPlan'] ? [property['ufCrm14FloorPlan']] : [],
                newPreviewContainer: document.getElementById('newFloorplanPreviewContainer'),
                existingPreviewContainer: document.getElementById('existingFloorplanPreviewContainer'),
                selectedInput: document.getElementById('selectedFloorplan'),
                existingInput: document.getElementById('existingFloorplan'),
            },
        ];

        containers.forEach((container) => {
            initializeContainer(container);
        });

        function initializeContainer(container) {
            // Add Swapy only if slots exist
            function addSwapy(previewContainer) {
                console.log('swappy');

                const slots = previewContainer.querySelectorAll('[data-swapy-slot]');
                if (slots.length === 0) {
                    console.warn(`No slots found in preview container:`, previewContainer);
                    return; // Skip Swapy initialization if no slots are present
                }

                const swapy = Swapy.createSwapy(previewContainer, {
                    animation: 'dynamic',
                    swapMode: 'drop',
                });

                swapy.onSwapEnd((event) => {
                    if (event.hasChanged) {
                        console.log('Swap end event:', event);

                        const updatedImageLinks = [];
                        event.slotItemMap.asMap.forEach((item) => {
                            const element = document.querySelector(`[data-swapy-item="${item}"]`);
                            updatedImageLinks.push(element.querySelector('img').src);
                        });

                        if (previewContainer === container.newPreviewContainer) {
                            container.newLinks = updatedImageLinks;
                            previewImages(container.newLinks, container.newPreviewContainer);
                        } else {
                            container.existingLinks = updatedImageLinks;
                            previewImages(container.existingLinks, container.existingPreviewContainer);
                        }
                    }
                });
            }

            // Update photo preview for selected files
            function updatePhotoPreview() {
                const promises = container.selectedFiles.map((file) => {
                    return new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = function(e) {
                            container.newLinks.push(e.target.result);
                            resolve();
                        };
                    });
                });

                Promise.all(promises).then(() => {
                    previewImages(container.newLinks, container.newPreviewContainer);
                });
            }

            // Render images into the preview container
            function previewImages(imageLinks, previewContainer) {
                console.log('previewImages');

                previewContainer.innerHTML = '';

                if (imageLinks.length === 0) {
                    previewContainer.innerHTML = '<p class="text-muted">No images to display.</p>';
                    updateSelectedImagesInput();
                    return; // Exit if no images to preview
                }

                let row = document.createElement('div');
                row.classList.add('shuffle-row');

                imageLinks.forEach((imageSrc, i) => {
                    if (i % 3 === 0 && i !== 0) {
                        previewContainer.appendChild(row);
                        row = document.createElement('div');
                        row.classList.add('shuffle-row');
                    }

                    const slot = document.createElement('div');
                    slot.classList.add('slot');
                    slot.setAttribute('data-swapy-slot', i + 1);

                    const item = document.createElement('div');
                    item.classList.add('item');
                    item.setAttribute('data-swapy-item', String.fromCharCode(97 + i));

                    const image = document.createElement('div');
                    const img = document.createElement('img');
                    img.src = imageSrc;

                    image.appendChild(img);
                    item.appendChild(image);
                    slot.appendChild(item);

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = "&times;";
                    removeBtn.classList.add(
                        "position-absolute",
                        "top-0",
                        "end-0",
                        "btn",
                        "btn-sm",
                        "btn-danger",
                        "m-1"
                    );
                    removeBtn.style.zIndex = "1";

                    removeBtn.addEventListener('click', function(event) {
                        // event.preventDefault();
                        event.stopImmediatePropagation();
                        console.log("removeBtn.onclick", i);

                        if (previewContainer === container.newPreviewContainer) {
                            container.newLinks.splice(i, 1);
                            previewImages(container.newLinks, container.newPreviewContainer);
                        } else {
                            container.existingLinks.splice(i, 1);
                            previewImages(container.existingLinks, container.existingPreviewContainer);
                        }
                    });

                    item.appendChild(removeBtn);
                    row.appendChild(slot);
                });

                previewContainer.appendChild(row);
                addSwapy(previewContainer);
                updateSelectedImagesInput();
            }

            // Update hidden input values for the selected and existing images
            function updateSelectedImagesInput() {
                console.log("updateSelectedImagesInput");

                container.selectedInput.value = JSON.stringify(container.newLinks);
                container.existingInput.value = JSON.stringify(container.existingLinks);
            }

            // Handle file selection
            document.getElementById(container.type).addEventListener('change', function(event) {
                const files = Array.from(event.target.files);
                container.selectedFiles = [];

                files.forEach((file) => {
                    if (file.size >= 10 * 1024 * 1024) {
                        // alert(`The file "${file.name}" is too large (10MB or greater). Please select a smaller file.`);
                        document.getElementById(`${container.type}Message`).classList.remove('hidden');
                        document.getElementById(`${constainer.type}Message`).textContent = `The file "${file.name}" is too large (10MB or greater). Please select a smaller file.`;
                    } else if (!container.selectedFiles.some((f) => f.name === file.name)) {
                        container.selectedFiles.push(file);
                        document.getElementById(`${container.type}Message`).classList.add('hidden');
                    }
                });

                updatePhotoPreview();
            });

            // Initialize preview with existing links
            previewImages(container.existingLinks, container.existingPreviewContainer);
        }
    });
</script>