<div class="d-flex flex-row justify-content-between mb-5">
    <div class="input-group w-50">
        <input type="text" class="form-control" id="filterSalesByDate">
        <label class="input-group-text" for="inputGroupSelect02">
            <i class="bi bi-funnel-fill"></i>
        </label>
    </div>
    <div class="d-flex align-items-center gap-3">
        <!-- Load All Data Button -->
        <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1" id="loadAllData">
            <i class="bi bi-arrow-clockwise" style="font-size: 1.1rem;"></i>
            <span>Load All Data</span>
        </button>

        <!-- Export CSV Icon (Styled as Button) -->
        <button type="button" class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" 
                id="exportCSV" title="Export to CSV">
            <i class="bi bi-filetype-csv" style="font-size: 1.1rem;"></i>
            <small>Export CSV</small>
        </button>
    </div>
</div>

<div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
    <div class="input-group mb-3 w-50">
        <input type="text" class="form-control" id="searchInventorySalesOrderNumber" placeholder="Search by Order number" aria-label="Search by Order number" aria-describedby="basic-addon2">
        <span class="input-group-text" id="basic-addon2">
            <i class="bi bi-search"></i>
        </span>
    </div>
    <nav>
        <ul class="pagination justify-content-center" id="inventory-sales-data-pagination-links"></ul>
    </nav>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="inventoryTable">
        <thead class="table-milk-white">
            <tr>
            <th scope="col">Order #</th>
            <th scope="col">Quantity</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Unit of Price</th>
            <th scope="col">Tax Amount</th>
            <th scope="col">Total</th>
            <th scope="col">Date Sold</th>
            </tr>
        </thead>
        <tbody id="inventory-sales-data-container"></tbody>
        <tfooter>
                <tr>
                <th colspan="6" class="text-end">Total Sales:</th>
                <th colspan="3" id="totalSalesAmount" class="text-start"></th>
            </tr>
        </tfooter>
    </table>
</div>