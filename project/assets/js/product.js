jQuery(function($){
    let retrieveQuantityInput = $('#retrieveQuantityInput');
    let retrieveSelectedProductNameInput = $("#retrieveSelectedProductNameInput")
    let retrieveProductDateProduceInput = $('#retrieveProductDateProduceInput');
    let retrieveProductDateExpirationInput = $('#retrieveProductDateExpirationInput');
    let retrieveProductPriceInput = $('#retrieveProductPriceInput');
    let retrieveUnitOfPriceInput = $('#retrieveUnitOfPriceInput');
    let retrieveProductStatus = $('#retrieveProductStatusInput');
    let retrieveProductCategory = $('#retrieveProductCategoryInput');
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
    let debounceTimer; // Timer for debouncing
    let currentSearch = ''; // Store last search value

    // The product's expiry date will be automatically displayed once the production date is selected.
    $(document).on('change', '#productDateProduceInput, #retrieveProductDateProduceInput', function(){
        const productionDate = new Date($(this).val());
        if (!isNaN(productionDate.getTime())) {
            const expiryDate = new Date(productionDate);
            expiryDate.setMonth(expiryDate.getMonth() + 3);

            const formattedDate = [
                String(expiryDate.getMonth() + 1).padStart(2, '0'), // Month (2 digits)
                String(expiryDate.getDate()).padStart(2, '0'), // Day (2 digits)
                expiryDate.getFullYear()  // Year (4 digits)
            ].join('/');
            
            $('#productDateExpirationInput, #retrieveProductDateExpirationInput').val(formattedDate);

        }
    })

    // Load product when product tab selected
    $('#products-tab').on('click', function(){
        fetchData(1, '');
    });

    // Add Product
    $(document).on('submit', '#addProduct', function(e){
        e.preventDefault();

        const productQuantity = $('#quantityInput').val();
        const productName = $('#selectedProductNameInput').val();
        const productCategory = $('#productCategoryInput').val();
        const productDateProduce = $('#productDateProduceInput').val();
        const productPrice = $('#productPriceInput').val();
        const productUnitOfPrice = $('#unitOfPriceInput').val();

        const payload = {
            product_quantity: productQuantity,
            selected_product_name: productName,
            product_category: productCategory,
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
                            fetchData(1, '');
                            fetchProductName(1, '');
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

    // Add Product Name
    $(document).on('click', '#addProductName', function(){
        const payload = {
            product_name: $('#productNameInput').val(),
            product_code: $('#productCodeInput').val()
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
                            fetchData(1, '');
                            fetchProductName(1, '');
                            $('#productNameInput, #productCodeInput').val('')
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
        clearTimeout(debounceTimer); // Clear previous timer
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery; // Update current search
            fetchData(1, searchQuery); // Fetch data after 5 seconds
        }, 500); // 5-second debounce
    });

    // Debounced search input event for product names
    $('#searchProductName').on('keyup', function() {
        clearTimeout(debounceTimer); // Clear previous timer
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery; // Update current search
            fetchProductName(1, searchQuery); // Fetch data after 5 seconds
        }, 500); // 5-second debounce
    });

    // Retrieve Product by ID
    $(document).on('click', '#retrieveProduct', function(){
        let id = $(this).data('id')
        fetchProductByID(
            retrieveQuantityInput,
            retrieveSelectedProductNameInput,
            retrieveProductDateProduceInput,
            retrieveProductDateExpirationInput,
            retrieveProductPriceInput,
            retrieveUnitOfPriceInput,
            retrieveProductStatus,
            retrieveProductCategory,
            selectedProductName,
            productId,
            deleteProductId,
            id);
    })

    // Retrieve Product Name by ID
    $(document).on('click', '#retrieveProductName', function(){
        let id = $(this).data('id')
        fetchProductNameByID(
            productNameId,
            newProductName,
            newProductCode,
            productNameToBeDeleted,
            productNameToBeDeletedId,
            id);
    })

    // Opening confirmation modal to delete the product.
    $(document).on('click', '#confirmDeleteProduct', function(){
        let id = $(this).data('id');
        fetchProductByID(
            retrieveQuantityInput,
            retrieveSelectedProductNameInput,
            retrieveProductDateProduceInput,
            retrieveProductDateExpirationInput,
            retrieveProductPriceInput,
            retrieveUnitOfPriceInput,
            retrieveProductStatus,
            retrieveProductCategory,
            selectedProductName,
            productId,
            deleteProductId,
            id);
    })

    // Opening confirmation modal to delete product name
    $(document).on('click', '#confirmDeleteProductName', function(){
        let id = $(this).data('id');
        fetchProductNameByID(
            productNameId,
            newProductName,
            newProductCode,
            productNameToBeDeleted,
            productNameToBeDeletedId,
            id);
    })

    // Update Products
    $(document).on('click', '#editProduct', function(){
        updateProduct(
            retrieveQuantityInput,
            retrieveSelectedProductNameInput,
            retrieveProductDateProduceInput,
            retrieveProductDateExpirationInput,
            retrieveProductPriceInput,
            retrieveUnitOfPriceInput,
            retrieveProductCategory,
            productId);
    })

    // Update Product Name
    $(document).on('click', '#editProductName', function(){
        updateProductName(productNameId, newProductName, newProductCode)
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

    $.ajax({
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
                        $('#productPasswordInput').val('');
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
                        fetchData(1, '');
                        $('#productPasswordInput').val('');
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

    $.ajax({
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
                        $('#productNamePasswordInput').val('');
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
                        $('#productNamePasswordInput').val('');
                    }
                });
            }
        },
        error: function(error, status){
            console.log(error)
        }
    })
}

function updateProduct(
    retrieveQuantityInput,
    retrieveSelectedProductNameInput,
    retrieveProductDateProduceInput,
    retrieveProductDateExpirationInput,
    retrieveProductPriceInput,
    retrieveUnitOfPriceInput,
    retrieveProductCategory,
    productId){
    const payload = {
        id: productId.val(),
        product_quantity: retrieveQuantityInput.val(),
        product_name_id: retrieveSelectedProductNameInput.val(),
        product_category: retrieveProductCategory.val(),
        product_date_produce: retrieveProductDateProduceInput.val(),
        product_date_expiration: retrieveProductDateExpirationInput.val(),
        product_price: retrieveProductPriceInput.val(),
        product_unit_of_price: retrieveUnitOfPriceInput.val(),
    }

    $.ajax({
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

function updateProductName(productNameId, newProductName, newProductCode){
    const payload = {
        id: productNameId.val(),
        product_name: newProductName.val(),
        product_code: newProductCode.val()
    }

    $.ajax({
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

function fetchProductByID(
    retrieveQuantityInput,
    retrieveSelectedProductNameInput,
    retrieveProductDateProduceInput,
    retrieveProductDateExpirationInput,
    retrieveProductPriceInput,
    retrieveUnitOfPriceInput,
    retrieveProductStatus,
    retrieveProductCategory,
    selectedProductName,
    productId,
    deleteProductId,
    id){
    $.ajax({
        type: 'GET',
        url: './controller/product/FetchProductByIDController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                deleteProductId.val(id)
                productId.val(id)
                selectedProductName.text(response.product.product_name); // Append name in delete modal
                retrieveQuantityInput.val(response.product.quantity);
                retrieveSelectedProductNameInput.find(`option[value="${response.product.productNameID}"]`).remove(); // remove duplicate appended product name
                retrieveSelectedProductNameInput.append(`<option value="${response.product.productNameID}" selected>${response.product.product_name}</option>`);
                retrieveProductDateProduceInput.val(response.product.date_produce);
                retrieveProductDateExpirationInput.val(formattedDate(response.product.date_expiration));
                retrieveProductPriceInput.val(response.product.price);
                if (retrieveUnitOfPriceInput.find(`option[value="${response.product.unit_of_price}"]`).length === 0) {
                    retrieveUnitOfPriceInput.append(`<option value="${response.product.unit_of_price}" selected>${response.product.unit_of_price}</option>`);
                }
                retrieveProductStatus.val(response.product.status)
                if (retrieveProductCategory.find(`option[value="${response.product.category}"]`).length === 0) {
                    retrieveProductCategory.append(`<option value="${response.product.category}" selected>${response.product.category}</option>`);
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

function fetchProductNameByID(
    productNameId,
    productName,
    productCode,
    productNameToBeDeleted,
    productNameToBeDeletedId,
    id
    ){
    $.ajax({
        type: 'GET',
        url: './controller/product/FetchProductNameByIDController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                productNameId.val(id)
                productName.val(response.product.product_name)
                productCode.val(response.product.product_code)
                productNameToBeDeletedId.val(id)
                productNameToBeDeleted.text(response.product.product_name);
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
    $.ajax({
        url: './controller/product/FetchProductController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            // Populate table with fetched data
            $('#data-container, #grains-and-cereals-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateProduce = new Date(response.data[i].date_produce);
                let dateExpiration = new Date(response.data[i].date_expiration);
                let productId = response.data[i].id;
                if(response.data[i].category === 'dairy') {
                    $('#data-container').append(`<tr>
                        <td>${response.data[i].quantity}</td>
                        <td class="text-capitalize">${response.data[i].product_name}</td>
                        <td class="text-capitalize">${response.data[i].product_code}</td>
                        <td>${dateProduce.toDateString()}</td>
                        <td>${dateExpiration.toDateString()}</td>
                        <td>${formatCurrency(response.data[i].price)}</td>
                        <td class="text-capitalize">${response.data[i].unit_of_price}</td>
                        <td class="text-capitalize"><span class="badge text-bg-success">${response.data[i].status}</span></td>
                        <td class="flex flex-row justify-content-between">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" id="retrieveProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductModal" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmDeleteProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                        </td>
                    </tr>`);
                } else if(response.data[i].category === 'grains and cereals') {
                    $('#grains-and-cereals-container').append(`<tr>
                        <td>${response.data[i].quantity}</td>
                        <td class="text-capitalize">${response.data[i].product_name}</td>
                        <td class="text-capitalize">${response.data[i].product_code}</td>
                        <td>${dateProduce.toDateString()}</td>
                        <td>${formatCurrency(response.data[i].price)}</td>
                        <td class="text-capitalize">${response.data[i].unit_of_price}</td>
                        <td class="text-capitalize"><span class="badge text-bg-success">${response.data[i].status}</span></td>
                        <td class="flex flex-row justify-content-between">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" id="retrieveProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#retrieveProductModal" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmDeleteProduct" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                        </td>
                    </tr>`);
                }
            }

            $('#totalProduct').text(response.total_products);

            // Generate pagination links
            $('#pagination-links, #grains-and-cereals-pagination-links').empty();

            // Previous Button
            $('#pagination-links, #grains-and-cereals-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link products-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                $('#pagination-links, #grains-and-cereals-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link products-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            $('#pagination-links, #grains-and-cereals-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link products-page-link" href="#" data-page="${page + 1}" aria-label="Next">
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

function fetchProductName(page, searchQuery){
    $.ajax({
        type: 'GET',
        url: './controller/product/FetchProductNameController.php',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response){
            $('#product-name-data-container').empty();
            if(response.success){
                let options = "";
                for(let i = 0; i < response.product_names.length; i++){
                    const productNameId = response.product_names[i].id
                    options += `<option value="${response.product_names[i].id}" data-temp="true">${response.product_names[i].product_name}</option>`;
                    $('#product-name-data-container').append(`<tr>
                        <td>${response.product_names[i].product_name}</td>
                        <td>${response.product_names[i].product_code}</td>
                        <td class="flex flex-row justify-content-between text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" id="retrieveProductName" data-id="${productNameId}" data-bs-toggle="modal" data-bs-target="#retrieveProductNameModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmDeleteProductName" data-id="${productNameId}" data-bs-toggle="modal" data-bs-target="#deleteProductNameModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                        </td>
                    </tr>`);
                }

                // Remove the previously appended selected option
                $("#selectedProductNameInput").find('option[data-temp="true"]').remove();
                $("#retrieveSelectedProductNameInput").find('option[data-temp="true"]').remove();
                // Append the new selected status option
                $("#selectedProductNameInput").append(options);
                $("#retrieveSelectedProductNameInput").append(options);

                // Generate pagination links
                $('#product-name-pagination-links').empty();

                // Previous Button
                $('#product-name-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link product-name-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);
                
                // Page Numbers
                for (let i = 1; i <= response.total_pages; i++) {
                    $('#product-name-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link product-name-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Button
                $('#product-name-pagination-links').append(`
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
    const formattedDate = new Date(inputDate).toLocaleDateString("en-US", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
      });
    
    return formattedDate
}

function reset() {
    $('#quantityInput').val('');
    $('#selectedProductNameInput').val('');
    $('#productDateProduceInput').val('');
    $('#productDateExpirationInput').val('');
    $('#productPriceInput').val('');
    $('#unitOfPriceInput').val('');
}
