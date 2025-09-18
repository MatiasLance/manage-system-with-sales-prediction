$.noConflict();

let barcodeInput = jQuery('#barcode-input');
const result = jQuery('#result');
let barcodeBuffer = '';
let isScanning = false;
let lastScanTime = 0;
const SCAN_TIMEOUT = 100;

let cart = [];
let isSubmit = false;

jQuery(function($) {

    $('#cashAmountParent').hide();
    $('#changeParent, #printableCashElementContainer').removeClass('d-flex').addClass('d-none');

    // --- [1] Toggle scanner mode ---
    $('#scan-toggle').on('change', function() {
        const isActive = $(this).is(':checked');

        if (isActive) {
            $('#swapTextLabel').text('Barcode scanner activated');
            barcodeInput.focus();
            barcodeInput.addClass('scanning');
            setTimeout(() => barcodeInput.removeClass('scanning'), 800);
        } else {
            $('#swapTextLabel').text('Barcode scanner deactivated');
            barcodeInput.val('');
        }
    });

    // --- [2] Handle barcode input (scanner types full string) ---
    barcodeInput.on('input', function(e) {
        const value = $(this).val();

        if (value.length > 0) {

            barcodeBuffer = value;
            isScanning = true;
            lastScanTime = Date.now();

            clearTimeout(window.scanTimeout);
            window.scanTimeout = setTimeout(() => {
                if (barcodeBuffer.length > 0) {
                    handleBarcode(barcodeBuffer);
                    barcodeBuffer = '';
                    isScanning = false;
                }
            }, SCAN_TIMEOUT);
        }
    });

    // --- [3] CRITICAL FIX: Intercept ALL Enter keys on barcode input ---
    // This stops Enter from bubbling to document level — whether from scanner OR user
    barcodeInput.on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();      // Prevent default form submission
            e.stopPropagation();     // 👈 STOP BUBBLING TO DOCUMENT LEVEL — THIS IS THE FIX!

            const now = Date.now();
            const timeSinceScanStart = now - lastScanTime;

            // If this Enter came from scanner (<200ms after input)
            if (isScanning && timeSinceScanStart < 200) {
                console.log('⛔ Ignoring scanner-triggered Enter');
                // Do nothing — we'll handle it via handleBarcode()
            } else {
                console.log('✅ Manual Enter pressed — triggering add');
                handleManualAdd(); // User manually pressed Enter
            }
        }
    });

    // --- [4] GLOBAL ENTER HANDLER: ONLY TRIGGER IF NOT ON BARCODE INPUT ---
    // Now safe: only runs if Enter is pressed *outside* of barcode input
    $(document).on('keydown', function(event) {
        if (event.key !== 'Enter') return;

        // Only proceed if focus is NOT on barcode input
        if ($(event.target).is('#barcode-input')) {
            return; // 👈 Ignore if Enter was pressed on barcode input — already handled!
        }

        // --- YOUR EXISTING CART ADD LOGIC ---
        let productDetails = '';
        let totalAmount = 0;

        const row = $('#pos-products-container tr:first');
        const productId = row.find('.product-id').data('id');
        const quantity = row.find('.quantity-input').val();
        const productName = row.find('.product-name').text();
        const price = row.find('.price').data('value');
        const unitOfPrice = row.find('.unit-of-price').text();

        if (isNaN(quantity) || quantity < 1) {
            Swal.fire({
                title: 'Error!',
                text: 'Please enter a valid quantity.',
                icon: 'error',
            });
            return;
        }

        cart.push({ id: productId, quantity: parseInt(quantity), name: productName, price: parseFloat(price), unit: unitOfPrice });

        $('.cart').empty();

        for (let i = 0; i < cart.length; i++) {
            const productName = cart[i].name;
            const quantity = cart[i].quantity;
            const price = cart[i].price;
            const totalCost = calculateProductTotal(quantity, price);

            totalAmount += totalCost;

            productDetails += `
                <div class="cart-item">
                    <span class="added-product-name mb-3">${productName}</span>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <span class="total-quantity">${quantity}</span>
                            &nbsp;&nbsp;
                            <span class="text-white">x</span>
                            &nbsp;&nbsp;
                            <span class="total-quantity">${price}</span>
                        </div>
                        <span class="product-total-amount">₱${numberWithCommas(totalCost.toFixed(2))}</span>
                        <button class="btn btn-sm btn-danger ml-2 remove-product" data-index="${i}" id="notPrintable">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        }

        if(cart.length > 0){
            $('.cart').addClass('mb-5');
            $('#cashAmountParent').show();

            if($('#changeParent').hasClass('d-none')){
                $('#changeParent').removeClass('d-none').addClass('d-flex');
            }
        }

        $('.cart').append(productDetails);
        $('#subTotal').text(`₱${numberWithCommas(totalAmount.toFixed(2))}`).data('totalAmount', totalAmount);
    });

    // --- [5] Checkout Button ---
    $('#checkoutButton').on('click', function(){
        const cash = parseInt($('#cashAmountInput').val());
        jQuery('#cash').text(`₱${numberWithCommas(cash.toFixed(2))}`);
        const amountToPay = $('#subTotal').data('totalAmount');
        const taxAmount = amountToPay * 0.12;
        const totalAmount = amountToPay;
        const amountChange = checkingAmountEntered(cash, amountToPay);

        if(cart.length === 0){
            Swal.fire({
                title: 'Warning!',
                text: 'Oops! It seems you haven’t added any products yet. 📋 Start by selecting items to complete your order.',
                icon: 'warning',
            });
            return;
        }

        if (amountChange === null) {
            return;
        }

        $('#vat').text(`₱${numberWithCommas(taxAmount.toFixed(2))}`);
        $('#total').text(`₱${numberWithCommas(totalAmount.toFixed(2))}`);
        if(amountChange > 0){
            $('#change').text(`₱${numberWithCommas(amountChange.toFixed(2))}`);
        }

        $('.transaction-date').text(`Trans. Date: ${getCurrentDateTime()}`);

        saveOrders(cart);
    });

    // --- [6] Remove Product ---
    $(document).on('click', '.remove-product', function(){
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });

    // --- [7] Quantity Input Debounce ---
    const handleQuantityChange = debounce(function () {
        const input = $(this);
        const inputtedQuantity = input.val().trim();
        const row = input.closest('tr');
        const productId = row.find('.pos-product-id').data('id');
        const productName = row.find('.product-name').text();

        const payload = { id: productId, quantity: inputtedQuantity, name: productName };
        checkingQuantityEntered(payload);
    }, 500);

    $(document).on('input', '.quantity-input', handleQuantityChange);

    // --- [8] Clock Update ---
    const $clockTime = $('#running-clock .fs-3');
    const $clockDate = $('#running-clock small');

    function updateClock() {
        const now = new Date();

        const timeStr = now.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        });

        const dateStr = now.toLocaleDateString(undefined, {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        });

        $clockTime.text(timeStr);
        $clockDate.text(dateStr);
    }

    updateClock();
    setInterval(updateClock, 1000);
});

// --- [9] Handle Barcode Scan ---
function handleBarcode(code) {
    result.text(`✅ Scanned: ${code}`);

    jQuery('body').addClass('scanning');

    jQuery.get('./controller/ScanBarcodeController.php', { barcode: code }, function(response) {
        if (response.success) {
            displayPointOfSaleProducts(
                response.data.id,
                response.data.quantity,
                response.data.product_name,
                response.data.price,
                response.data.unit
            );

            setTimeout(() => jQuery('body').removeClass('scanning'), 500);
        } else {
            result.html(`<span class="text-danger">❌ ${response.message || 'Invalid barcode'}</span>`);
        }
    }).fail((error) => {
        console.error('❌ Server error:', error);
        result.html('<span class="text-danger">⚠️ Server unreachable</span>');
    });
}

// --- [10] Handle Manual Enter Press ---
function handleManualAdd() {
    const value = barcodeInput.val().trim();
    if (!value) return;

    handleBarcode(value); // Reuse scanner logic
    barcodeInput.val(''); // Clear after adding
}

// --- [11] Display Product in POS Table ---
function displayPointOfSaleProducts(id, quantity, name, price, unit) {
    const productData = `
        <tr class="text-center">
            <td hidden>
                <input type="hidden" class="pos-product-id" data-id="${id}">
            </td>
            <td>
                <input type="number" class="form-control w-100 quantity-input" value="1" min="1" max="${quantity}" autofocus>
            </td>
            <td class="product-name">${name}</td>
            <td class="price" data-value="${price}">${formatCurrency(price)}</td>
            <td class="text-capitalize unit-of-price">${unit}</td>
        </tr>`;
    
    jQuery('#pos-products-container').append(productData);

    jQuery('#pos-products-container tr:last .quantity-input').focus();
}

// --- [12] Format Currency ---
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2
    }).format(amount);
}

// --- [13] Calculate Product Total ---
function calculateProductTotal(quantity, price){
    return quantity * price;
}

// --- [14] Check Cash Amount ---
function checkingAmountEntered(cash, amountToPay) {
    const cashValue = parseFloat(cash);

    if (isNaN(cashValue)) {
        Swal.fire({
            title: 'Warning!',
            text: 'To finalize the order, please specify the cash amount received.',
            icon: 'warning',
        });
        return null;
    }

    if (cashValue > amountToPay) {
        return cashValue - amountToPay;
    } else if (cashValue === amountToPay) {
        return 0;
    } else {
        Swal.fire({
            title: 'Warning!',
            text: 'Insufficient balance',
            icon: 'warning',
        });
        return null;
    }
}

// --- [15] Number With Commas ---
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// --- [16] Save Orders ---
function saveOrders(orders){
    jQuery.ajax({
        url: './controller/OrderController.php',
        type: 'POST',
        data: { items: orders },
        dataType: 'json',
        success: function(response){
            if(response.status === 'success'){
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        setTimeout(() => {
                            if(jQuery('#printableCashElementContainer').hasClass('d-none')){
                                jQuery('#printableCashElementContainer').removeClass('d-none').addClass('d-flex')
                            }
                            let printCancelled = true;

                            window.onafterprint = function () {
                                printCancelled = false;
                            };

                            window.print();
                            setTimeout(() => {
                                jQuery('.cart').empty();
                                jQuery('#subTotal').text('');
                                jQuery('#vat').text('');
                                jQuery('#total').text('');
                                jQuery('#change').text('');
                                if (jQuery('#changeParent').hasClass('d-flex')) {
                                    jQuery('#changeParent').removeClass('d-flex').addClass('d-none');
                                }
                                if(jQuery('#printableCashElementContainer').hasClass('d-flex')){
                                    jQuery('#printableCashElementContainer').removeClass('d-flex').addClass('d-none')
                                }
                                jQuery('#cashAmountParent').hide();
                                jQuery('#pos-products-container').empty();
                                window.location.reload();
                            }, 500);
                        }, 500);
                    }
                })
            }else{
                Swal.fire({
                    title: 'Warning!',
                    text: response.message,
                    icon: 'warning',
                }).then((result) => {
                    if(result.isConfirmed){
                        jQuery('.cart').empty();
                        jQuery('#subTotal').text('')
                        jQuery('#vat').text('');
                        jQuery('#total').text('');
                        jQuery('#change').text('');
                        if(jQuery('#changeParent').hasClass('d-flex')){
                            jQuery('#changeParent').removeClass('d-flex').addClass('d-none');
                        }
                        jQuery('#cashAmountParent').hide();
                        jQuery('#pos-products-container').empty();
                    }
                }) 
            }
        },
        error: function(xhr, status, error){
            console.error(error)
        }
    })
}

// --- [17] Check Quantity ---
function checkingQuantityEntered(payload){
    jQuery.ajax({
        url: './controller/product/CheckProductQuantityController.php',
        type: 'POST',
        data: payload,
        dataType: 'json',
        success: function(response){
            if(response.status === 'error'){
                Swal.fire({
                    title: 'Warning!',
                    text: response.message,
                    icon: 'warning',
                }).then((result) => {
                    if(result.isConfirmed){
                        jQuery('.quantity-input').val('');
                    }
                });
                return;
            }
        },
        error: function(xhr, status, error){
            console.error(error)
        }
    });
}

// --- [18] Get Current DateTime ---
function getCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// --- [19] Debounce Function ---
function debounce(func, delay) {
    let timer;
    return function (...args) {
        const context = this;
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(context, args), delay);
    };
}

function updateCart() {
    let productDetails = '';
    let totalAmount = 0;

    // Clear the cart container
    jQuery('.cart').empty();

    for (let i = 0; i < cart.length; i++) {
        const productName = cart[i].name;
        const quantity = cart[i].quantity;
        const price = cart[i].price;
        const totalCost = calculateProductTotal(quantity, price);

        totalAmount += totalCost;

        productDetails += `
                <div class="cart-item">
                    <span class="added-product-name mb-3">${productName}</span>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <span class="total-quantity">${quantity}</span>
                            &nbsp;&nbsp;
                            <span class="text-white">x</span>
                            &nbsp;&nbsp;
                            <span class="total-quantity">${price}</span>
                        </div>
                        <span class="product-total-amount">₱${numberWithCommas(totalCost.toFixed(2))}</span>
                        <button class="btn btn-sm btn-danger ml-2 remove-product" data-index="${i}" id="notPrintable">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
    }

    // Check if cart is not empty and show the cash input field
    if(cart.length > 0){
        jQuery('.cart').addClass('mb-5')
        jQuery('#cashAmountParent').show();

        if(jQuery('#changeParent').hasClass('d-none')){
            jQuery('#changeParent').removeClass('d-none').addClass('d-flex');
        }
    }

    jQuery('.cart').append(productDetails);
    jQuery('#subTotal').text(`₱${numberWithCommas(totalAmount.toFixed(2))}`).data('totalAmount', totalAmount)
}