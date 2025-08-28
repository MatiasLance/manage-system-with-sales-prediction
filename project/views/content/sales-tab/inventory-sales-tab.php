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

    <div class="d-flex flex-row justify-content-between">
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20">
                            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
                        </svg>
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