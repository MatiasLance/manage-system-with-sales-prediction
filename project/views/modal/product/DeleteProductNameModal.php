<div class="modal fade" id="deleteProductNameModal" tabindex="-1" aria-labelledby="deleteProductNameModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold" id="deleteProductNameModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light text-center">
        <input type="hidden" id="productNameToBeDeletedId">
        <p class="fs-6 text-muted">Are you sure you want to delete <strong id="productNameToBeDeleted"></strong>? This action cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-golden-wheat btn-sm px-4" data-bs-toggle="modal" data-bs-target="#askPasswordOnProductNameConfirmDeletionModal">Delete</button>
      </div>
    </div>
  </div>
</div>
