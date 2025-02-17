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
        <!-- <div class="dropdown-center">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent" data-bs-auto-close="false" href="#"><i class="fas fa-cog"></i> Settings</a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#manageSystemLogoModal">Manage System Logo</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Manage System Theme</a>
                </li>
            </ul>
        </div> -->
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

<div class="container product-content">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal" data-bs-auto-close="false">Create Product</button>
    <!-- Search Input -->
    <input type="text" id="search-input" class="form-control mb-3" placeholder="Search by name...">

        <!-- Data Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
                <th scope="col">Quantity</th>
                <th scope="col">Name</th>
                <th scope="col">Barcode</th>
                <th scope="col">Date Produce</th>
                <th scope="col">Date Expiration</th>
                <th scope="col">Price</th>
                <th scope="col">Unit of Price</th>
            </tr>
        </thead>
        <tbody id="data-container"></tbody>
    </table>

    <!-- Pagination Controls -->
    <nav>
        <ul class="pagination justify-content-center" id="pagination-links"></ul>
    </nav>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>

<!-- Modal -->
<?php include __DIR__ . '/../modal/AddProductModal.php' ?>

