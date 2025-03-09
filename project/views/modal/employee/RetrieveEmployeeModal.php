<div class="modal fade" id="retrieveEmployeeModal" tabindex="-1" aria-labelledby="retrieveEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveEmployeeModalLabel">Edit Employee Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="employeeId">

          <div class="mb-3">
            <label for="editedFirstNameInput" class="form-label text-capitalize">First Name</label>
            <input type="text" class="form-control" id="editedFirstNameInput" name="first_name" required>
          </div>

          <div class="mb-3">
            <label for="editedMiddleNameInput" class="form-label text-capitalize">Middle Initial</label>
            <input type="text" class="form-control" id="editedMiddleNameInput" name="middle_name" required>
          </div>

          <div class="mb-3">
            <label for="editedLastNameInput" class="form-label text-capitalize">Last Name</label>
            <input type="text" class="form-control" id="editedLastNameInput" name="last_name" required>
          </div>

          <div class="mb-3">
            <label for="editedWorkingDepartmentInput" class="form-label text-capitalize">Working Deparment</label>
            <input type="text" class="form-control" id="editedWorkingDepartmentInput" name="working_department" required>
          </div>

          <div class="mb-3">
            <label for="editedPhoneNumberInput" class="form-label text-capitalize">phone number</label>
            <input type="text" class="form-control" id="editedPhoneNumberInput" name="phone_number" required>
          </div>

          <div class="mb-3">
            <label for="editedDateOfHireInput" class="form-label text-capitalize">date of hire</label>
            <input type="date" class="form-control" id="editedDateOfHireInput" name="phone_number" required>
          </div>

          <div class="mb-3">
            <label for="editedJobInput" class="form-label text-capitalize">Job</label>
            <input type="text" class="form-control" id="editedJobInput" name="job" required>
          </div>

          <div class="mb-3">
            <label for="editedEducationalLevelInput" class="form-label text-capitalize">educational level</label>
            <input type="text" class="form-control" id="editedEducationalLevelInput" name="educational_level" required>
          </div>

          <div class="mb-3">
            <label for="genderInput" class="form-label text-capitalize">gender</label>
            <select class="form-select" id="editedGenderInput" name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="dateOfBirthInput" class="form-label text-capitalize">date of birth</label>
            <input type="date" class="form-control" id="dateOfBirthInput" name="date_of_birth" required>
          </div>

          <div class="mb-3">
            <label for="salaryInput" class="form-label text-capitalize">salary</label>
            <input type="number" class="form-control" id="salaryInput" name="salary" required>
          </div>
       </div>
       <div class="modal-footer">
            <button type="button" id="editProduct" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>