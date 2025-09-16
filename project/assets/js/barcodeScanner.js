let barcodeInput = jQuery('#barcode-input');
const result = jQuery('#result');
let barcodeBuffer = '';
let isScanning = false;
const SCAN_TIMEOUT = 100;

jQuery(function($){
    $('#scan-button').on('click', function() {
        barcodeInput.focus();

        const glow = jQuery(this).find('.scan-glow');
  
        glow.css('animation', 'none');
        
        void glow[0].offsetWidth;
        
        glow.css('animation', 'scanLine 1.5s infinite');
        
        $(this).addClass('scanning');
        setTimeout(() => {
            $(this).removeClass('scanning');
        }, 800);
    });

    barcodeInput.on('input', function(e) {
        const value = $(this).val();

        if (isScanning) {
        barcodeBuffer += value.slice(-1);
        } else {
        barcodeBuffer = value;
        isScanning = true;
        }

        $(this).val('');

        clearTimeout(window.scanTimeout);
        window.scanTimeout = setTimeout(() => {
        if (isScanning && barcodeBuffer.length > 0) {
            handleBarcode(barcodeBuffer);
            barcodeBuffer = '';
            isScanning = false;
        }
        }, SCAN_TIMEOUT);
    });
});

function handleBarcode(code) {
    result.text(`✅ Scanned: ${code}`);

    jQuery.get('./controller/ScanBarcodeController.php', { barcode: code }, function(response) {
    if (response.success) {
        displayPointOfSaleProducts(response.data.id, response.data.quantity, response.data.product_name, response.data.price, response.data.unit)
    }
    }).fail((error) => {
        console.error('❌ Server error: ', error);
    });
}

function displayPointOfSaleProducts(id, quantity, name, price, unit){
    const productData = `
    <tr class="text-center">
        <td>
            <input type="number" class="form-control w-100 quantity-input" value="0" min="1" max="${quantity}">
        </td>
        <td class="product-name">${name}</td>
        <td class="price" data-value="${price}">${formatCurrency(price)}</td>
        <td class="text-capitalize unit-of-price">${unit}</td>
        <td class="text-capitalize">
            <button
            type="button"
            class="checkout-btn" 
            id="addToCart"
            data-id="${id}"
            >
                Add
            </button>
        </td>
    </tr>`;
    jQuery('#pos-products-container').append(productData);
}