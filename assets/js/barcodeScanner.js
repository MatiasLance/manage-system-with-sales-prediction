let barcodeInput = jQuery('#barcode-input');
const result = jQuery('#result');
let barcodeBuffer = '';
let isScanning = false;
let lastScanTime = 0; // 👈 NEW: Track when scan started
const SCAN_TIMEOUT = 100;
let ignoreGlobalEnter = false;

jQuery(function($) {
    // --- [1] Toggle scanner mode ---
    $('#scan-toggle').on('change', function() {
        const isActive = $(this).is(':checked');

        if (isActive) {
            $('#swapTextLabel').text('Barcode scanner activated');
            barcodeInput.focus();
            // Optional: Highlight input visually
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
            // ✅ Clear input immediately to prevent ghost repeats
            $(this).val('');

            // ✅ Reset buffer and mark as scan
            barcodeBuffer = value;
            isScanning = true;
            lastScanTime = Date.now(); // 👈 Record timestamp

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

    // --- [3] CRITICAL: Intercept and suppress scanner's trailing Enter ---
    barcodeInput.on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // ⚠️ BLOCK Enter by default

            const now = Date.now();
            const timeSinceScanStart = now - lastScanTime;

            // ✅ If Enter came within 200ms of input → likely from scanner → IGNORE
            if (isScanning && timeSinceScanStart < 200) {
                console.log('⛔ Ignoring scanner-triggered Enter');
                return; // DO NOTHING — we already handled the barcode!
            }

            // ✅ Otherwise → it's a human pressing Enter → ALLOW it
            console.log('✅ Manual Enter pressed — triggering add');
            e.preventDefault(); // Still prevent default just in case
            handleManualAdd();  // Trigger manual add
        }
    });
});

// --- [4] Handle barcode scan (from scanner) ---
function handleBarcode(code) {
    result.text(`✅ Scanned: ${code}`);
    // After successful scan:
    jQuery('body').addClass('scanning');

    $.get('./controller/ScanBarcodeController.php', { barcode: code }, function(response) {
        if (response.success) {
            displayPointOfSaleProducts(
                response.data.id,
                response.data.quantity,
                response.data.product_name,
                response.data.price,
                response.data.unit
            );
            ignoreGlobalEnter = true;
            setTimeout(() => {
                ignoreGlobalEnter = false;
            }, 1000); 
            setTimeout(() => jQuery('body').removeClass('scanning'), 500);
        } else {
            result.html(`<span class="text-danger">❌ ${response.message || 'Invalid barcode'}</span>`);
        }
    }).fail((error) => {
        console.error('❌ Server error:', error);
        result.html('<span class="text-danger">⚠️ Server unreachable</span>');
    });
}

// --- [5] Handle manual Enter press (user typing + hitting Enter) ---
function handleManualAdd() {
    const value = barcodeInput.val().trim();
    if (!value) return;

    // Simulate a barcode scan for manual entry
    handleBarcode(value);
    barcodeInput.val(''); // Clear after adding
}

// --- [6] Display product in POS table ---
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
    
    $('#pos-products-container').append(productData);

    // 👇 Auto-focus new quantity field for faster entry
    $('#pos-products-container tr:last .quantity-input').focus();
}

// --- [7] Format currency helper (if not defined elsewhere) ---
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP', // Change to your currency
        minimumFractionDigits: 2
    }).format(amount);
}