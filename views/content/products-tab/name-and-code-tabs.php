<!-- Products Name & Code Tab Content -->
<div class="tab-pane fade" id="product-name-tab-pane" role="tabpanel" aria-labelledby="product-name-tab" tabindex="0">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addProductNameModal" data-bs-auto-close="false">Add Product (Name, Code, & Category)</button>
        
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <!-- Filter Products Name and Code -->
        <input type="text" id="searchProductName" class="form-control mb-3 w-50" placeholder="Search by name or code">
        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center" id="product-name-pagination-links"></ul>
        </nav>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-milk-white">
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Product Category</th>
                    <th scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="product-name-data-container"></tbody>
        </table>
    </div>
</div>