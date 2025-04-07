$.noConflict();

let stock = 100;
let cart = [];
jQuery(function($){
    $('.add-to-cart-btn').on('click', function() {
        const $productCard = $(this).closest('.product-card');
        
        const productName = $productCard.find('.product-name').text();
        const quantity = $productCard.find('.quantity-input').val();
        const price = $productCard.find('.price').data('value');
    
        cart.push({ quantity: parseInt(quantity), name: productName, price: parseFloat(price) });
        
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
                        <span class="product-total-amount">Total: ₱${totalCost.toFixed(2)}</span>
                    </div>
                `;
            }else{
                $productCard.find('.quantity-input').val(0);
            }
        }
        $('.cart').append(productDetails);
        $('#overAllTotal').text(`₱${totalAmount.toFixed(2)}`)
    });
});


function checkIfQuantityIsGreaterToStock(quantity, stock){
    if(quantity > stock){
        alert('Out of stock')
        return true
    }
}

function calculateProductTotal(quantity, price){
    return quantity * price;
}