<div class="container-fluid my-4">
  <div class="d-flex justify-content-between align-items-center mb-4" id="notPrintable">
    <h3 class="fw-bold">MBRLCFI POS</h3>
    <a 
      class="nav-link d-flex align-items-center text-danger" 
      href="#" 
      role="button" 
      id="logout" 
      title="Logout here..."
    >
      <i class="fas fa-sign-out-alt me-2"></i> 
      <span class="d-none d-md-inline">Logout</span>
    </a>
  </div>

  <div class="text-center mb-4">
    <div
      id="running-clock"
      class="d-inline-flex flex-column align-items-center p-3 bg-dark text-white rounded shadow-sm border border-secondary"
      style="min-width: 180px"
      role="timer"
      aria-label="Current time display"
    >
      <!-- Time -->
      <div
        class="fs-3 fw-bold text-white mb-1 font-monospace"
        style="letter-spacing: 1px;"
      >
      </div>

      <!-- Date -->
      <small class="text-white">
      </small>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8 col-md-12 mb-4" id="notPrintable">
      <div class="mb-3">
        <input 
          type="text" 
          class="form-control" 
          id="searchPOSProducts" 
          placeholder="Search products..." 
        >
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-center">Name</th>
              <th scope="col" class="text-center">Price</th>
              <th scope="col" class="text-center">Unit of Price</th>
              <th scope="col" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody id="pos-products-container"></tbody>
        </table>
      </div>
    </div>

    <div class="col-lg-4 col-md-12" id="receiptContainer">
      <div class="receipt-logo text-center">
        <image src="https://i.imgur.com/3LvoZ6D.png" width="150" alt="MBRLCFI Logo">
      </div>
      <div class="header text-center">MBRLCFI</div>
      <div class="address text-center">Purok Marang, Kinuskusan Bansalan Davao Del Sur</div>
      <div class="transaction-date text-center"></div>
      <hr class="text-white" />
      <div class="cart"></div>
      <hr class="text-white" />
      <div class="mb-5" id="cashAmountParent">
        <label for="cashAmountInput" class="form-label">Enter cash amount</label>
        <input 
          type="number" 
          class="form-control" 
          id="cashAmountInput" 
          placeholder="₱00.00" 
        >
      </div>
      <div class="d-flex justify-content-between mb-2" id="printableCashElementContainer">
        <p>Cash:</p>
        <p id="cash">₱0.00</p>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <p>Sub-Total:</p>
        <p id="subTotal">₱0.00</p>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <p>VAT(12%)</p>
        <p id="vat">₱0.00</p>
      </div>
      <div class="d-flex justify-content-between mb-2">
        <p>Total Amount:</p>
        <p id="total">₱0.00</p>
      </div>
      <div class="d-flex justify-content-between mb-2" id="changeParent">
        <p>Change:</p>
        <p id="change">₱0.00</p>
      </div>
      <button 
        class="checkout-btn w-100 mt-3" 
        id="checkoutButton"
      >
        Complete Order
      </button>
      <div class="footer text-center">Thank you for shopping!</div>
    </div>
  </div>
</div>