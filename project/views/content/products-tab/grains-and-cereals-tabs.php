<!-- Grains & Cereals -->
<div class="tab-pane fade" id="grain-and-cereals-product-tab-pane" role="tabpanel" aria-labelledby="grain-and-cereals-product-tab" tabindex="0">

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <!-- Filter Dairy Products -->
        <input type="text" id="searchGrainsAndCerealsProducts" class="form-control mb-3 w-50" placeholder="Search by name...">
        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center" id="grains-and-cereals-pagination-links"></ul>
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
                    <th scope="col">Date Purchase</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="grains-and-cereals-container"></tbody>
        </table>
    </div>
</div>