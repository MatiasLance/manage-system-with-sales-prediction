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

<div class="container inventory-content">
    <ul class="nav nav-tabs mb-5 justify-content-center" id="myTab" role="tablist">
        <!-- Products Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                Manage Products
            </button>
        </li>

        <!--Sales -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="inventory-sales-data-tab" data-bs-toggle="tab" data-bs-target="#inventory-sales-data-tab-pane" type="button" role="tab" aria-controls="inventory-sales-data-tab-pane" aria-selected="false">
                Manage Sales
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
            <ul class="nav nav-underline mb-5 justify-content-center" id="myTabOne" role="tablist">
                <!-- Dairy Products Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link product-link active" id="inventory-dairy-product-tab" data-bs-toggle="tab" data-bs-target="#inventory-dairy-product-tab-pane" type="button" role="tab" aria-controls="inventory-dairy-product-tab-pane" aria-selected="true">
                        Dairy Products
                    </button>
                </li>
                <!-- Grains & Cereals Products Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link product-link" id="inventory-grain-and-cereals-product-tab" data-bs-toggle="tab" data-bs-target="#inventory-grain-and-cereals-product-tab-pane" type="button" role="tab" aria-controls="inventory-grain-and-cereals-product-tab-pane" aria-selected="false">
                        Grains & Cereals
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabOneContent">
                <!-- Dairy Products -->
                <?php include __DIR__ . '/products-tab/inventory-dairy-tabs.php'; ?>
                <!-- Grains & Cereals -->
                <?php include __DIR__ . '/products-tab/inventory-grains-and-cereals-tabs.php'; ?>
            </div> 
        </div>
        <!-- Sales -->
        <?php include __DIR__ . '/sales-tab/inventory-sales-tab.php'; ?>
    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>

<!-- Modal -->
<?php
include __DIR__ . '/../modal/product/AddProductModal.php';
include __DIR__ . '/../modal/product/AddProductNameModal.php';
include __DIR__ . '/../modal/product/AskPasswordOnProductConfirmDeletionModal.php';
include __DIR__ . '/../modal/product/AskPasswordOnProductNameConfirmDeletionModal.php';
include __DIR__ . '/../modal/product/RetrieveProductModal.php';
include __DIR__ . '/../modal/product/RetrieveProductNameModal.php';
include __DIR__ . '/../modal/product/DeleteProductModal.php';
include __DIR__ . '/../modal/product/DeleteProductNameModal.php';
include __DIR__ . '/../modal/RestoreArchivedProductModal.php';
include __DIR__ . '/../modal/DeleteArchivedProductModal.php';
?>

