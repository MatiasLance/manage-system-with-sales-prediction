<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addProductModalLabel">Add Dairy Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addProduct" enctype="multipart/form-data">
        <div class="container-fluid px-0">
          <div class="row">

            <div class="col-6">
              <div class="mb-3">
                <label for="quantityInput" class="form-label text-capitalize">Quantity</label>
                <input type="number" class="form-control" id="quantityInput" name="quantity" required>
              </div>
            </div>

            <div class="col-6" id="selectDairyProductNameContainer">
              <div class="mb-3">
                  <label for="selectDairyProductNameInput" class="form-label">Select Product</label>
                  <select class="form-select" id="selectDairyProductNameInput" name="selected_product_name">
                    <option value="" selected>Select product</option>
                </select>
              </div>
            </div>

            <div class="col-6" id="selectGrainsAndCerealsProductNameContainer">
              <div class="mb-3">
                  <label for="selectGrainsAndCerealsProductNameInput" class="form-label">Select Product</label>
                  <select class="form-select" id="selectGrainsAndCerealsProductNameInput" name="selected_product_name">
                    <option value="" selected>Select product</option>
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="productCodeInput" class="form-label text-capitalize">Product Code</label>
                <input type="text" class="form-control" id="productCodeInput" placeholder="Auto generate code" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="productCategoryInput" class="form-label text-capitalize">Product Category</label>
                <input type="text" class="form-control text-capitalize" id="productCategoryInput" placeholder="Auto generate category" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="productDateProduceInput" class="form-label text-capitalize">Product Manufactured Date</label>
                <input type="date" class="form-control" id="productDateProduceInput" name="product_date_produce" required>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3" id="productDateExpirationInputContainer">
                <label for="productDateExpirationInput" class="form-label text-capitalize">Product Expiration Date</label>
                <input type="text" class="form-control" id="productDateExpirationInput" placeholder="Auto Generate Expiry Date" disabled>
              </div>
            </div>

            <div class="col-6">
              <label for="productPriceInput" class="form-label text-capitalize">Product Price</label>
              <input type="number" class="form-control" id="productPriceInput" name="product_price" required>
            </div>


              <div class="col-6 mb-3" id="diaryUnitOfPriceContainer">
                  <label for="dairyUnitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
                  <select class="form-select text-capitalize" id="dairyUnitOfPriceInput" name="unit_of_price">
                      <option value="liter">Liter (L)</option>
                      <option value="piece">Piece</option>
                      <option value="box">Box</option>
                  </select>
              </div>

              <div class="col-6 mb-3" id="grainsAndCerealsUnitOfPriceContainer">
                  <label for="grainsAndCerealsUnitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
                  <select class="form-select text-capitalize" id="grainsAndCerealsUnitOfPriceInput" name="unit_of_price">
                      <option value="kg">Kilogram (kg)</option>
                      <option value="sack">Sack</option>
                  </select>
              </div>

          </div>
        </div>

      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>
