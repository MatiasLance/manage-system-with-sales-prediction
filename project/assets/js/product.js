let retrieveTotalQuantityInput = $('#retrieveTotalQuantityInput');
let retrieveAddedQuantityInput = $('#retrieveAddedQuantityInput');
let retrieveSelectedProductNameInput = $("#retrieveSelectedProductNameInput")
let retrieveProductDateProduceInput = $('#retrieveProductDateProduceInput');
let retrieveProductDateExpirationInput = $('#retrieveProductDateExpirationInput');
let retrieveProductPriceInput = $('#retrieveProductPriceInput');
let retrieveGrainsAndCerealsUnitOfPriceInput = $('#retrieveGrainsAndCerealsUnitOfPriceInput');
let retrieveDairyUnitOfPriceInput = $('#retrieveDairyUnitOfPriceInput');
let retrieveProductStatus = $('#retrieveProductStatusInput');

let selectedProductName = $('#selectedProductName');
let productId = $('#productId');
let deleteProductId = $('#deleteProductId');
let productNameToBeDeletedId = $('#productNameToBeDeletedId');
let productPassword = $('#productPasswordInput');
let productNameToBeDeleted = $('#productNameToBeDeleted');
let productNamePasswordInput = $('#productNamePasswordInput');
let productNameId = $('#productNameId');
let newProductName = $('#retrieveProductNameInput');
let newProductCode = $('#retrieveProductCodeInput');
let newProductNameCode = $('#retrieveProductNameCodeInput');
let newProductCategory = $('#retrieveProductCategoryInput');
let newProductNameCategory = $('#retrieveProductNameCategoryInput');
let debounceTimer;
let currentSearch = '';
let selectedUnitOfPrice = '';
let selectedProductNameID = 0;

jQuery(function($){
    $('#grainsAndCerealsUnitOfPriceContainer, #selectGrainsAndCerealsProductNameContainer, #retrieveSelectedGrainsAndCerealsProductNameContainer').hide();
    // The product's expiry date will be automatically displayed once the production date is selected.
    $(document).on('change', '#productDateProduceInput, #retrieveProductDateProduceInput', function(){
        const productionDate = new Date($(this).val());
        if (!isNaN(productionDate.getTime())) {
            const expiryDate = new Date(productionDate);
            expiryDate.setMonth(expiryDate.getMonth() + 3);

            const formattedDate = [
                String(expiryDate.getMonth() + 1).padStart(2, '0'),
                String(expiryDate.getDate()).padStart(2, '0'),
                expiryDate.getFullYear()
            ].join('/');
            
            $('#productDateExpirationInput, #retrieveProductDateExpirationInput').val(formattedDate);

        }
    })

    $('#printProductBarcode').on('click', function(){
        window.print();
    });

    // Load product when product tab selected
    $('#products-tab').on('click', function(){
        fetchData(1, '');
    });

    $('#dairy-product-tab').on('click', function(){
        $('#grainsAndCerealsUnitOfPriceContainer, #selectGrainsAndCerealsProductNameContainer, #retrieveSelectedGrainsAndCerealsProductNameContainer').hide();
        $('#productDateExpirationInputContainer, #diaryUnitOfPriceContainer, #selectDairyProductNameContainer, #retrieveSelectedDairyProductNameContainer').show();
        $('#quantityInput, #productCodeInput, #productCategoryInput, #productDateProduceInput, #productDateExpirationInput, #productPriceInput, #dairyUnitOfPriceInput, #grainsAndCerealsUnitOfPriceInput').val('');
        $('#addProductModalLabel').text('Add Dairy Product');
    });

    $('#grain-and-cereals-product-tab').on('click', function(){
        $('#grainsAndCerealsUnitOfPriceContainer, #selectGrainsAndCerealsProductNameContainer, #retrieveSelectedGrainsAndCerealsProductNameContainer').show();
        $('#productDateExpirationInputContainer, #diaryUnitOfPriceContainer, #selectDairyProductNameContainer, #retrieveSelectedDairyProductNameContainer').hide();
        $('#quantityInput, #productCodeInput, #productCategoryInput, #productDateProduceInput, #productDateExpirationInput, #productPriceInput, #dairyUnitOfPriceInput, #grainsAndCerealsUnitOfPriceInput').val('');
        $('#addProductModalLabel').text('Add Grains And Cereals Product');
    });

    if($('#grainsAndCerealsUnitOfPriceContainer').is(':hidden')){
        $('#dairyUnitOfPriceInput').on('change', function(){
            selectedUnitOfPrice = $(this).val()
        })
    }

    if($('#diaryUnitOfPriceContainer').is(':hidden')){
        $('#grainsAndCerealsUnitOfPriceInput').on('change', function(){
            selectedUnitOfPrice = $(this).val()
        })
    }
    
    if($('#retrieveDiaryUnitOfPriceContainer').is(':hidden')){
        retrieveGrainsAndCerealsUnitOfPriceInput.on('change', function(){
            selectedUnitOfPrice = $(this).val();
        });
    }

    if($('#retrieveGrainsAndCerealsUnitOfPriceContainer').is(':hidden')){
        retrieveDairyUnitOfPriceInput.on('change', function(){
            selectedUnitOfPrice = $(this).val();
        });
    }

    if($('#selectDairyProductNameContainer, #retrieveSelectedDairyProductNameContainer').is(':hidden')){
        $('#selectGrainsAndCerealsProductNameInput, #retrieveSelectedGrainsAndCerealsProductNameInput').on('change', function(){
            selectedProductNameID = $(this).val();
        })

    }

    if($('#selectGrainsAndCerealsProductNameContainer, #retrieveSelectedGrainsAndCerealsProductNameContainer').is(':hidden')){
        $('#selectDairyProductNameInput, #retrieveSelectedDairyProductNameInput').on('change', function(){
            selectedProductNameID = $(this).val();
        })

    }

    $('#selectDairyProductNameInput, #selectGrainsAndCerealsProductNameInput, #retrieveSelectedGrainsAndCerealsProductNameInput, #retrieveSelectedDairyProductNameInput').on('change', function(){
       const id =  $(this).val();
       if(!id){
         $('#productCodeInput, #productCategoryInput').val('');
         $('#productDateExpirationInputContainer').show();
       }else{
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchProductNameByID(
            productNameId,
            newProductName,
            newProductNameCode,
            newProductNameCategory,
            productNameToBeDeleted,
            productNameToBeDeletedId,
            id);
        }, 500);
       }
    });

    // Add Product
    $(document).on('submit', '#addProduct', function(e){
        e.preventDefault();

        const productQuantity = $('#quantityInput').val();
        const productName = selectedProductNameID;
        const productDateProduce = $('#productDateProduceInput').val();
        const productPrice = $('#productPriceInput').val();
        const productUnitOfPrice = selectedUnitOfPrice;

        const payload = {
            product_quantity: productQuantity,
            selected_product_name_id: productName,
            product_date_produce: productDateProduce,
            product_price: productPrice,
            product_unit_of_price: productUnitOfPrice
        }

        $.ajax({
            url: './controller/product/AddProductController.php',
            type: 'POST',
            dataType: 'json',
            data: payload,
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                    }).then((result) => {
                        if(result.isConfirmed){
                            $('#addProductModal').modal('hide');
                            fetchData(1, '');
                            reset();
                        }
                    });
                    
                } else {
                    Swal.fire({
                        title: 'error',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: false
                    });
                }
            }
        });
    })

    // Add Product Name, Code, and Category
    $(document).on('click', '#addProductName', function(){
        const payload = {
            product_name: $('#productNameInput').val(),
            product_code: $('#productNameCodeInput').val(),
            product_category: $('#productCategorySelect').val()
        }
        $.ajax({
            url: './controller/product/AddProductNameController.php',
            type: 'POST',
            dataType: 'json',
            data: payload,
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                    }).then((result) => {
                        if(result.isConfirmed){
                            fetchProductName(1, '');
                            // Clear these fields after values are stored.
                            $('#productNameInput, #productNameCodeInput, #productCategorySelect').val('')
                        }
                    });
                    
                } else {
                    Swal.fire({
                        title: 'error',
                        text: response.message,
                        icon: 'error',
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    })

    // Pagination click event for products
    $(document).on('click', '.products-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        fetchData(page, currentSearch);
    });

     // Pagination click event for product names
     $(document).on('click', '.product-name-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        fetchProductName(page, currentSearch);
    });

    // Debounced search input event for products
    $('#searchProducts, #searchGrainsAndCerealsProducts').on('keyup', function() {
        clearTimeout(debounceTimer);
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery;
            fetchData(1, searchQuery);
            filterAndLoadPointOfSaleProducts(1, searchQuery);
        }, 500);
    });

    // Debounced search input event for point of sale products
    $('#searchPOSProducts').on('keyup', function() {
        clearTimeout(debounceTimer);
        let searchQuery = $(this).val();

        if(searchQuery === ''){
            currentSearch = ''
            $('#pos-products-container').empty();
        }else{
            debounceTimer = setTimeout(() => {
                currentSearch = searchQuery;
                filterAndLoadPointOfSaleProducts(1, searchQuery);
            }, 500);
        }
    });

    // Debounced search input event for product names
    $('#searchProductName').on('keyup', function() {
        clearTimeout(debounceTimer);
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery;
            fetchProductName(1, searchQuery);
        }, 500);
    });

    // Retrieve Grains and Cereals Product by ID
    $(document).on('click', '#retrieveProduct', function(){
        let id = $(this).data('id')
        fetchProductByID(id);
    })

    // Retrieve Product Name by ID
    $(document).on('click', '#retrieveProductName', function(){
        let id = $(this).data('id')
        fetchProductNameByID(
            productNameId,
            newProductName,
            newProductNameCode,
            newProductNameCategory,
            productNameToBeDeleted,
            productNameToBeDeletedId,
            id);
    })

    // Opening confirmation modal to delete the product.
    $(document).on('click', '#confirmDeleteProduct', function(){
        let id = $(this).data('id');
        fetchProductByID(id);
    })

    $(document).on('click', '#retriveProductBarcode', function(){
        const id = $(this).data('id')
        fetchProductByID(id);
    });

    // Opening confirmation modal to delete product name
    $(document).on('click', '#confirmDeleteProductName', function(){
        let id = $(this).data('id');
        fetchProductNameByID(
            productNameId,
            newProductName,
            newProductNameCode,
            newProductNameCategory,
            productNameToBeDeleted,
            productNameToBeDeletedId,
            id);
    })

    // Update Products
    $(document).on('click', '#editProduct', function(){
        if($('#retrieveSelectedDairyProductNameContainer').is(':hidden')){
            const payload = {
            id: productId.val(),
            product_added_quantity: retrieveAddedQuantityInput.val() ? retrieveAddedQuantityInput.val() : 0,
            product_name_id: $('#retrieveSelectedGrainsAndCerealsProductNameInput').val(),
            product_date_produce: retrieveProductDateProduceInput.val(),
            product_date_expiration: retrieveProductDateExpirationInput.val(),
            product_price: retrieveProductPriceInput.val(),
            product_unit_of_price: $('#retrieveGrainsAndCerealsUnitOfPriceInput').val(),
            }
            updateProduct(payload);
        }else{
            const payload = {
            id: productId.val(),
            product_added_quantity: retrieveAddedQuantityInput.val(),
            product_name_id: $('#retrieveSelectedDairyProductNameInput').val(),
            product_date_produce: retrieveProductDateProduceInput.val(),
            product_date_expiration: retrieveProductDateExpirationInput.val(),
            product_price: retrieveProductPriceInput.val(),
            product_unit_of_price: $('#retrieveDairyUnitOfPriceInput').val(),
            }
            updateProduct(payload);
        }
    })

    // Update Product Name
    $(document).on('click', '#editProductName', function(){
        updateProductName(productNameId, newProductName, newProductNameCode, newProductNameCategory)
    })

    // Delete Product
    $(document).on('submit', '#deleteProduct', function(e){
        e.preventDefault();
        deleteProduct(productPassword, deleteProductId);
    })

    // Delete Product Name
    $(document).on('submit', '#deleteProductName', function(e){
        e.preventDefault();
        deleteProductName(productNamePasswordInput, productNameToBeDeletedId);
    })

     // Initial fetch
     fetchData(1, '');
     fetchProductName(1, '');
})

function deleteProduct(productPassword, deleteProductId){
    const payload = {
        password: productPassword.val(),
        id: deleteProductId.val()
    }

    jQuery.ajax({
        type: 'POST',
        url: './controller/product/AskPasswordToDeleteProductController.php',
        data: payload,
        dataType: 'json',
        success: function(response){
            if(response.success){
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){ 
                        fetchData(1, '');
                        jQuery('#productPasswordInput').val('');
                    }
                });

            }
            if(!response.success){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                }).then((result) => {
                    if(result.isConfirmed){ 
                        fetchData(1, '');
                        jQuery('#productPasswordInput').val('');
                    }
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function deleteProductName(productNamePasswordInput, productNameToBeDeletedId){
    const payload = {
        password: productNamePasswordInput.val(),
        id: productNameToBeDeletedId.val()
    }

    jQuery.ajax({
        type: 'POST',
        url: './controller/product/AskPasswordToDeleteProductNameController.php',
        data: payload,
        dataType: 'json',
        success: function(response){
            if(response.success){
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){ 
                        fetchProductName(1, '');
                        jQuery('#productNamePasswordInput').val('');
                    }
                });

            }
            if(response.error){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                }).then((result) => {
                    if(result.isConfirmed){ 
                        fetchProductName(1, '');
                        jQuery('#productNamePasswordInput').val('');
                    }
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function updateProduct(payload){
    jQuery.ajax({
        type: 'POST',
        url: './controller/product/UpdateProductController.php',
        data: payload,
        dataType: 'json',
        success: function(response){
            if(response.success){
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        jQuery('#retrieveProductModal').modal('hide');
                        retrieveAddedQuantityInput.val('')
                        fetchData(1, '');
                        fetchProductName(1, '');
                    }
                });
            }
            if(response.error){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                    showConfirmButton: false
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function updateProductName(productNameId, newProductName, newProductNameCode, newProductNameCategory){
    const payload = {
        id: productNameId.val(),
        product_name: newProductName.val(),
        product_code: newProductNameCode.val(),
        product_category: newProductNameCategory.val()
    }

    jQuery.ajax({
        type: "POST",
        url: "./controller/product/UpdateProductNameController.php",
        data: payload,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                Swal.fire("Success", response.message, "success")
                .then((result) => {
                    if(result.isConfirmed){
                      fetchProductName(1, '');
                    }
                });
            } else {
                Swal.fire("Error", response.message, "error");
            }
        },
        error: function (error) {
            console.error("AJAX Error:", error);
        }
    });
}

function fetchProductByID(id){
    jQuery.ajax({
        type: 'GET',
        url: './controller/product/FetchProductByIDController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                deleteProductId.val(id)
                productId.val(id)
                selectedProductName.text(response.product.product_name); // Append name in delete modal
                retrieveTotalQuantityInput.val(response.product.total_quantity).css({'cursor': 'pointer'});
                // retrieveAddedQuantityInput.val(response.product.added_quantity);

                if(jQuery('#retrieveSelectedDairyProductNameContainer').is(':hidden')){
                    const selectGrainsAndCerealsProductName = response.product.productNameID;
                    const existingGrainsAndCerealsProductName = jQuery('#retrieveSelectedGrainsAndCerealsProductNameInput').find(`option[value="${response.product.productNameID}"]`);
                    if(existingGrainsAndCerealsProductName.length === 0 && selectGrainsAndCerealsProductName !== ''){
                        jQuery('#retrieveSelectedGrainsAndCerealsProductNameInput').append(`<option value="${response.product.productNameID}" selected>${response.product.product_name}</option>`);
                    }else{
                        existingGrainsAndCerealsProductName.prop('selected', true);
                    }
                }

                if(jQuery('#retrieveSelectedGrainsAndCerealsProductNameContainer').is(':hidden')){
                    const selectDairyProductName = response.product.productNameID;
                    const existingDairyProductName = jQuery('#retrieveSelectedDairyProductNameInput').find(`option[value="${response.product.productNameID}"]`);
                    if(existingDairyProductName.length === 0 && selectDairyProductName !== ''){
                        jQuery('#retrieveSelectedDairyProductNameInput').append(`<option value="${response.product.productNameID}" selected>${response.product.product_name}</option>`);
                    }else{
                        existingDairyProductName.prop('selected', true);
                    }
                }
                retrieveProductDateProduceInput.val(response.product.date_produce);
                retrieveProductDateExpirationInput.val(formattedDate(response.product.date_expiration));
                retrieveProductPriceInput.val(response.product.price);
                retrieveProductStatus.val(response.product.status)
                jQuery('#retrieveProductCodeInput').val(response.product.product_code);
                jQuery('#retrieveProductCategoryInput').val(response.product.product_category);
                // Dynamically hide date expiration field if the product is category is grains and cereals
                if(response.product.product_category === 'grains and cereals'){
                    jQuery('#retrieveProductDateExpirationContainer').hide();
                    jQuery('#retrieveDiaryUnitOfPriceContainer').hide();
                    jQuery('#retrieveGrainsAndCerealsUnitOfPriceContainer').show();
                    const selectedUnitOfPrice = response.product.unit_of_price;
                    const existingUnitOfPrice = retrieveGrainsAndCerealsUnitOfPriceInput.find(`option[value="${response.product.unit_of_price}"]`);
                    if (existingUnitOfPrice.length === 0 && selectedUnitOfPrice !== '') {
                        retrieveGrainsAndCerealsUnitOfPriceInput.append(`<option value="${selectedUnitOfPrice}" selected>${selectedUnitOfPrice}</option>`);
                    }else{
                        existingUnitOfPrice.prop('selected', true);
                    }
                }
                if(response.product.product_category === 'dairy'){
                    jQuery('#retrieveProductDateExpirationContainer').show();
                    jQuery('#retrieveDiaryUnitOfPriceContainer').show();
                    jQuery('#retrieveGrainsAndCerealsUnitOfPriceContainer').hide();
                    const selectedUnitOfPrice = response.product.unit_of_price;
                    const existingUnitOfPrice = retrieveDairyUnitOfPriceInput.find(`option[value="${response.product.unit_of_price}"]`);
                    if (existingUnitOfPrice.length === 0 && selectedUnitOfPrice !== '') {
                        retrieveDairyUnitOfPriceInput.append(`<option value="${selectedUnitOfPrice}" selected>${selectedUnitOfPrice}</option>`);
                    }else{
                        existingUnitOfPrice.prop('selected', true);
                    }
                }
                jQuery('#productBarcodeToPrint').attr('src', response.product.barcode_image);
                
            }
            if(response.error){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                    showConfirmButton: false
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function fetchProductNameByID(
    productNameId,
    productName,
    productCode,
    productCategory,
    productNameToBeDeleted,
    productNameToBeDeletedId,
    id
    ){
    jQuery.ajax({
        type: 'GET',
        url: './controller/product/FetchProductNameByIDController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                productNameId.val(id)
                productName.val(response.product.product_name)
                productCode.val(response.product.product_code)
                productCategory.val(response.product.product_category)
                productNameToBeDeletedId.val(id)
                productNameToBeDeleted.text(response.product.product_name);
                // This will trigger the addition of a product when the admin selects a product name.
                jQuery('#productCodeInput, #retrieveProductCodeInput').val(response.product.product_code);
                jQuery('#productCategoryInput, #retrieveProductCategoryInput').val(response.product.product_category);
                // Dynamically hide date expiration field if the product is category is grains and cereals
                if(response.product.product_category === 'grains and cereals'){
                    jQuery('#productDateExpirationInputContainer, #diaryUnitOfPriceContainer').hide();
                    jQuery('#grainsAndCerealsUnitOfPriceContainer').show();
                }
                if(response.product.product_category === 'dairy'){
                    jQuery('#productDateExpirationInputContainer, #diaryUnitOfPriceContainer').show();
                    jQuery('#grainsAndCerealsUnitOfPriceContainer').hide();
                }
            }
            if(response.error){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                    showConfirmButton: false
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function fetchData(page, searchQuery) {
    jQuery.ajax({
        url: './controller/product/FetchProductController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            jQuery('#data-container, #grains-and-cereals-container, #pos-products-container, #inventory-dairy-product-data-container, #inventory-grains-and-cereals-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateProduce = new Date(response.data[i].date_produce);
                let dateExpiration = new Date(response.data[i].date_expiration);
                let productId = response.data[i].id;
                if(response.data[i].product_category === 'dairy') {
                    jQuery('#data-container').append(`<tr>
                        <td>${response.data[i].total_quantity}</td>
                        <td>${response.data[i].added_quantity}</td>
                        <td class="text-capitalize">${response.data[i].product_name}</td>
                        <td class="text-capitalize">${response.data[i].product_code}</td>
                        <td>${dateProduce.toDateString()}</td>
                        <td>${dateExpiration.toDateString()}</td>
                        <td>${formatCurrency(response.data[i].price)} / ${response.data[i].unit_of_price}</td>
                        <td>
                            <span class="badge ${response.data[i].status == 'new' ? 'text-bg-success': 'text-bg-warning'} text-capitalize py-2 px-4">${response.data[i].status}</span>
                        </td>
                        <td class="text-center col-md-2">
                            <button type="button" class="btn btn-sm" id="retriveProductBarcode" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductBarcodeModal" data-bs-auto-close="false">
                                <i class="bi bi-upc-scan fs-4 text-info"></i>
                            </button>
                            <button type="button" class="btn btn-sm" id="retrieveProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductModal" data-bs-auto-close="false">
                                <i class="bi bi-pencil-square fs-4 text-success"></i>
                            </button>
                            <button type="button" class="btn btn-sm" id="confirmDeleteProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-bs-auto-close="false">
                                <i class="bi bi-trash fs-4 text-danger"></i>
                            </button>
                        </td>
                    </tr>`);
                    // Generate pagination links
                    jQuery('#pagination-links').empty();

                    // Previous Button
                    jQuery('#pagination-links').append(`
                        <li class="page-item ${page === 1 ? 'disabled' : ''}">
                            <a class="page-link products-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    `);
                    
                    // Page Numbers
                    for (let i = 1; i <= response.categories.dairy.total_pages; i++) {
                        jQuery('#pagination-links').append(`
                            <li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link products-page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `);
                    }

                    // Next Button
                    jQuery('#pagination-links').append(`
                        <li class="page-item ${page === response.categories.dairy.total_pages ? 'disabled' : ''}">
                            <a class="page-link products-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    `);
                } else if(response.data[i].product_category === 'grains and cereals') {
                    jQuery('#grains-and-cereals-container').append(`<tr>
                        <td>${response.data[i].total_quantity}</td>
                        <td>${response.data[i].added_quantity}</td>
                        <td class="text-capitalize">${response.data[i].product_name}</td>
                        <td class="text-capitalize">${response.data[i].product_code}</td>
                        <td>${dateProduce.toDateString()}</td>
                        <td>${formatCurrency(response.data[i].price)} / ${response.data[i].unit_of_price}</td>
                        <td>
                            <span class="badge ${response.data[i].status == 'new' ? 'text-bg-success': 'text-bg-warning'} text-capitalize py-2 px-4">${response.data[i].status}</span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm" id="retriveProductBarcode" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductBarcodeModal" data-bs-auto-close="false">
                                <i class="bi bi-upc-scan fs-4 text-info"></i>
                            </button>
                            <button type="button" class="btn btn-sm" id="retrieveProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductModal" data-bs-auto-close="false">
                                <i class="bi bi-pencil-square fs-4 text-success"></i>
                            </button>
                            <button type="button" class="btn btn-sm" id="confirmDeleteProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-bs-auto-close="false">
                                <i class="bi bi-trash fs-4 text-danger"></i>
                            </button>
                        </td>
                    </tr>`);
                    // Generate pagination links
                    jQuery('#grains-and-cereals-pagination-links').empty();

                    // Previous Button
                    jQuery('#grains-and-cereals-pagination-links').append(`
                        <li class="page-item ${page === 1 ? 'disabled' : ''}">
                            <a class="page-link products-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    `);
                    
                    // Page Numbers
                    for (let i = 1; i <= response.categories.grains_cereals.total_pages; i++) {
                        jQuery('#grains-and-cereals-pagination-links').append(`
                            <li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link products-page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `);
                    }

                    // Next Button
                    jQuery('#grains-and-cereals-pagination-links').append(`
                        <li class="page-item ${page === response.categories.grains_cereals.total_pages ? 'disabled' : ''}">
                            <a class="page-link products-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    `);
                }
            }

            jQuery('#totalProduct').text(response.pagination.total_items);
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}

function fetchProductName(page, searchQuery){
    jQuery.ajax({
        type: 'GET',
        url: './controller/product/FetchProductNameController.php',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response){
            jQuery('#product-name-data-container').empty();
            if(response.success){
                let options = "";
                for(let i = 0; i < response.product_names.length; i++){
                    const productNameId = response.product_names[i].id
                    options += `<option value="${response.product_names[i].id}" data-temp="true">${response.product_names[i].product_name}</option>`;
                    jQuery('#product-name-data-container').append(`<tr>
                        <td class="text-capitalize">${response.product_names[i].product_name}</td>
                        <td>${response.product_names[i].product_code}</td>
                        <td class="text-capitalize">${response.product_names[i].product_category}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm" id="retrieveProductName" data-id="${productNameId}" data-bs-toggle="modal" data-bs-target="#retrieveProductNameModal" data-bs-auto-close="false">
                                <i class="bi bi-pencil-square fs-4 text-success"></i>
                            </button>
                            <button type="button" class="btn btn-sm" id="confirmDeleteProductName" data-id="${productNameId}"  data-bs-toggle="modal" data-bs-target="#deleteProductNameModal" data-bs-auto-close="false">
                                <i class="bi bi-trash fs-4 text-danger"></i>
                            </button>
                        </td>
                    </tr>`);

                    if(response.product_names[i].product_category.toLowerCase() === 'dairy'){
                        jQuery('#selectDairyProductNameInput, #retrieveSelectedDairyProductNameInput').append(`<option value="${response.product_names[i].id}" data-temp="true">${response.product_names[i].product_name}</option>`)
                        
                    }

                    if(response.product_names[i].product_category.toLowerCase() === 'grains and cereals'){
                        jQuery('#selectGrainsAndCerealsProductNameInput, #retrieveSelectedGrainsAndCerealsProductNameInput').append(`<option value="${response.product_names[i].id}" data-temp="true">${response.product_names[i].product_name}</option>`)
                    }
                }

                // Remove the previously appended selected option
                // jQuery("#selectDairyProductNameInput, #selectGrainsAndCerealsProductNameInput").find('option[data-temp="true"]').remove();

                // jQuery("#retrieveSelectedDairyProductNameInput, #retrieveSelectedGrainsAndCerealsProductNameInput").find('option[data-temp="true"]').remove();


                // Generate pagination links
                jQuery('#product-name-pagination-links').empty();

                // Previous Button
                jQuery('#product-name-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link product-name-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);
                
                // Page Numbers
                for (let i = 1; i <= response.total_pages; i++) {
                    jQuery('#product-name-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link product-name-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Button
                jQuery('#product-name-pagination-links').append(`
                    <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                        <a class="page-link product-name-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `);
            }
            if(response.error){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                    showConfirmButton: false
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function formatCurrency(price){
    const php = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    })

    return php.format(price);
}

function formattedDate(inputDate)
{
    const formattedDate = new Date(inputDate).toLocaleDateString("en-PH", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
      });
    
    return formattedDate
}

function reset() {
    jQuery('#quantityInput').val('');
    jQuery('#selectedProductNameInput').val('');
    jQuery('#productDateProduceInput').val('');
    jQuery('#productDateExpirationInput').val('');
    jQuery('#productPriceInput').val('');
    jQuery('#unitOfPriceInput').val('');
    jQuery('#productCodeInput').val('');
    jQuery('#productCategoryInput').val('');
}

function filterAndLoadPointOfSaleProducts(page, searchQuery){
    jQuery.ajax({
        url: './controller/product/FetchProductController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            jQuery('#pos-products-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let productId = response.data[i].id;
                displayPointOfSaleProducts(productId, response.data[i].quantity, response.data[i].product_name, response.data[i].price, response.data[i].unit_of_price)
            }

            jQuery('#pos-pagination-links').empty();

            // Previous Button
            jQuery('#pos-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link pos-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                jQuery('#pos-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link pos-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            jQuery('#pos-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link pos-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}

function displayPointOfSaleProducts(id, quantity, name, price, unit){
    const productData = `
    <tr class="text-center">
        <td hidden>
            <input type="hidden" class="pos-product-id" data-id="${id}">
        </td>
        <td>
            <input type="number" class="form-control w-100 quantity-input" data-id="${id}" value="0" min="1" max="${quantity}">
        </td>
        <td class="product-name">${name}</td>
        <td class="price" data-value="${price}">${formatCurrency(price)}</td>
        <td class="text-capitalize unit-of-price">${unit}</td>
    </tr>`;
    jQuery('#pos-products-container').append(productData);
}
