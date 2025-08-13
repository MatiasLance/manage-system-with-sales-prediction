<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img id="sideBarMenuLogo" src="<?php echo isset($_SESSION['sidebar_menu_logo']) ? $_SESSION['sidebar_menu_logo']: 'https://i.imgur.com/3LvoZ6D.png'?>" alt="Goat Farm">
    </div>
    <nav class="nav flex-column">
        <a class="nav-link d-flex align-items-center gap-2" href="/dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span style="transform: translateY(2px);">Dashboard</span>
        </a>
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
        <a class="nav-link d-flex align-items-center gap-2" href="/bookings">
            <i class="fas fa-book"></i>
            <span style="transform: translateY(2px);">Bookings</span>
        </a>
        <a class="nav-link d-flex align-items-center gap-2" href="/news">
            <i class="fas fa-newspaper"></i>
            <span style="transform: translateY(2px);">News</span>
        </a>
        <a class="nav-link d-flex align-items-center gap-2" href="/inventory">
            <i class="fas fa-warehouse"></i>
            <span style="transform: translateY(2px);">Inventory</span>
        </a>
        <a class="nav-link d-flex align-items-center gap-2" href="/users">
            <i class="fas fa-user"></i>
            <span style="transform: translateY(2px);">Users</span>
        </a>
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

<div class="container news-content">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addNewsModal" data-bs-auto-close="false">Add News</button>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-3 gap-2">
        <div class="flex-grow-1">
            <input 
                type="text" 
                id="search-news" 
                class="form-control"
                placeholder="Search by news title or content..." 
                aria-label="Search News"
            >
        </div>

        <nav class="mt-2 mt-md-0">
            <ul class="pagination mb-0 justify-content-center" id="news-pagination-links"></ul>
        </nav>
    </div>

    <div class="row" id="newsList">
    </div>

    <div id="no-news-message" class="text-center d-none">
        <p>No news available. Please add some news.</p>
    </div>

    <div id="loading-spinner" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="no-results-message" class="text-center d-none">
        <p>No results found for your search.</p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php' ?>

<?php
include __DIR__ . '/../modal/news/AddNewsModal.php';
include __DIR__ . '/../modal/news/RetrieveNewsModal.php';
include __DIR__ . '/../modal/news/DeleteNewsModal.php';
include __DIR__ . '/../modal/news/AskPasswordOnNewsDeletionModal.php';
?>

