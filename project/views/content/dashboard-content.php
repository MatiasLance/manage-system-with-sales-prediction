<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img id="sideBarMenuLogo" src="<?php echo isset($_SESSION['sidebar_menu_logo']) ? $_SESSION['sidebar_menu_logo']: 'https://i.imgur.com/3LvoZ6D.png'?>" alt="Goat Farm" accept="image/*">
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="#"><i class="fas fa-box"></i> Products</a>
        <a class="nav-link" href="#"><i class="fas fa-users"></i> Employees</a>
        <a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Sales</a>
        <a class="nav-link" href="#"><i class="fas fa-book"></i> Bookings</a>
        <a class="nav-link" href="#"><i class="fas fa-newspaper"></i> News</a>
        <a class="nav-link" href="#"><i class="fas fa-warehouse"></i> Inventory</a>
        <div class="dropdown-center">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent" data-bs-auto-close="false" href="#"><i class="fas fa-cog"></i> Settings</a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageSystemLogoModal">Manage System Logo</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Manage System Theme</a>
                </li>
            </ul>
        </div>
        <span class="nav-link logout "><i class="fas fa-sign-out-alt"></i> Logout</span>
    </nav>
</div>

<!-- Overlay -->
<div id="overlay" class="overlay"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container-fluid padding-custom">
        <i class="fas fa-bars me-3" id="menuToggle"></i>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-capitalize" href="#" role="button">
                        <i class="fas fa-user me-2"></i><?= $_SESSION['firstname']; ?>
                    </a>
                </li>
            </ul>
    </div>
</nav>

<!-- Dashboard Content -->
<div id="content" class="content container-fluid p-4">
    <div class="row align-items-start g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-custom-primary text-white">
                    Products
                </div>
                <div class="card-body">
                    <ul id="product-list" class="list-group">
                        <!-- Content dynamically loaded -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-custom-brown text-white">
                    Employees
                </div>
                <div class="card-body">
                    <ul id="employee-list" class="list-group">
                        <!-- Content dynamically loaded -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-custom-gold text-white">
                    Sales Graph
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php include __DIR__ . '/../modal/ManageSystemLogoModal.php' ?>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>