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
    <ul class="nav nav-tabs mb-5 justify-content-center" id="employeesTab" role="tablist">
        <!-- Employees Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees-tab-pane" type="button" role="tab" aria-controls="employees-tab-pane" aria-selected="true">
                Employees
            </button>
        </li>

        <!--Archived Data -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="archived-employees-tab" data-bs-toggle="tab" data-bs-target="#archived-employees-tab-pane" type="button" role="tab" aria-controls="archived-employees-tab-pane" aria-selected="false">
                Archived Employees
            </button>
        </li>
    </ul>

    <div class="tab-content" id="employeesTabContent">
        <div class="tab-pane fade show active" id="employees-tab-pane" role="tabpanel" aria-labelledby="employees-tab" tabindex="0">
            <?php include __DIR__ . '/./employees-tab/employees-data-tab.php' ?>
        </div>
        <div class="tab-pane fade" id="archived-employees-tab-pane" role="tabpanel" aria-labelledby="archive-employees-tab" tabindex="0">
            <?php include __DIR__ . '/./employees-tab/archived-employees-tab.php' ?>
        </div>
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
include __DIR__ . '/../modal/employee/DeleteArchivedEmployeeModal.php';
include __DIR__ . '/../modal/employee/RestoreArchivedEmployeeModal.php';
?>

