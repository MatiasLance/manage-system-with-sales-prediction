<div class="modal fade" id="viewOrderDetailModal" tabindex="-1" aria-labelledby="viewOrderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewOrderDetailModalLabel">Order Detail</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="viewOrderNumber" class="form-label text-capitalize">Order #</label>
            <input type="text" class="form-control" id="viewOrderNumber" readonly>
          </div>

          <div class="mb-3">
            <label for="viewOrderQuantity" class="form-label text-capitalize">Quantity</label>
            <input type="text" class="form-control" id="viewOrderQuantity" readonly>
          </div>

          <div class="mb-3">
              <label for="viewOrderProductName" class="form-label text-capitalize">Product Name</label>
              <input type="text" class="form-control" id="viewOrderProductName" readonly>
          </div>

          <div class="mb-3">
            <label for="viewOrderPrice" class="form-label text-capitalize">Price</label>
            <input type="text" class="form-control" id="viewOrderPrice" readonly>
          </div>

          <div class="mb-3">
            <label for="viewUnitOfPrice" class="form-label text-capitalize">Unit of Price</label>
            <input type="text" class="form-control" id="viewUnitOfPrice" readonly>
          </div>

          <div class="mb-3">
            <label for="viewTaxAmount" class="form-label text-capitalize">Tax Amount</label>
            <input type="text" class="form-control" id="viewTaxAmount" readonly>
          </div>

          <div class="mb-3">
            <label for="viewOrderDateSold" class="form-label text-capitalize">Date Sold</label>
            <input type="text" class="form-control" id="viewOrderDateSold" readonly>
          </div>

      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Close</button>
       </div>
    </div>
  </div>
</div>