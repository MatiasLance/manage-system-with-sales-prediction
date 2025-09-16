let archivedEmployeesDebounceTimer;
let archivedEmployeesCurrentSearch = '';

jQuery(function($){
    listOfEmployeesArchivedData(1, '');

    $('#archived-employees-tab').on('click', function(){
        listOfEmployeesArchivedData(1, archivedEmployeesCurrentSearch);
    })

    $(document).on('click', '#openRestoreArchivedEmployeeModal', function(){
        const id = $(this).data('id');
        $('#restoreArchivedEmployeeId').val(id);
    })

    $(document).on('click', '#openDeleteArchivedEmployeeModal', function() {
        const id = $(this).data('id');
        $('#deleteArchivedEmployeeId').val(id);
    })

    $('#permanentlyDeleteArchivedEmployee').on('submit', function(e) {
        e.preventDefault();
        const payload = {
            id: $('#deleteArchivedEmployeeId').val(),
            password: $('#deleteArchivedEmployeePasswordInput').val()
        }

        deleteArchivedEmployeeData(payload)
    })

    $(document).on('submit', '#restoreArchivedEmployee', function(e){
        e.preventDefault();
        const payload = {
            id: $('#restoreArchivedEmployeeId').val(),
            password: $('#restoreArchivedEmployeePasswordInput').val()
        }
        restoreArchivedEmployeeData(payload)
    });

    $(document).on('click', '.archived-employees-page-link', function(e) {
        e.preventDefault();
        clearTimeout(archivedEmployeesDebounceTimer);
        let page = $(this).data('page');
        listOfEmployeesArchivedData(page, archivedEmployeesCurrentSearch);
        archivedEmployeesDebounceTimer = setTimeout(() => {
            listOfEmployeesArchivedData(page, archivedEmployeesCurrentSearch);
        }, 500);
    });

    $('#searchAchivedEmployees').on('keyup', function() {
        clearTimeout(archivedEmployeesDebounceTimer);
        let searchQuery = $(this).val();

        archivedEmployeesDebounceTimer = setTimeout(() => {
            archivedEmployeesCurrentSearch = searchQuery;
            listOfEmployeesArchivedData(1, searchQuery);
        }, 500);
    });
});

function listOfEmployeesArchivedData(page, searchQuery) {
    jQuery.ajax({
        url: './controller/employee/ListOfEmployeesArchivedDataController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            jQuery('#archived-employee-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateOfHire = new Date(response.data[i].date_of_hire);
                let dateOfBirth = new Date(response.data[i].date_of_birth);
                let employeeId = response.data[i].id;
                jQuery('#archived-employee-container').append(`<tr>
                    <td class="text-capitalize">${response.data[i].full_name}</td>
                    <td class="text-capitalize">${response.data[i].working_department}</td>
                    <td>${response.data[i].phone_number}</td>
                    <td>${dateOfHire.toDateString()}</td>
                    <td>${response.data[i].job}</td>
                    <td>${response.data[i].educational_level}</td>
                    <td>${response.data[i].gender}</td>
                    <td>${dateOfBirth.toDateString()}</td>
                    <td>${formatCurrency(response.data[i].salary)}</td>
                    <td>${response.data[i].email}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm" id="openRestoreArchivedEmployeeModal" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#restoreArchivedEmployeeModal" data-bs-auto-close="false">
                            <i class="bi bi-recycle fs-4 text-success"></i>
                        </button>
                        <button type="button" class="btn btn-sm" id="openDeleteArchivedEmployeeModal" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#deleteArchivedEmployeeModal" data-bs-auto-close="false">
                            <i class="bi bi-trash fs-4 text-danger"></i>
                        </button>
                    </td>
                </tr>`);
            }

            // Generate pagination links
            jQuery('#archived-employees-pagination-links').empty();

            // Previous Button
            jQuery('#archived-employees-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link archived-employees-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                jQuery('#archived-employees-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link archived-employees-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            jQuery('#archived-employees-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link archived-employees-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
        }
    });
}

function restoreArchivedEmployeeData(payload){
    jQuery.ajax({
        url: './controller/employee/RestoreArchivedEmployeeDataController.php',
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
                        listOfEmployeesArchivedData(1, '');
                        jQuery('#restoreArchivedEmployeePasswordInput').val('');
                        jQuery('#restoreArchivedEmployeeModal').modal('hide');
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

function deleteArchivedEmployeeData(payload){
    jQuery.ajax({
        url: './controller/employee/DeleteArchivedEmployeeDataController.php',
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
                        listOfEmployeesArchivedData(1, '');
                        jQuery('#deleteArchivedEmployeePasswordInput').val('');
                        jQuery('#deleteArchivedEmployeeModal').modal('hide');
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
                        listOfEmployeesArchivedData(1, '');
                        jQuery('#deleteArchivedEmployeePasswordInput').val('');
                        jQuery('#deleteArchivedEmployeeModal').modal('hide');
                    }
                });
            }
        },
        error: function() {
            console.error('Error loading data');
        }
    });
}