<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold" id="deleteProductModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light text-center">
        <input type="hidden" id="deleteProductId">
        <p class="fs-6 text-muted">Are you sure you want to delete <strong id="productName"></strong>? This action cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="deleteProduct" class="btn btn-golden-wheat btn-sm px-4" data-bs-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
