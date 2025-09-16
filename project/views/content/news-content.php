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
    <ul class="nav nav-tabs mb-5 justify-content-center" id="newsTab" role="tablist">
        <!-- news Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news-tab-pane" type="button" role="tab" aria-controls="employees-tab-pane" aria-selected="true">
                News
            </button>
        </li>

        <!--Archived Data -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="archived-news-tab" data-bs-toggle="tab" data-bs-target="#archived-news-tab-pane" type="button" role="tab" aria-controls="archived-news-tab-pane" aria-selected="false">
                Archived News
            </button>
        </li>
    </ul>

    <div class="tab-content" id="newsTabContent">
        <div class="tab-pane fade show active" id="news-tab-pane" role="tabpanel" aria-labelledby="news-tab" tabindex="0">
            <?php include __DIR__ . '/./news-tab/news-data-tab.php' ?>
        </div>
        <div class="tab-pane fade" id="archived-news-tab-pane" role="tabpanel" aria-labelledby="archive-news-tab" tabindex="0">
            <?php include __DIR__ . '/./news-tab/archived-news-tab.php' ?>
        </div>
    </div>

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

