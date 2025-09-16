<div class="modal fade" id="askPasswordOnEmployeeDeletionModal" tabindex="-1" aria-labelledby="askPasswordOnEmployeeDeletionModalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnEmployeeDeletionModalModalLabel">Enter Password to Confirm Deletion of Product Name</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="deleteEmployeeId" name="id">
          <div class="mb-3">
            <label for="employeePasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="employeePasswordInput" name="password" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="deleteEmployee" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Submit</button>
       </div>
    </div>
  </div>
</div>