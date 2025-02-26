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
            <label for="productNameInput" class="form-label text-capitalize">Product Name</label>
            <input type="text" class="form-control" id="productNameInput" name="product_name" required>
          </div>

          <div class="mb-3">
            <label for="productDateProduceInput" class="form-label text-capitalize">Product Date Produce</label>
            <input type="date" class="form-control" id="productDateProduceInput" name="product_date_produce" required>
          </div>

          <div class="mb-3">
            <label for="productDateExpirationInput" class="form-label text-capitalize">Product Date Expiration</label>
            <input type="date" class="form-control" id="productDateExpirationInput" name="product_date_expiration" required>
          </div>

          <div class="mb-3">
            <label for="productPriceInput" class="form-label text-capitalize">Product Price</label>
            <input type="number" class="form-control" id="productPriceInput" name="product_price" required>
          </div>

          <div class="mb-3">
            <label for="unitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
            <select class="form-select" id="unitOfPriceInput" name="unit_of_price" required>
                <option value="" disabled selected>Select unit</option>
                <option value="kg">Kilogram (kg)</option>
                <option value="lb">Pound (lb)</option>
                <option value="liter">Liter (L)</option>
                <option value="piece">Piece</option>
                <option value="box">Box</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="addProduct" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>