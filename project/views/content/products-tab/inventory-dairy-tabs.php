<!-- Dairy Products -->
<div class="tab-pane fade show active" id="inventory-dairy-product-tab-pane" role="tabpanel" aria-labelledby="inventory-dairy-product-tab" tabindex="0">

    <div class="d-flex flex-row justify-content-between">
        <!-- Filter Dairy Products -->
        <input type="text" id="searchProducts" class="form-control mb-3 w-50" placeholder="Search by name...">
        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center" id="pagination-links"></ul>
        </nav>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-milk-white">
                <tr>
                    <th scope="col">Total Quantity</th>
                    <th scope="col">Added Quantity</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Date Produce</th>
                    <th scope="col">Date Expiration</th>
                    <th scope="col">Price</th>
                    <th scope="col">Unit of Price</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="inventory-dairy-product-data-container"></tbody>
        </table>
    </div>
</div>