<div class="modal fade" id="retrieveProductNameModal" tabindex="-1" aria-labelledby="retrieveProductNameModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveProductNameModalLabel">Edit Product (Name, Code, & Category)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="productNameId">
          <div class="mb-3">
              <label for="retrieveProductNameInput" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="retrieveProductNameInput" name="product_name">
          </div>
          <div class="mb-3">
            <label for="retrieveProductCodeInput" class="form-label text-capitalize">Product Code</label>
            <input type="text" class="form-control" id="retrieveProductCodeInput" name="product_code">
          </div>
          <div class="mb-3">
            <label for="retrieveProductCategoryInput" class="form-label text-capitalize">Select Product Category</label>
            <select class="form-select" id="retrieveProductCategoryInput" name="category" required>
                <option value="dairy">Dairy</option>
                <option value="grains and cereals">Grains & Cereals</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="editProductName" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
    </div>
  </div>
</div>