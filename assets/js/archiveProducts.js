jQuery(function($){
    let debounceTimer;
    let currentSearch = '';

    listArchivedData(1, '');

    $('#archived-data-tab').on('click', function(){
        listArchivedData(1, '');
    })

    $(document).on('click', '#openRestoreArchivedProductModal', function(){
        const id = $(this).data('id');
        $('#restoreArchivedProductId').val(id);
    })

    $(document).on('click', '#openDeleteArchivedProductModal', function() {
        const id = $(this).data('id');
        $('#deleteArchivedProductId').val(id);
    })

    $('#permanentlyDeleteArchivedProduct').on('submit', function(e) {
        e.preventDefault();
        const payload = {
            id: $('#deleteArchivedProductId').val(),
            password: $('#deleteArchivedPasswordInput').val()
        }

        deleteArchivedProductData(payload)
    })

    $(document).on('submit', '#restoreArchivedProduct', function(e){
        e.preventDefault();
        const payload = {
            id: $('#restoreArchivedProductId').val(),
            password: $('#restoreArchivedPasswordInput').val()
        }
        restoreArchivedProductData(payload)
    });

    // Debounced search input event for archive product names
    $('#searchAchivedProductName').on('keyup', function() {
        clearTimeout(debounceTimer);
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery;
            listArchivedData(1, searchQuery);
        }, 500);
    });
});

function listArchivedData(page, searchQuery) {
    $.ajax({
        url: './controller/ListArchivedProductController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            $('#archived-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateProduce = new Date(response.data[i].date_produce);
                let dateExpiration = new Date(response.data[i].date_expiration);
                let productId = response.data[i].id;
                $('#archived-data-container').append(`<tr>
                    <td>${response.data[i].total_quantity}</td>
                    <td class="text-capitalize">${response.data[i].product_name}</td>
                    <td>${response.data[i].product_code}</td>
                    <td>${dateProduce.toDateString()}</td>
                    <td>${dateExpiration.toDateString()}</td>
                    <td>${formatCurrency(response.data[i].price)} / ${response.data[i].unit_of_price}</td>
                    <td>
                        <span class="badge ${response.data[i].status == 'new' ? 'text-bg-success': 'text-bg-warning'} text-capitalize py-2 px-4">${response.data[i].status}</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm" id="openRestoreArchivedProductModal" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#restoreArchivedProductModal" data-bs-auto-close="false">
                            <i class="bi bi-recycle fs-4 text-success"></i>
                        </button>
                        <button type="button" class="btn btn-sm" id="openDeleteArchivedProductModal" data-id="${productId}" data-bs-toggle="modal" data-bs-target="#deleteArchivedProductModal" data-bs-auto-close="false">
                            <i class="bi bi-trash fs-4 text-danger"></i>
                        </button>
                    </td>
                </tr>`);
            }

            // Generate pagination links
            $('#archived-data-pagination-links').empty();

            // Previous Button
            $('#archived-data-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link arhived-data-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                $('#archived-data-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link arhived-data-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            $('#archived-data-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link arhived-data-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
        }
    });
}

function restoreArchivedProductData(payload){
    $.ajax({
        url: './controller/RestoreArchivedProductDataController.php',
        type: 'POST',
        data: payload,
        dataType: 'json',
        success: function(response) {
            if(response.success){
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        listArchivedData(1, '');
                        $('#restoreArchivedPasswordInput').val('')
                    }
                });
            }

            if(!response.success){
                Swal.fire({
                    title: 'error',
                    text: response.message,
                    icon: 'error',
                    showConfirmButton: false
                });
            }
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}

function deleteArchivedProductData(payload){
    $.ajax({
        url: './controller/DeleteArchivedProductDataController.php',
        type: 'POST',
        data: payload,
        dataType: 'json',
        success: function(response) {
            if(response.success){
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        listArchivedData(1, '');
                        $('#deleteArchivedPasswordInput').val('')
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
                        listArchivedData(1, '');
                        $('#deleteArchivedPasswordInput').val('')
                    }
                });
            }
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}