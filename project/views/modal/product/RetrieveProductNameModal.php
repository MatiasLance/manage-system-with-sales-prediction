<div class="modal fade" id="retrieveProductNameModal" tabindex="-1" aria-labelledby="retrieveProductNameModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveProductNameModalLabel">Edit Product Name</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="productNameId">
          <div class="mb-3">
              <label for="retrieveProductNameInput" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="retrieveProductNameInput" name="product_name">
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="editProductName" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
    </div>
  </div>
</div>