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

<div class="container sales-content">
    <div class="row align-items-start g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80" 
                        class="text-dark-green mb-2" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Weekly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="weeklySales"></span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80" 
                        class="text-dark-green mb-2" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Monthly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="monthlySales"></span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80" 
                        class="text-dark-green mb-2" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Yearly Sales</h3>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="yearlySales"></span>
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

