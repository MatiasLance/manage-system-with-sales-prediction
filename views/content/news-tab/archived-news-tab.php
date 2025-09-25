<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <input type="text" id="search-archived-news" class="form-control mb-3 w-50" placeholder="Search by news title or content..." aria-label="Search News"
        >
    <nav>
        <ul class="pagination mb-0 justify-content-center" id="archived-news-pagination-links"></ul>
    </nav>
</div>

<div class="row" id="archivedNewsList">
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