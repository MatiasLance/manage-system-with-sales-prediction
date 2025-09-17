<div class="d-flex flex-row-reverse justify-content-between mb-5">
    <button type="button" class="btn btn-milk-white btn-sm d-flex align-items-center gap-1" id="refreshLoginHistoryTable">
        <i class="bi bi-arrow-clockwise" style="font-size: 1.1rem; margin-top: 4px;"></i>
        <span>Refresh Table</span>
    </button>
</div>

<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
    <div class="input-group mb-3 w-50">
        <input type="text" class="form-control" id="searchLoginHistoryUsername" placeholder="Search by Username" aria-label="Search by username" aria-describedby="basic-addon2">
        <span class="input-group-text" id="basic-addon2">
            <i class="bi bi-search"></i>
        </span>
    </div>
    <nav>
        <ul class="pagination justify-content-center" id="login-history-pagination-links"></ul>
    </nav>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
            <th scope="col">Username</th>
            <th scope="col">User Agent</th>
            <th scope="col">Status</th>
            <th scope="col">Session Start</th>
            <th scope="col">Session End</th>
            </tr>
        </thead>
        <tbody id="login-history-data-container"></tbody>
    </table>
</div>