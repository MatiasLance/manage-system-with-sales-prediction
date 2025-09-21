<div class="modal fade" id="addDairyProductModal" tabindex="-1" aria-labelledby="addDairyProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addDairyProductModalLabel">Add Dairy Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addDairyProduct" enctype="multipart/form-data">
        <div class="container-fluid px-0">
          <div class="row">

            <div class="col-6">
              <div class="mb-3">
                <label for="dairyQuantityInput" class="form-label text-capitalize">Quantity</label>
                <input type="number" class="form-control" id="dairyQuantityInput" name="quantity" required>
              </div>
            </div>

            <div class="col-6" id="selectDairyProductNameContainer">
              <div class="mb-3">
                  <label for="selectDairyProductNameInput" class="form-label">Select Product</label>
                  <select class="form-select" id="selectDairyProductNameInput" name="selected_product_name" required>
                    <option value="" selected>Select product</option>
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="dairyProductCodeInput" class="form-label text-capitalize">Product Code</label>
                <input type="text" class="form-control" id="dairyProductCodeInput" placeholder="Auto generate code" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="dairyProductCategoryInput" class="form-label text-capitalize">Product Category</label>
                <input type="text" class="form-control text-capitalize" id="dairyProductCategoryInput" placeholder="Auto generate category" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="dairyProductDateProduceInput" class="form-label text-capitalize">Product Date Produce</label>
                <input type="date" class="form-control" id="dairyProductDateProduceInput" name="product_date_produce" required>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="dairyProductDateExpirationInput" class="form-label text-capitalize">Product Date Expiration</label>
                <input type="text" class="form-control" id="dairyProductDateExpirationInput" placeholder="Auto Generate Expiry Date" disabled>
              </div>
            </div>

            <div class="col-6">
              <label for="dairyProductPriceInput" class="form-label text-capitalize">Product Price</label>
              <input type="number" class="form-control" id="dairyProductPriceInput" name="product_price" required>
            </div>


              <div class="col-6 mb-3" id="diaryUnitOfPriceContainer">
                  <label for="dairyUnitOfPriceInput" class="form-label text-capitalize">Unit of Price</label>
                  <select class="form-select text-capitalize" id="dairyUnitOfPriceInput" name="unit_of_price">
                      <option value="liter">Liter (L)</option>
                      <option value="piece">Piece</option>
                      <option value="box">Box</option>
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
