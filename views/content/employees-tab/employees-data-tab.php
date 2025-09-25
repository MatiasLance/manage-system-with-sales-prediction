<button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" data-bs-auto-close="false">Add Employee</button>

<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
    <input type="text" id="search-employee" class="form-control mb-3 w-50" placeholder="Search by name...">
    <nav>
        <ul class="pagination justify-content-center" id="employee-pagination-links"></ul>
    </nav>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
                <th scope="col">Full Name</th>
                <th scope="col">Working Department</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Date Hired</th>
                <th scope="col">Job</th>
                <th scope="col">Educational Level</th>
                <th scope="col">Gender</th>
                <th scope="col">Date of Birth</th>
                <!-- <th scope="col">Salary</th> -->
                <th scope="col">Email</th>
                <th class="col-1" scope="col" class="text-center">
                    Setting
                </th>
            </tr>
        </thead>
        <tbody id="employee-data-container"></tbody>
    </table>
</div>