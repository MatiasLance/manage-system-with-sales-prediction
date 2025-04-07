<div class="modal fade" id="retrieveProductModal" tabindex="-1" aria-labelledby="retrieveProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveProductModalLabel">Edit Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="productId">
          <div class="mb-3">
            <label for="quantityInput" class="form-label text-capitalize">Quantity</label>
            <input type="number" class="form-control" id="retrieveQuantityInput" name="quantity">
          </div>

          <div class="mb-3">
              <label for="retrieveSelectedProductNameInput" class="form-label text-capitalize">Select Product</label>
              <select class="form-select" aria-label="Product Names" id="retrieveSelectedProductNameInput">
              </select>
          </div>

          <div class="mb-3">
            <label for="retrieveProductCategoryInput" class="form-label text-capitalize">Select Product Category</label>
            <select class="form-select" id="retrieveProductCategoryInput" name="category" required>
                <option value="dairy">Dairy Product</option>
                <option value="grains and cereals">Grains & Cereals</option>
                <option value="meat and poultry">Meat & Poultry</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="productDateProduceInput" class="form-label text-capitalize">Product Date Produce</label>
            <input type="date" class="form-control" id="retrieveProductDateProduceInput" name="product_date_produce">
          </div>

          <div class="mb-3">
            <label for="productDateExpirationInput" class="form-label text-capitalize">Product Date Expiration</label>
            <input type="text" class="form-control" id="retrieveProductDateExpirationInput" name="product_date_expiration" readonly="true" style="cursor: not-allowed;">
            <small class="mt-3"><strong>Note:</strong>The product expiration date will automatically update based on the selected production date.</small>
          </div>

          <div class="mb-3">
            <label for="productPriceInput" class="form-label text-capitalize">Product Price</label>
            <input type="number" class="form-control" id="retrieveProductPriceInput" name="product_price">
          </div>

          <div class="mb-3">
            <label for="unitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
            <select class="form-select text-capitalize" id="retrieveUnitOfPriceInput" name="unit_of_price">
                <option value="kg">Kilogram (kg)</option>
                <option value="lb">Pound (lb)</option>
                <option value="liter">Liter (L)</option>
                <option value="piece">Piece</option>
                <option value="box">Box</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="productStatusInput" class="form-label text-capitalize">Status</label>
            <input type="text" class="form-control text-capitalize" id="retrieveProductStatusInput" name="product_status" readonly="true" style="cursor: not-allowed;">
            <small class="mt-3"><strong>Note:</strong>The product status will automatically change when it reaches the 7-day timeframe, marking it as old stock.</small>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="editProduct" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>