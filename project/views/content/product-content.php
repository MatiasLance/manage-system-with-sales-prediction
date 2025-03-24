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
    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <!-- Products Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">
                Create Product
            </button>
        </li>
        <!-- Products Name Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="product-name-tab" data-bs-toggle="tab" data-bs-target="#product-name-tab-pane" type="button" role="tab" aria-controls="product-name-tab-pane" aria-selected="false">
                Add Product Names
            </button>
        </li>

        <!--Archived Data -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="archived-data-tab" data-bs-toggle="tab" data-bs-target="#archived-data-tab-pane" type="button" role="tab" aria-controls="archived-data-tab-pane" aria-selected="false">
                Archived Data
            </button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Products Tab Content -->
        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
            <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal" data-bs-auto-close="false">Create Product</button>
            
            <!-- Search Input -->
            <input type="text" id="searchProducts" class="form-control mb-3" placeholder="Search by name...">

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-milk-white">
                        <tr>
                            <th scope="col">Quantity</th>
                            <th scope="col">Name</th>
                            <th scope="col">Barcode</th>
                            <th scope="col">Date Produce</th>
                            <th scope="col">Date Expiration</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Unit of Price</th>
                            <th scope="col" class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20">
                                    <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                                </svg>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="data-container"></tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination justify-content-center" id="pagination-links"></ul>
            </nav>
        </div>

        <!-- Products Name Tab Content -->
        <div class="tab-pane fade" id="product-name-tab-pane" role="tabpanel" aria-labelledby="product-name-tab" tabindex="0">
        <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addProductNameModal" data-bs-auto-close="false">Add Product Name</button>
        
        <!-- Search for Product Name -->
        <input type="text" id="searchProductName" class="form-control mb-3" placeholder="Search by name...">

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-milk-white">
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col" class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20">
                                <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody id="product-name-data-container"></tbody>
            </table>
        </div>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination justify-content-center" id="product-name-pagination-links"></ul>
            </nav>

        </div>
    </div>

        <!-- Archived Data Tab Content -->
        <div class="tab-pane fade" id="archived-data-tab-pane" role="tabpanel" aria-labelledby="archived-data-tab" tabindex="0">
        <!-- Search for Product Name -->
        <input type="text" id="searchProductName" class="form-control mb-3" placeholder="Search by name...">

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-milk-white">
                    <tr>
                    <th scope="col">Quantity</th>
                        <th scope="col">Name</th>
                        <th scope="col">Barcode</th>
                        <th scope="col">Date Produce</th>
                        <th scope="col">Date Expiration</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Unit of Price</th>
                        <th scope="col" class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20">
                                <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                            </svg>
                        </th>
                    </tr>
                </thead>
                <tbody id="archived-data-container"></tbody>
            </table>
        </div>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination justify-content-center" id="archived-data-pagination-links"></ul>
            </nav>

        </div>
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
?>

