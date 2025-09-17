<div class="modal fade" id="retrieveProductBarcodeModal" tabindex="-1" aria-labelledby="retrieveProductBarcodeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveProductBarcodeModalLabel">Print Barcode</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-white">
          <div class="container-fluid px-0">
            <div class="row">

              <div class="col-12 text-center">
                  <img src="" class="img-fluid print-only" width="500" id="productBarcodeToPrint" alt="Product Barcode" readonly="true">
              </div>

            </div>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="printProductBarcode" class="btn btn-golden-wheat btn-sm d-flex align-item-center gap-2 flex-direction-row text-black"><i class="bi bi-upc-scan fs-4 text-black" style="margin-top: 5px;"></i><span style="margin-top: 5px;" class="fs-5">Print</span></button>
       </div>
    </div>
  </div>
</div>