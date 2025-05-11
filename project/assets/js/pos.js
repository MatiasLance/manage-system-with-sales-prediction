$.noConflict();

let cart = [];
let isSubmit = false;

jQuery(function($){

    $('#cashAmountParent').hide();
    $('#changeParent, #printableCashElementContainer').removeClass('d-flex').addClass('d-none');

    $(document).on('click', '#addToCart', function(){
        // Reset product details and total amount for each click para iwas duplicate na product ang ma render.
        let productDetails = '';
        let totalAmount = 0;

        const row = $(this).closest('tr');
        const productId = $(this).data('id');
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

        // Clear any previously added products from the DOM
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

        // Check if cart is not empty and show the cash input field
        if(cart.length > 0){
            $('.cart').addClass('mb-5')
            $('#cashAmountParent').show();

            if($('#changeParent').hasClass('d-none')){
                $('#changeParent').removeClass('d-none').addClass('d-flex');
            }
        }

        $('.cart').append(productDetails);
        $('#subTotal').text(`₱${numberWithCommas(totalAmount.toFixed(2))}`).data('totalAmount', totalAmount)
    })

    $('#checkoutButton').on('click', function(){
        const cash = parseInt($('#cashAmountInput').val());
        jQuery('#cash').text(`₱${numberWithCommas(cash.toFixed(2))}`);
        const amountToPay = $('#subTotal').data('totalAmount');
        const taxAmount = amountToPay * 0.12;
        const totalAmount = amountToPay;
        const amountChange = checkingAmountEntered(cash, amountToPay)

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

        $('.transaction-date').text(`Trans. Date: ${getCurrentDateTime()}`)

        saveOrders(cart);
    });

    $(document).on('click', '.remove-product', function(){
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    })
});

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


function calculateProductTotal(quantity, price){
    return quantity * price;
}

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

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

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