<div class="modal fade" id="addProductNameModal" tabindex="-1" aria-labelledby="addProductNameModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addProductNameModalLabel">Add Product (Name, Code, & Category)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
            <label for="productNameInput" class="form-label text-capitalize">Product Name</label>
            <input type="text" class="form-control" id="productNameInput" name="product_name" required>
          </div>
          <div class="mb-3">
            <label for="productNameCodeInput" class="form-label text-capitalize">Product Code</label>
            <input type="text" class="form-control" id="productNameCodeInput" name="product_code" required>
          </div>
          <div class="mb-3">
            <label for="productCategorySelect" class="form-label text-capitalize">Select Category</label>
            <select class="form-select" id="productCategorySelect" name="category" required>
                <option value="" disabled selected>Select Product Category</option>
                <option value="dairy">Dairy</option>
                <option value="grains and cereals">Grains & Cereals</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" id="addProductName" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
    </div>
  </div>
</div>