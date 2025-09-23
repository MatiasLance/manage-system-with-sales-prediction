<div class="modal fade" id="askPasswordOnRestoreNewsModal" tabindex="-1" aria-labelledby="askPasswordOnRestoreNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnRestoreNewsModalLabel">Enter Password to Restore News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="restoreNewsId" name="id">
          <div class="mb-3">
            <label for="restoreNewsPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="restoreNewsPasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="restoreNewsFromArchived" class="btn btn-golden-wheat btn-sm">Submit</button>
       </div>
    </div>
  </div>
</div>