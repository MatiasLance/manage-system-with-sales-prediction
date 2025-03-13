jQuery(function($){
    $('#saveEmployeeData').on('submit', function(e){
        e.preventDefault();

        const data = $(this).serializeArray();

        $.ajax({
            type: "POST",
            url: "./controller/AddEmployeeController.php",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire("Success", response.message, "success");
                } else {
                    Swal.fire("Error", response.message.join('<br>'), "error");
                }
                $('#saveEmployeeData')[0].reset();
            },
            error: function(error) {
                console.error("AJAX Error:", error);
            }
        });
    })

    // Initially fetch employees
    fetchEmployees(1, '');
})

function fetchEmployees(page, searchQuery){
    $.ajax({
        url: './controller/FetchEmployeeController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            // Populate table with fetched data
            $('#employee-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateOfHire = new Date(response.data[i].date_of_hire);
                let dateOfBirth = new Date(response.data[i].date_of_birth);
                let employeeId = response.data[i].id;
                $('#employee-data-container').append(`<tr>
                    <td>${response.data[i].full_name}</td>
                    <td class="text-capitalize">${response.data[i].working_department}</td>
                    <td class="text-capitalize">${response.data[i].phone_number}</td>
                    <td>${dateOfHire.toDateString()}</td>
                    <td class="text-capitalize">${response.data[i].job}</td>
                    <td class="text-capitalize">${response.data[i].educational_level}</td>
                    <td class="text-capitalize">${response.data[i].gender}</td>
                    <td>${dateOfBirth.toDateString()}</td>
                    <td class="text-capitalize">${formatCurrency(response.data[i].salary)}</td>
                    <td class="flex flex-row justify-content-between">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" id="retrieveEmployee" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#retrieveProductModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmDeleteEmployee" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#deleteProductModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                    </td>
                </tr>`);
            }

            $('#totalProduct').text(response.total_products);

            // Generate pagination links
            $('#employee-pagination-links').empty();

            // Previous Button
            $('#employee-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link products-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                $('#employee-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link products-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            $('#employee-pagination-links').append(`
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

function formatCurrency(price){
    const php = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    })

    return php.format(price);
}