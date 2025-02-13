<!-- Modal (Transfer to Agent) -->
<div class="modal fade" id="transferAgentModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferModalLabel">Transfer Property to Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transferAgentForm" onsubmit="handleTransferAgentSubmit(event)">
                    <input type="hidden" id="transferAgentPropertyIds" name="transferAgentPropertyIds">

                    <div class="form-group">
                        <label for="listing_agent" class="block text-sm font-medium mb-2">Listing Agent <span class="text-danger">*</span></label>
                        <select id="listing_agent" name="listing_agent" class="py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" required>
                            <option value="">Please select</option>
                            <?php
                            $agents_result = CRest::call('crm.item.list', [
                                'entityTypeId' => AGENTS_ENTITY_TYPE_ID,
                                'select' => ['ufCrm8AgentId', 'ufCrm8AgentName']
                            ]);
                            $listing_agents = $agents_result['result']['items'] ?? [];

                            if (empty($listing_agents)) {
                                echo '<option disabled>No agents found</option>';
                            } else {
                                foreach ($listing_agents as $agent) {
                                    echo '<option value="' . htmlspecialchars($agent['ufCrm8AgentId']) . '">' . htmlspecialchars($agent['ufCrm8AgentName']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary" id="transferAgentBtn">
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

    async function getAgent(agentId) {
        const response = await fetch(`https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z/crm.item.list?entityTypeId=1040&filter[ufCrm8AgentId]=${agentId}`);
        return (await response.json()).result.items[0] || null;
    }

    async function handleTransferAgentSubmit(e) {
        document.getElementById("transferAgentBtn").disabled = true;
        document.getElementById("transferAgentBtn").innerHTML = 'Transferring...';

        e.preventDefault();

        const formData = new FormData(e.target);
        const agent = await getAgent(formData.get('listing_agent'));
        if (!agent) return console.error('Agent not found');

        const fields = {
            "ufCrm14AgentId": agent.ufCrm8AgentId,
            "ufCrm14AgentName": agent.ufCrm8AgentName,
            "ufCrm14AgentEmail": agent.ufCrm8AgentEmail,
            "ufCrm14AgentPhone": agent.ufCrm8AgentMobile,
            "ufCrm14AgentPhoto": agent.ufCrm8AgentPhoto,
            "ufCrm14AgentLicense": agent.ufCrm8AgentLicense
        };

        const propertyIds = formData.get('transferAgentPropertyIds').split(',');

        for (const id of propertyIds) {
            await updateItem(1052, fields, Number(id));
            await addHistory(880, 1052, id, "Property", changedById, changedByName, `Transferred to ${agent.ufCrm8AgentName}`);
        }

        window.location.href = '?page=properties';
    }
</script>