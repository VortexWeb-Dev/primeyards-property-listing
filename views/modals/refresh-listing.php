<!-- Modal for updating reference number -->
<div class="modal fade" id="referenceModal" tabindex="-1" aria-labelledby="referenceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referenceModalLabel">Update Reference Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="referenceForm" onsubmit="handleUpdateReference(event)">
                    <div class="mb-3">
                        <label for="newReference" class="form-label">New Reference Number</label>
                        <input type="text" class="form-control" id="newReference" name="newReference" required>
                    </div>
                    <input type="hidden" id="propertyId" name="propertyId" value="">
                    <button type="submit" class="btn btn-primary">Save Reference</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('referenceModal').addEventListener('shown.bs.modal', function(event) {
        var button = event.relatedTarget;
        var propertyId = button.getAttribute('data-property-id');
        var reference = button.getAttribute('data-reference');

        var propertyIdInput = document.getElementById('propertyId');
        var newReferenceInput = document.getElementById('newReference');

        propertyIdInput.value = propertyId;
        newReferenceInput.value = reference;
    });
</script>