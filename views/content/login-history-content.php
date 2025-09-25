<?php include __DIR__ . '/../sidebar.php' ?>


<div id="overlay" class="overlay"></div>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container-fluid padding-custom">
        <i class="fas fa-bars me-3" id="menuToggle"></i>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#" role="button" id="logout" title="Logout here...">
                    <i class="fas fa-sign-out-alt me-2"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container login-history-content">
    <?php include __DIR__ . '/table/login-history-table.php' ?>
</div>

<?php include __DIR__ . '/../footer.php' ?>

