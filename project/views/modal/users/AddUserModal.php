<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addUserModalLabel">Add User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="saveUserData">
      <div class="modal-body">
          <div class="mb-3">
            <label for="userFirstNameInput" class="form-label text-capitalize">First Name</label>
            <input type="text" class="form-control" id="userFirstNameInput" name="first_name" required>
          </div>

          <div class="mb-3">
            <label for="userLastNameInput" class="form-label text-capitalize">Last Name</label>
            <input type="text" class="form-control" id="userLastNameInput" name="last_name" required>
          </div>

          <div class="mb-3">
            <label for="userEmail" class="form-label text-capitalize">Email</label>
            <input type="email" class="form-control" name="user_email" id="userEmail" required>
          </div>

          <div class="mb-3">
            <label for="userRole" class="form-label text-capitalize">User Role</label>
            <select class="form-select" id="#userRole" name="user_role" aria-label="form-select-sm example" required>
                <option selected>Select User Role</option>
                <option value="admin">Admin</option>
                <option value="manager">Manager</option>
                <option value="cashier">Cashier</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="userPassword" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="user_password" id="userPassword" required>
              <span class="input-group-text" id="toggleEmployeePassword" style="cursor: pointer;">
                <i class="fas fa-eye"></i>
              </span>
            </div>
          </div>

          <div class="mb-3">
            <label for="userConfirmPassword" class="form-label">Confirm Password</label>
            <div class="input-group">
              <input type="password" class="form-control" name="user_confirm_password" id="userConfirmPassword" required>
              <span class="input-group-text" id="toggleEmployeeConfirmPassword" style="cursor: pointer;">
                <i class="fas fa-eye"></i>
              </span>
            </div>
          </div>

      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>