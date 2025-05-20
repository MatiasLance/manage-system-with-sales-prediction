<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img id="sideBarMenuLogo" src="<?php echo isset($_SESSION['sidebar_menu_logo']) ? $_SESSION['sidebar_menu_logo']: 'https://i.imgur.com/3LvoZ6D.png'?>" alt="Goat Farm">
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="/products"><i class="fas fa-box"></i> Products</a>
        <a class="nav-link" href="/employees"><i class="fas fa-users"></i> Employees</a>
        <a class="nav-link" href="/sales"><i class="fas fa-chart-line"></i> Sales</a>
        <a class="nav-link" href="/bookings"><i class="fas fa-book"></i> Bookings</a>
        <a class="nav-link" href="/news"><i class="fas fa-newspaper"></i> News</a>
        <a class="nav-link" href="/inventory"><i class="fas fa-warehouse"></i> Inventory</a>
        <!-- <span class="nav-link logout "><i class="fas fa-sign-out-alt"></i> Logout</span> -->
    </nav>
</div>

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

<div class="container sales-content">
    <div class="row align-items-start g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-week display-2 text-info"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Weekly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="weeklySales"></span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day display-2 text-success"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Monthly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="monthlySales"></span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar display-2 text-danger"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Yearly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="yearlySales">10,000,000</span>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="100"></canvas>
                </div>
            </div>
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
?>

