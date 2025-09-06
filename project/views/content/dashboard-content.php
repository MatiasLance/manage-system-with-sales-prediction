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


<!-- Dashboard Content -->
<div id="content" class="content container-fluid p-4">
    <div class="row align-items-start g-4">

        <div class="col-md-12">
            <div class="card shadow-sm border-0 bg-milk-white text-charcoal-gray">
                <div class="card-body text-center py-4">
                    <h2 class="card-title display-6 fw-bold">
                        Good day, <?= $_SESSION['firstname']; ?>! 👋
                    </h2>
                    <p class="card-text mt-2 lead">
                        Welcome to your admin dashboard. Here’s what’s happening today.
                    </p>
                </div>
            </div>
        </div>

        <?php if($_SESSION['user_role'] === 'admin') { ?>
        <div class="col-md-12">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body">
                    <canvas id="salesChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="80" height="80" class="text-dark-brown mb-2">
                        <!-- Font Awesome Icon -->
                        <path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Products</h3>
                    <p class="text-uppercase text-muted small mb-1 text-charcoal-dark">Total</p>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="totalProduct"></span>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/products" class="btn btn-dark-brown btn-sm px-4">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="80" height="80" 
                        class="text-golden-wheat mb-2" fill="currentColor">
                        <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Employees</h3>
                    <p class="text-uppercase text-muted small mb-1">Total</p>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="totalEmployees"></span>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/employees" class="btn btn-golden-wheat btn-sm px-4">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80" 
                    class="text-dark-green mb-2" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                    </svg>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-gray">Sales</h3>
                    <p class="text-uppercase text-muted small mb-1">Total</p>
                    <span class="fs-4 fw-semibold text-charcoal-gray" id="dashboardTotalSales"></span>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/sales" class="btn btn-dark-green btn-sm px-4">View All</a>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'manager') { ?>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-book text-sky-blue" style="font-size: 90px;"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">Bookings</h3>
                    <p class="text-uppercase text-muted small mb-1">Total</p>
                    <span class="fs-4 fw-semibold text-charcoal-dark" id="totalBookings"></span>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/bookings" class="btn btn-sky-blue btn-sm px-4">View All</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-warehouse text-forest-green" style="font-size: 90px;"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-gray">Inventory</h3>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/inventory" class="btn btn-forest-green btn-sm px-4">Manage</a>
                </div>
            </div>
        </div>
        <?php } ?>
    
        <?php if($_SESSION['user_role'] === 'admin') { ?>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-newspaper text-charcoal-gray" style="font-size: 90px;"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-gray">News</h3>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/news" class="btn btn-charcoal-gray btn-sm px-4">See More</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-user text-charcoal-gray" style="font-size: 90px;"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-gray">Users</h3>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <a href="/users" class="btn btn-charcoal-gray btn-sm px-4">Manage</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-milk-white">
                <div class="card-body text-center">
                    <i class="fas fa-cash-register text-golden-wheat" style="font-size: 90px;"></i>
                    <h3 class="text-capitalize mt-3 fw-bold text-charcoal-dark">POS</h3>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <span class="btn btn-golden-wheat btn-sm px-4" id="loginToPOS">Login</span>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>

<!-- Modal -->
<?php include __DIR__ . '/../modal/ManageSystemLogoModal.php' ?>