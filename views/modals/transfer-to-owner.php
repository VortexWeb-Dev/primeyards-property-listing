<!-- Modal (Transfer to Owner) -->
<div class="modal fade" id="transferOwnerModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferModalLabel">Transfer Property to Owner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transferOwnerForm" onsubmit="handleTransferOwnerSubmit(event)">
                    <input type="hidden" id="transferOwnerPropertyIds" name="transferOwnerPropertyIds">

                    <div class="form-group">
                        <label for="listing_owner" class="block text-sm font-medium mb-2">Listing Owner <span class="text-danger">*</span></label>
                        <select id="listing_owner" name="listing_owner" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
                            <option value="">Please select</option>
                            <?php
                            $listing_owners = [];
                            $owner_result = CRest::call('user.get', ['order' => ['NAME' => 'ASC']]);

                            $total_owners = $owner_result['total'];
                            $listing_owners = $owner_result['result'];

                            for ($i = 1; $i < ceil($total_owners / 50); $i++) {
                                $owner_response = CRest::call('user.get', ['order' => ['NAME' => 'ASC'], 'start' => $i * 50])['result'];
                                $listing_owners = array_merge($listing_owners, $owner_response);
                            }

                            if (empty($listing_owners)) {
                                echo '<option disabled>No owners found</option>';
                            } else {
                                foreach ($listing_owners as $owner) {
                                    $name = $owner['NAME'] . ' ' . $owner['LAST_NAME'];
                                    echo '<option value="' . $name . '">' . $name . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary" id="transferOwnerBtn">
                            Transfer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    async function updateItem(entityTypeId, fields, id) {
        try {
            const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.update?entityTypeId=${entityTypeId}&id=${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    fields
                })
            });

            if (!response.ok) throw new Error('Failed to update item');
            console.log('Item updated successfully');
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function getOwner(ownerId) {
        const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list?entityTypeId=1040&filter[ufCrm14OwnerId]=${ownerId}`);
        return (await response.json()).result.items[0] || null;
    }

    async function handleTransferOwnerSubmit(e) {
        document.getElementById("transferOwnerBtn").disabled = true;
        document.getElementById("transferOwnerBtn").innerHTML = 'Transferring...';

        e.preventDefault();

        const formData = new FormData(e.target);

        const fields = {
            "ufCrm14ListingOwner": formData.get('listing_owner'),
        };

        const propertyIds = formData.get('transferOwnerPropertyIds').split(',');

        for (const id of propertyIds) {
            await updateItem(1052, fields, Number(id));
            await addHistory(881, 1052, id, "Property", changedById, changedByName, `Transferred to ${formData.get('listing_owner')}`);
        }

        window.location.href = '?page=properties';
    }
</script>