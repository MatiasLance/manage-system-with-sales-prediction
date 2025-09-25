<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addEmployeeModalLabel">Add Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="saveEmployeeData" enctype="multipart/form-data">
          <div class="container-fluid px-0">
            <div class="row">

              <div class="col-6 mb-3">
                  <label for="firstNameInput" class="form-label text-capitalize">First Name</label>
                  <input type="text" class="form-control" id="firstNameInput" name="first_name" required>
              </div>

              <div class="col-6 mb-3">
                  <label for="middleNameInput" class="form-label text-capitalize">Middle Initial</label>
                  <input type="text" class="form-control" id="middleNameInput" name="middle_initial" placeholder="Optional">
              </div>

              <div class="col-6 mb-3">
                  <label for="lastNameInput" class="form-label text-capitalize">Last Name</label>
                  <input type="text" class="form-control" id="lastNameInput" name="last_name" required>
              </div>

              <div class="col-6 mb-3">
                  <label for="workingDepartmentInput" class="form-label text-capitalize">working department</label>
                  <select class="form-select" id="workingDepartmentInput" name="working_department" required>
                      <option value="" disabled selected>Select Working Department</option>
                      <option value="Crop Production Department">Crop Production Department</option>
                      <option value="Livestock Management Department">Livestock Management Department</option>
                      <option value="Equipment & Maintenance Department">Equipment & Maintenance Department</option>
                      <option value="Warehouse & Inventory Management">Warehouse & Inventory Management</option>
                      <option value="Sales & Marketing Department">Sales & Marketing Department</option>
                      <option value="Finance & Accounting">Finance & Accounting</option>
                      <option value="Research & Development">Research & Development</option>
                      <option value="Human Resources & Administration">Human Resources (HR) & Administration</option>
                      <option value="Quality Control & Compliance">Quality Control & Compliance</option>
                      <option value="Logistics & Distribution">Logistics & Distribution</option>
                  </select>
              </div>

              <div class="col-6 mb-3">
                  <label for="phoneNumberInput" class="form-label text-capitalize">phone number</label>
                  <input type="text" class="form-control" id="phoneNumberInput" name="phone_number" required>
              </div>

              <div class="col-6 mb-3">
                  <label for="dateOfHireInput" class="form-label text-capitalize">date of hire</label>
                  <input type="date" class="form-control" id="dateOfHireInput" name="date_of_hire" required>
              </div>

              <div class="col-6 mb-3">
                  <label for="jobInput" class="form-label text-capitalize">job</label>
                  <select class="form-select" id="jobInput" name="job" required>
                      <option value="" disabled selected>Select Job</option>
                      <option value="Agronomist">Agronomist</option>
                      <option value="Field Supervisor">Field Supervisor</option>
                      <option value="Farm Laborer/Field Worker">Farm Laborer/Field Worker</option>
                      <option value="Livestock Manager">Livestock Manager</option>
                      <option value="Veterinarian">Veterinarian</option>
                      <option value="Animal Technician">Animal Technician</option>
                      <option value="Equipment Operator">Equipment Operator</option>
                      <option value="Mechanic/Technician">Mechanic/Technician</option>
                      <option value="Welders/Fabricators">Welders/Fabricators</option>
                      <option value="Storekeeper/Warehouse Supervisor">Storekeeper/Warehouse Supervisor</option>
                      <option value="Logistics Coordinator">Logistics Coordinator</option>
                      <option value="Farm Sales Representative">Farm Sales Representative</option>
                      <option value="Marketing Coordinator">Marketing Coordinator</option>
                      <option value="Product Grader/Sorter">Product Grader/Sorter</option>
                      <option value="Agricultural Scientist ">Agricultural Scientist </option>
                      <option value="Soil Scientist">Soil Scientist</option>
                      <option value="Farm Administrator">Farm Administrator</option>
                      <option value="Human Resources Office">Human Resources Office</option>
                      <option value="Aquaculture Technician">Aquaculture Technician</option>
                      <option value="Greenhouse Operator">Greenhouse Operator</option>
                      <option value="Financial Analyst">Financial Analyst</option>
                      <option value="Investment Banker ">Investment Banker </option>
                      <option value="Financial Planner">Financial Planner</option>
                      <option value="Risk Manager">Risk Manager</option>
                      <option value="Treasury Analyst">Treasury Analyst</option>
                      <option value="Accountant">Accountant</option>
                      <option value="Auditor">Auditor</option>
                      <option value="Bookkeeper">Bookkeeper</option>
                      <option value="Tax Consultant">Tax Consultant</option>
                      <option value="Payroll Specialist">Payroll Specialist</option>
                  </select>
              </div>

              <div class="col-6 mb-3">
                  <label for="educationalLevelInput" class="form-label text-capitalize">educational attainment</label>
                  <select class="form-select" id="educationalLevelInput" name="educational_level" required>
                      <option value="" selected>Select Educational Attainment</option>
                      <option value="College">College</option>
                      <option value="Senior High School">Senior High School</option>
                      <option value="Basic Education (K-12)">Basic Education (K-12)</option>
                      <option value="Technical-Vocational Education and Training (TVET)">Technical-Vocational Education and Training (TVET)</option>
                      <option value="Alternative Learning System (ALS)">Alternative Learning System (ALS)</option>
                  </select>
              </div>

              <div class="col-6 mb-3">
                  <label for="genderInput" class="form-label text-capitalize">gender</label>
                  <select class="form-select" id="genderInput" name="gender" required>
                      <option value="" disabled selected>Select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                  </select>
              </div>

              <div class="col-6 mb-3">
                  <label for="dateOfBirthInput" class="form-label text-capitalize">date of birth</label>
                  <input type="date" class="form-control" id="dateOfBirthInput" name="date_of_birth" required>
              </div>

              <!-- <div class="col-6 mb-3">
                  <label for="salaryInput" class="form-label text-capitalize">salary</label>
                  <input type="number" class="form-control" id="salaryInput" name="salary" required>
              </div> -->

              <div class="col-6 mb-3">
                  <label for="employeeEmail" class="form-label text-capitalize">Email</label>
                  <input type="email" class="form-control" name="employee_email" id="employeeEmail" required>
              </div>

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