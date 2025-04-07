<div class="modal fade" id="deleteArchivedProductModal" tabindex="-1" aria-labelledby="deleteArchivedProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteArchivedProductModalLabel">Enter Password to Permanently Delete Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="permanentlyDeleteArchivedProduct">
      <div class="modal-body">
        <input type="hidden" id="deleteArchivedProductId">
          <div class="mb-3">
            <label for="deleteArchivedPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="deleteArchivedPasswordInput" name="delete_password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>