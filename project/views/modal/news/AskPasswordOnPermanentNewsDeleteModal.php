<div class="modal fade" id="askPasswordOnNewsPermanentDeletionModal" tabindex="-1" aria-labelledby="askPasswordOnNewsPermanentDeletionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnNewsPermanentDeletionModalLabel">Enter Password to Permanently Delete this News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="permanentDeleteNewsId" name="id">
          <div class="mb-3">
            <label for="permanentDeleteNewsPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="permanentDeleteNewsPasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="permanentDeleteArchivedNews" class="btn btn-golden-wheat btn-sm">Submit</button>
       </div>
    </div>
  </div>
</div>