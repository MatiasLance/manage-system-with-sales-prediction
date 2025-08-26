<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img id="sideBarMenuLogo" src="<?php echo isset($_SESSION['sidebar_menu_logo']) ? $_SESSION['sidebar_menu_logo']: 'https://i.imgur.com/3LvoZ6D.png'?>" alt="Goat Farm">
    </div>
    <nav class="nav flex-column">
        <?php if($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'manager') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span style="transform: translateY(2px);">Dashboard</span>
        </a>
        <?php } ?>
        <?php if($_SESSION['user_role'] === 'admin') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/products">
            <i class="fas fa-box"></i>
            <span style="transform: translateY(2px);">Products</span>
        </a>
        <a class="nav-link d-flex align-items-center gap-2" href="/employees">
            <i class="fas fa-users"></i>
            <span style="transform: translateY(2px);">Employees</span>
        </a>
        <a class="nav-link d-flex align-items-center gap-2" href="/sales">
            <i class="fas fa-chart-line"></i>
            <span style="transform: translateY(2px);">Sales</span>
        </a>
        <?php } ?>
        <?php if($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'manager') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/bookings">
            <i class="fas fa-book"></i>
            <span style="transform: translateY(2px);">Bookings</span>
        </a>
        <?php } ?>
        <?php if($_SESSION['user_role'] === 'admin') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/news">
            <i class="fas fa-newspaper"></i>
            <span style="transform: translateY(2px);">News</span>
        </a>
        <?php } ?>
        <?php if($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'manager') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/inventory">
            <i class="fas fa-warehouse"></i>
            <span style="transform: translateY(2px);">Inventory</span>
        </a>
        <?php } ?>
        <?php if($_SESSION['user_role'] === 'admin') { ?>
        <a class="nav-link d-flex align-items-center gap-2" href="/users">
            <i class="fas fa-user"></i>
            <span style="transform: translateY(2px);">Users</span>
        </a>
        <?php } ?>
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

<div class="container product-content">
    <ul class="nav nav-tabs mb-5 justify-content-center" id="myTab" role="tablist">
        <!-- Products Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                Products
            </button>
        </li>
        <!-- Products Name Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="product-name-tab" data-bs-toggle="tab" data-bs-target="#product-name-tab-pane" type="button" role="tab" aria-controls="product-name-tab-pane" aria-selected="false">
                Product (Names, Code, & Category)
            </button>
        </li>

        <!--Archived Data -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="archived-data-tab" data-bs-toggle="tab" data-bs-target="#archived-data-tab-pane" type="button" role="tab" aria-controls="archived-data-tab-pane" aria-selected="false">
                Archived Products
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
            <ul class="nav nav-underline mb-5 justify-content-center" id="myTabOne" role="tablist">
                <!-- Dairy Products Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link product-link active" id="dairy-product-tab" data-bs-toggle="tab" data-bs-target="#dairy-product-tab-pane" type="button" role="tab" aria-controls="dairy-tab-pane" aria-selected="true">
                        Dairy Products
                    </button>
                </li>
                <!-- Grains & Cereals Products Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link product-link" id="grain-and-cereals-product-tab" data-bs-toggle="tab" data-bs-target="#grain-and-cereals-product-tab-pane" type="button" role="tab" aria-controls="grain-and-cereals-product-tab-pane" aria-selected="false">
                        Grains & Cereals
                    </button>
                </li>
                <!-- Livestocks -->
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link product-link" id="live-stocks-product-tab" data-bs-toggle="tab" data-bs-target="#live-stocks-product-tab-pane" type="button" role="tab" aria-controls="live-stocks-product-tab-pane" aria-selected="false">
                        Livestocks
                    </button>
                </li> -->
            </ul>

            <div class="tab-content" id="myTabOneContent">
            <button type="button" class="btn btn-milk-white btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal" data-bs-auto-close="false">Add Product</button>
                <!-- Dairy Products -->
                <?php include __DIR__ . '/products-tab/dairy-tabs.php'; ?>
                <!-- Grains & Cereals -->
                <?php include __DIR__ . '/products-tab/grains-and-cereals-tabs.php'; ?>
                <!-- Livestocks -->
                <?php include __DIR__ . '/products-tab/livestocks-tabs.php'; ?>
            </div> 
        </div>
        <!-- Products Name & Code Tab Content -->
        <?php include __DIR__ . '/products-tab/name-and-code-tabs.php'; ?>
        <!-- Archived Products Tab Content -->
        <?php include __DIR__ . '/products-tab/archived-products-tabs.php'; ?>
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

