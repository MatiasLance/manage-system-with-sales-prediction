let barcodeInput = jQuery('#barcode-input');
const result = jQuery('#result');
let barcodeBuffer = '';
let isScanning = false;
const SCAN_TIMEOUT = 100;

jQuery(function($) {
    $('#scan-toggle').on('change', function() {
        const isActive = $(this).is(':checked');

        if (isActive) {
            $('#swapTextLabel').text('Barcode scanner activated');
            barcodeInput.focus();
        } else {
            $('#swapTextLabel').text('Barcode scanner deactivated');
        }
    });

    barcodeInput.on('input', function(e) {
        const value = $(this).val();

        if (value.length > 0) {
            $(this).val('');

            barcodeBuffer = value;

            clearTimeout(window.scanTimeout);

            window.scanTimeout = setTimeout(() => {
                if (barcodeBuffer.length > 0) {
                    handleBarcode(barcodeBuffer);
                    barcodeBuffer = '';
                }
            }, SCAN_TIMEOUT);
        }
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
        <td hidden>
            <input type="hidden" class="pos-product-id" data-id="${id}">
        </td>
        <td>
            <input type="number" class="form-control w-100 quantity-input" value="0" min="1" max="${quantity}">
        </td>
        <td class="product-name">${name}</td>
        <td class="price" data-value="${price}">${formatCurrency(price)}</td>
        <td class="text-capitalize unit-of-price">${unit}</td>
    </tr>`;
    jQuery('#pos-products-container').append(productData);
}