<div class="modal fade" id="askPasswordOnUserDeletionModal" tabindex="-1" aria-labelledby="askPasswordOnUserDeletionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnUserDeletionModalLabel">Enter your password to confirm user deletion.</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="deleteUserId" name="id">
          <div class="mb-3">
            <label for="deleteUserPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="deleteUserPasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="deleteUser" class="btn btn-golden-wheat btn-sm">Submit</button>
       </div>
    </div>
  </div>
</div>