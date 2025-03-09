<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addEmployeeModalLabel">Add Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <input type="hidden" name="action" value="create">

          <div class="mb-3">
            <label for="firstNameInput" class="form-label text-capitalize">First Name</label>
            <input type="text" class="form-control" id="firstNameInput" name="first_name" required>
          </div>

          <div class="mb-3">
            <label for="middleNameInput" class="form-label text-capitalize">Middle Initial</label>
            <input type="text" class="form-control" id="middleNameInput" name="middle_name" required>
          </div>

          <div class="mb-3">
            <label for="lastNameInput" class="form-label text-capitalize">Last Name</label>
            <input type="text" class="form-control" id="lastNameInput" name="last_name" required>
          </div>

          <div class="mb-3">
            <label for="workingDepartmentInput" class="form-label text-capitalize">Working Deparment</label>
            <input type="text" class="form-control" id="workingDepartmentInput" name="working_department" required>
          </div>

          <div class="mb-3">
            <label for="phoneNumberInput" class="form-label text-capitalize">phone number</label>
            <input type="text" class="form-control" id="phoneNumberInput" name="phone_number" required>
          </div>

          <div class="mb-3">
            <label for="dateOfHireInput" class="form-label text-capitalize">date of hire</label>
            <input type="date" class="form-control" id="dateOfHireInput" name="phone_number" required>
          </div>

          <div class="mb-3">
            <label for="jobInput" class="form-label text-capitalize">Job</label>
            <input type="text" class="form-control" id="jobInput" name="job" required>
          </div>

          <div class="mb-3">
            <label for="educationalLevelInput" class="form-label text-capitalize">educational level</label>
            <input type="text" class="form-control" id="educationalLevelInput" name="educational_level" required>
          </div>

          <div class="mb-3">
            <label for="genderInput" class="form-label text-capitalize">gender</label>
            <select class="form-select" id="genderInput" name="gender" required>
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
            <button type="button" id="addProduct" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>