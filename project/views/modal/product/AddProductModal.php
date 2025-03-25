<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addProductModalLabel">Add Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <input type="hidden" name="action" value="create">

          <div class="mb-3">
            <label for="quantityInput" class="form-label text-capitalize">Quantity</label>
            <input type="number" class="form-control" id="quantityInput" name="quantity" required>
          </div>

          <div class="mb-3">
              <label for="selectedProductNameInput" class="form-label">Select Product</label>
              <select class="form-select" id="selectedProductNameInput" name="selected_product_name" required>
                <option value="" disabled selected>Select product</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="productCategoryInput" class="form-label text-capitalize">Select Product Category</label>
            <select class="form-select" id="productCategoryInput" name="category" required>
                <option value="" disabled selected>Select Product Category</option>
                <option value="dairy">Dairy Product</option>
                <option value="grains and cereals">Grains & Cereals</option>
                <option value="meat and poultry">Meat & Poultry</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="productDateProduceInput" class="form-label text-capitalize">Product Date Produce</label>
            <input type="date" class="form-control" id="productDateProduceInput" name="product_date_produce" required>
          </div>

          <div class="mb-3">
            <label for="productDateExpirationInput" class="form-label text-capitalize">Product Date Expiration</label>
            <input type="text" class="form-control" id="productDateExpirationInput" placeholder="Auto Generate Expiry Date" disabled>
          </div>

          <div class="mb-3">
            <label for="productPriceInput" class="form-label text-capitalize">Product Price</label>
            <input type="number" class="form-control" id="productPriceInput" name="product_price" required>
          </div>

          <div class="mb-3">
            <label for="statusInput" class="form-label text-capitalize">Status</label>
            <select class="form-select" id="statusInput" name="product_status" required>
                <option value="" disabled selected>Select status</option>
                <option value="new">New</option>
                <option value="old">Old</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="unitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
            <select class="form-select" id="unitOfPriceInput" name="unit_of_price" required>
                <option value="" disabled selected>Select unit</option>
                <option value="kg">1(Liter)</option>
                <option value="lb">350(ml)</option>
             
            </select>
          </div>

      </div>
      <div class="modal-footer">
            <button type="button" id="addProduct" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>
