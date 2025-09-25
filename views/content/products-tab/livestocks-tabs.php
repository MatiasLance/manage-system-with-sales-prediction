<!-- Livestocks -->
<div class="tab-pane fade" id="live-stocks-product-tab-pane" role="tabpanel" aria-labelledby="live-stocks-product-tab" tabindex="0">
    <!-- Search Input -->
    <input type="text" id="searchLivestocksProducts" class="form-control mb-3" placeholder="Search by name...">

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-milk-white">
                <tr>
                    <th scope="col">Species</th>
                    <th scope="col">Breed</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Date of Birth or Age</th>
                    <th scope="col">Unit of Price</th>
                    <th scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="livestocks-container"></tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <nav>
        <ul class="pagination justify-content-center" id="pagination-links"></ul>
    </nav>

</div>