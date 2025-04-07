<div class="container-fluid mt-4">

<div class="row">

    <!-- Product List Section -->
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control" placeholder="Search products...">
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col">
                <div class="product-card">
                    <img src="https://i.imgur.com/3LvoZ6D.png" alt="Product Image">
                    <h5 class="text-center product-name">Product 1</h5>
                    <p class="text-center price" data-value="10">$10.00</p>
                    <div class="d-flex justify-content-between">
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="btn add-to-cart-btn w-50">Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="product-card">
                    <img src="https://i.imgur.com/3LvoZ6D.png" alt="Product Image">
                    <h5 class="text-center product-name">Product 2</h5>
                    <p class="text-center price" data-value="15">$15.00</p>
                    <div class="d-flex justify-content-between">
                        <input type="number" class="quantity-input" value="1" min="1">
                        <button class="btn add-to-cart-btn w-50">Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="product-card">
                    <img src="https://i.imgur.com/3LvoZ6D.png" alt="Product Image">
                    <h5 class="text-center product-name">Product 3</h5>
                    <p class="text-center price" data-value="20">$20.00</p>
                    <div class="d-flex justify-content-between">
                        <input type="number" class="quantity-input" value="1" min="1" max="100">
                        <button class="btn add-to-cart-btn w-50">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart & Checkout Section -->
    <div class="col-lg-4 col-md-12">
        <h3>Cart</h3>
        <div class="cart"></div>
        <div class="d-flex justify-content-between mt-5 mb-3">
            <h5>Total:</h5>
            <h5 id="overAllTotal"></h5>
        </div>
        <button class="checkout-btn mt-3" id="checkoutButton">Complete Order</button>
    </div>

</div>

</div>