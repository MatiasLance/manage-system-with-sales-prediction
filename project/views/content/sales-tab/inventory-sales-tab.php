<!-- Inventory Sales Tab Content -->
<div class="tab-pane fade" id="inventory-sales-data-tab-pane" role="tabpanel" aria-labelledby="inventory-sales-data-tab" tabindex="0">

    <div class="row gx-5 mb-5">
        <!-- Weekly Sales Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 bg-milk-white">
                <div class="card-body p-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80"
                    class="text-dark-green mb-2" fill="currentColor">
                    <path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                </svg>

                <h5 class="card-title">Weekly Sales</h5>
                <h4 id="inventoryWeeklySales"></h4>
                </div>
            </div>
        </div>

        <!-- Monthly Sales Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 bg-milk-white">
                <div class="card-body p-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80"
                    class="text-dark-green mb-2" fill="currentColor">
                    <path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                </svg>

                <h5 class="card-title">Monthly Sales</h5>
                <h4 id="inventoryMonthlySales"></h4>
                </div>
            </div>
        </div>

        <!-- Yearly Sales Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 bg-milk-white">
                <div class="card-body p-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="80" height="80"
                    class="text-dark-green mb-2" fill="currentColor">
                    <path d="M64 32C46.3 32 32 46.3 32 64l0 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 64 0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 80 0c68.4 0 127.7-39 156.8-96l19.2 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-.7 0c.5-5.3 .7-10.6 .7-16s-.2-10.7-.7-16l.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-19.2 0C303.7 71 244.4 32 176 32L64 32zm190.4 96L96 128l0-32 80 0c30.5 0 58.2 12.2 78.4 32zM96 192l190.9 0c.7 5.2 1.1 10.6 1.1 16s-.4 10.8-1.1 16L96 224l0-32zm158.4 96c-20.2 19.8-47.9 32-78.4 32l-80 0 0-32 158.4 0z"/>
                </svg>

                <h5 class="card-title">Yearly Sales</h5>
                <h4 id="inventoryYearlySales"></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row justify-content-between mb-5">
        <div class="input-group w-50">
            <input type="text" class="form-control" id="filterSalesByDate">
            <label class="input-group-text" for="inputGroupSelect02">
                <i class="bi bi-funnel-fill"></i>
            </label>
        </div>
        <i class="bi bi-filetype-csv display-6" id="exportCSV" style="color: #fff; cursor: pointer;"></i>
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
                    <th scope="col" class="text-center">
                        Setting
                    </th>
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
</div>