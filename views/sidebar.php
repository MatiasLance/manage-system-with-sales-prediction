<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img id="sideBarMenuLogo" src="<?php echo isset($_SESSION['sidebar_menu_logo']) ? $_SESSION['sidebar_menu_logo']: 'https://i.imgur.com/vlPX2XF.png'?>" alt="Goat Farm">
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
        <!-- <a class="nav-link d-flex align-items-center gap-2" href="/sales">
            <i class="fas fa-chart-line"></i>
            <span style="transform: translateY(2px);">Sales</span>
        </a> -->
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
        <a class="nav-link d-flex align-items-center gap-2" href="/login-history">
            <i class="bi bi-person-fill-lock" style="font-size: 20px;"></i>
            <span style="transform: translateY(2px);">Recently Login</span>
        </a>
        <?php } ?>
    </nav>
</div>