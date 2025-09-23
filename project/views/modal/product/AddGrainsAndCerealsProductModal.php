<div class="modal fade" id="addGrainsAndCerealsProductModal" tabindex="-1" aria-labelledby="addGrainsAndCerealsProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addGrainsAndCerealsProductModalLabel">Add Grains And Cereals Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addGrainsAndCerealsProduct" enctype="multipart/form-data">
        <div class="container-fluid px-0">
          <div class="row">

            <div class="col-6">
              <div class="mb-3">
                <label for="grainsAndCerealsQuantityInput" class="form-label text-capitalize">Quantity</label>
                <input type="number" class="form-control" id="grainsAndCerealsQuantityInput" name="quantity" required>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                  <label for="selectGrainsAndCerealsProductNameInput" class="form-label">Select Product</label>
                  <select class="form-select" id="selectGrainsAndCerealsProductNameInput" name="selected_product_name" required>
                    <option value="" selected>Select product</option>
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="grainsAndCerealsProductCodeInput" class="form-label text-capitalize">Product Code</label>
                <input type="text" class="form-control" id="grainsAndCerealsProductCodeInput" placeholder="Auto generate code" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="grainsAndCerealsProductCategoryInput" class="form-label text-capitalize">Product Category</label>
                <input type="text" class="form-control text-capitalize" id="grainsAndCerealsProductCategoryInput" placeholder="Auto generate category" readonly="true" style="cursor: not-allowed">
              </div>
            </div>

            <div class="col-6">
              <div class="mb-3">
                <label for="grainsAndCerealsProductDateProduceInput" class="form-label text-capitalize">Product Date Produce</label>
                <input type="date" class="form-control" id="grainsAndCerealsProductDateProduceInput" name="product_date_produce" required>
              </div>
            </div>

            <div class="col-6">
              <label for="grainsAndCerealsProductPriceInput" class="form-label text-capitalize">Product Price</label>
              <input type="number" class="form-control" id="grainsAndCerealsProductPriceInput" name="product_price" required>
            </div>

            <div class="col-6 mb-3">
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
