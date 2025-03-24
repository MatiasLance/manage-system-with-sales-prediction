jQuery(function($){
    // Initially List all archived data
    listArchivedData(1, '');

    // Load product when archived tab selected
    $('#archived-data-tab').on('click', function(){
        listArchivedData(1, '');
    })


    $(document).on('click', '#openRestoreArchivedProductModal', function(){
        const id = $(this).data('id');
        $('#restoreArchivedProductId').val(id);
    })

    $(document).on('click', '#restoreArchivedProduct', function(){
        const payload = {
            id: $('#restoreArchivedProductId').val(),
            password: $('#restoreArchivedPasswordInput').val()
        }
        restoreArchivedProductData(payload)
    });
});

function listArchivedData(page, searchQuery) {
    $.ajax({
        url: './controller/ListArchivedProductController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            // Populate table with fetched data
            $('#archived-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateProduce = new Date(response.data[i].date_produce);
                let dateExpiration = new Date(response.data[i].date_expiration);
                let productId = response.data[i].id;
                $('#archived-data-container').append(`<tr>
                    <td>${response.data[i].quantity}</td>
                    <td class="text-capitalize">${response.data[i].product_name}</td>
                    <td><img src="${response.data[i].barcode_image}" alt="${response.data[i].product_name}"/></td>
                    <td>${dateProduce.toDateString()}</td>
                    <td>${dateExpiration.toDateString()}</td>
                    <td>${formatCurrency(response.data[i].price)}</td>
                    <td><span class="badge text-bg-success">${response.data[i].product_status}</span></td>
                    <td class="text-capitalize">${response.data[i].unit_of_price}</td>
                    <td class="flex flex-row justify-content-between">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="openRestoreArchivedProductModal" data-id="${productId}" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#restoreArchivedProductModal" data-bs-auto-close="false"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3C140.6 6.8 151.7 0 163.8 0zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm192 64c-6.4 0-12.5 2.5-17 7l-80 80c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39L200 408c0 13.3 10.7 24 24 24s24-10.7 24-24l0-134.1 39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-4.5-4.5-10.6-7-17-7z"/></svg>
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
        },
        error: function() {
            console.error('Error loading data');
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