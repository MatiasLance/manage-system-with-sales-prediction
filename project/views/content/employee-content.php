<?php include __DIR__ . '/../sidebar.php' ?>
<!-- Overlay -->
<div id="overlay" class="overlay"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container-fluid padding-custom">
        <!-- Sidebar toggle -->
        <i class="fas fa-bars me-3" id="menuToggle"></i>

        <!-- Right-side nav links -->
        <ul class="navbar-nav ms-auto">
            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#" role="button" id="logout" title="Logout here...">
                    <i class="fas fa-sign-out-alt me-2"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container employee-content">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" data-bs-auto-close="false">Add Employee</button>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <input type="text" id="search-employee" class="form-control mb-3 w-50" placeholder="Search by name...">
        <nav>
            <ul class="pagination justify-content-center" id="employee-pagination-links"></ul>
        </nav>
    </div>

        <!-- Data Table -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
                <th scope="col">Full Name</th>
                <th scope="col">Working Department</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Date of Hire</th>
                <th scope="col">Job</th>
                <th scope="col">Educational Level</th>
                <th scope="col">Gender</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Salary</th>
                <th scope="col">Email</th>
                <th scope="col" class="text-center">
                    Setting
                </th>
            </tr>
        </thead>
        <tbody id="employee-data-container"></tbody>
    </table>
    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>

<!-- Modal -->
<?php
include __DIR__ . '/../modal/employee/AddEmployeeModal.php';
include __DIR__ . '/../modal/employee/RetrieveEmployeeModal.php';
include __DIR__ . '/../modal/employee/DeleteEmployeeModal.php';
include __DIR__ . '/../modal/employee/AskPasswordOnEmployeeDeletionModal.php';
?>

