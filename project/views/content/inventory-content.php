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

<div class="container inventory-content">
    <!-- Sales -->
    <?php include __DIR__ . '/sales-tab/inventory-sales-tab.php'; ?>
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
include __DIR__ . '/../modal/ViewOrderDetailModal.php';
?>

