<div class="modal fade" id="askPasswordOnNewsDeletionModal" tabindex="-1" aria-labelledby="askPasswordOnNewsDeletionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnNewsDeletionModalLabel">Enter Password to Confirm Deletion of News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="deleteNewsId" name="id">
          <div class="mb-3">
            <label for="deleteNewsPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="deleteNewsPasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="deleteNews" class="btn btn-golden-wheat btn-sm">Submit</button>
       </div>
    </div>
  </div>
</div>