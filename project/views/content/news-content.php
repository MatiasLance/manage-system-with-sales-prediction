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

<div class="container news-content">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addNewsModal" data-bs-auto-close="false">Add News</button>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
         <input type="text" id="search-news" class="form-control mb-3 w-50" placeholder="Search by news title or content..." aria-label="Search News"
            >
        <nav>
            <ul class="pagination mb-0 justify-content-center" id="news-pagination-links"></ul>
        </nav>
    </div>

    <div class="row" id="newsList">
    </div>

    <div id="no-news-message" class="text-center text-white d-none">
        <p>No news available. Please add some news.</p>
    </div>

    <div id="loading-spinner" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="no-results-message" class="text-center text-white d-none">
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

