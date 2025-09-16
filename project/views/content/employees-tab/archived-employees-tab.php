
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
    <input type="text" id="searchAchivedEmployees" class="form-control mb-3 w-50" placeholder="Search Employee Name...">
    <!-- Pagination Controls -->
    <nav>
        <ul class="pagination justify-content-center" id="archived-employees-pagination-links"></ul>
    </nav>
</div>

<!-- Data Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
            <th scope="col">Full Name</th>
            <th scope="col">Working Deparment</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Date of Hire</th>
            <th scope="col">Job</th>
            <th scope="col">Education Attainment</th>
            <th scope="col">Gender</th>
            <th scope="col">Date of Birth</th>
            <th scope="col">Salary</th>
            <th scope="col">Email</th>
            <th class="col-1" scope="col" class="text-center">
                Setting
            </th>
            </tr>
        </thead>
        <tbody id="archived-employee-container"></tbody>
    </table>
</div>
