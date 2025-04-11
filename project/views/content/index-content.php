<div class="container-fluid my-4">

<div class="row">

    <!-- Product List Section -->
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control" id="searchPOSProducts" placeholder="Search products...">
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 product-thumbnail">
        </div>
    </div>

    <!-- Cart & Checkout Section -->
    <div class="col-lg-4 col-md-12">
        <h3>Cart</h3>
        <div class="cart"></div>
        <div class="mb-3" id="cashAmountParent">
            <label for="cashAmountInput" class="form-label">Enter cash amount</label>
            <input type="email" class="form-control" id="cashAmountInput" placeholder="₱00.00">
        </div>
        <div class="d-flex justify-content-between mt-5 mb-3">
            <h5>Total:</h5>
            <h5 id="overAllTotal"></h5>
        </div>
        <div class="d-flex justify-content-between mt-5 mb-3" id="changeParent">
            <h5>Change:</h5>
            <h5 id="change"></h5>
        </div>
        <button class="checkout-btn mt-3" id="checkoutButton">Complete Order</button>
    </div>

</div>

</div>