<div class="modal fade" id="userConfirmationDeleteModal" tabindex="-1" aria-labelledby="userConfirmationDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light text-center">
        <p class="fs-6 text-muted">Are you sure you want to delete <strong id="userFullName"></strong>? This action cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-golden-wheat btn-sm px-4" data-bs-toggle="modal" data-bs-target="#askPasswordOnUserDeletionModal">Delete</button>
      </div>
    </div>
  </div>
</div>
