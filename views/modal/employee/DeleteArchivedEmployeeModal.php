<div class="modal fade" id="deleteArchivedEmployeeModal" tabindex="-1" aria-labelledby="deleteArchivedEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteArchivedEmployeeModalLabel">Enter Password to Permanently Delete Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="permanentlyDeleteArchivedEmployee">
      <div class="modal-body">
        <input type="hidden" id="deleteArchivedEmployeeId">
          <div class="mb-3">
            <label for="deleteArchivedEmployeePasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="deleteArchivedEmployeePasswordInput" name="delete_password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>