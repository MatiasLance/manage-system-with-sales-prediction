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
    <button type="button" class="btn btn-milk-white btn-sm mb-4">Create Product</button>
    <!-- Search Input -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search...">

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Sample Data -->
                <tr><td>1</td><td>Goat Milk</td><td>Dairy</td><td>$5</td></tr>
                <tr><td>2</td><td>Cheese</td><td>Dairy</td><td>$12</td></tr>
                <tr><td>3</td><td>Horse Feed</td><td>Animal Feed</td><td>$20</td></tr>
                <tr><td>4</td><td>Fish Food</td><td>Animal Feed</td><td>$15</td></tr>
                <tr><td>5</td><td>Organic Yogurt</td><td>Dairy</td><td>$8</td></tr>
                <tr><td>6</td><td>Farm Fresh Eggs</td><td>Poultry</td><td>$4</td></tr>
                <tr><td>7</td><td>Cow Feed</td><td>Animal Feed</td><td>$18</td></tr>
                <tr><td>8</td><td>Butter</td><td>Dairy</td><td>$10</td></tr>
                <tr><td>9</td><td>Fresh Milk</td><td>Dairy</td><td>$6</td></tr>
                <tr><td>10</td><td>Honey</td><td>Organic</td><td>$14</td></tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#" id="prevPage">Previous</a></li>
            <li class="page-item disabled"><a class="page-link" href="#" id="currentPage">1</a></li>
            <li class="page-item"><a class="page-link" href="#" id="nextPage">Next</a></li>
        </ul>
    </nav>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>