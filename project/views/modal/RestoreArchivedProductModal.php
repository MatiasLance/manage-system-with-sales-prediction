<div class="modal fade" id="restoreArchivedProductModal" tabindex="-1" aria-labelledby="restoreArchivedProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="restoreArchivedProductModalLabel">Enter Password to restore product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="restoreArchivedProduct">
      <div class="modal-body">
        <input type="hidden" id="restoreArchivedProductId">
          <div class="mb-3">
            <label for="restoreArchivedPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="restoreArchivedPasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>