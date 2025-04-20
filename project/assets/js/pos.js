$.noConflict();

let stock = 1000;
let cart = [];
jQuery(function($){

    $('#cashAmountParent').hide();
    $('#changeParent').removeClass('d-flex').addClass('d-none');

    $(document).on('submit', '#enterProductQuantity', function(e) {
        e.preventDefault();
        const productContainer = $(this).closest('#pos-products-container');
        
        const productID = productContainer.find('#productID').val()
        const productName = productContainer.find('.product-name').text();
        const quantity = productContainer.find('.quantity-input').val();
        const price = productContainer.find('.price').data('value');
        const unitOfPrice = productContainer.find('.unit-of-price').text();
    
        cart.push({ id: productID, quantity: parseInt(quantity), name: productName, price: parseFloat(price), unit: unitOfPrice });
        
        let totalAmount = 0;
        let productDetails = '';

        // Clear any previously added products from the DOM
        $('.cart').empty();

        for (let i = 0; i < cart.length; i++) {
            const productName = cart[i].name;
            const quantity = cart[i].quantity;
            const price = cart[i].price;
            const totalCost = calculateProductTotal(quantity, price);

            const isOutOfStock = checkIfQuantityIsGreaterToStock(quantity, stock)

            if(!isOutOfStock){
                totalAmount += totalCost;

                productDetails += `
                    <div class="cart-item">
                        <span class="total-quantity">Quantity: ${quantity}</span>
                        <span class="added-product-name">${productName}</span>
                        <span class="product-total-amount">Total: ₱${numberWithCommas(totalCost.toFixed(2))}</span>
                    </div>
                `;
            }else{
                productContainer.find('.quantity-input').val(0);
            }
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
    });

    $('#checkoutButton').on('click', function(){
        const cash = $('#cashAmountInput').val();
        const amountToPay = $('#subTotal').data('totalAmount');
        const taxAmount = amountToPay * 0.12;
        const totalAmount = amountToPay + taxAmount;
        const amountChange = checkingAmountEntered(cash, amountToPay)

        saveOrders(cart);

        $('#vat').text(`₱${numberWithCommas(taxAmount.toFixed(2))}`);
        $('#total').text(`₱${numberWithCommas(totalAmount.toFixed(2))}`);
        if(amountChange > 0){
            $('#change').text(`₱${numberWithCommas(amountChange.toFixed(2))}`);
        }
    });
});


function checkIfQuantityIsGreaterToStock(quantity, stock){
    if(quantity > stock){
        
    }
}

function calculateProductTotal(quantity, price){
    return quantity * price;
}

function checkingAmountEntered(cash, amountToPay){
    if(cash > amountToPay){
        return cash - amountToPay
    } else if(cash === ''){
        Swal.fire({
            title: 'Warning!',
            text: 'To finalize the order, please specify the cash amount received.',
            icon: 'warning',
        }).then((result) => {
            if(result.isConfirmed){
                return;
            }
        })
    } else {
        Swal.fire({
            title: 'Warning!',
            text: 'Insufficient balance',
            icon: 'warning',
        }).then((result) => {
            if(result.isConfirmed){
                return;
            }
        })
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