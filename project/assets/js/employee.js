let employeeDebounceTimer;
let employeeCurrentSearch = '';

jQuery(function($){

    $('#saveEmployeeData').on('submit', function(e){
        e.preventDefault();
        const data = $(this).serializeArray();
        saveEmployeeDetails(data);
    })

    $('#employees-tab').on('click', function(){
        fetchEmployees(1, employeeCurrentSearch);
    })

    $(document).on('click', '#retrieveEmployee', function() {
        const id = $(this).data('id');
        retrieveEmployeeById(id);
    })

    $(document).on('submit', '#updateEmployeeDetail', function(e){
        e.preventDefault();
        const employeeDetailData = $(this).serializeArray();
        updateEmployeeDetail(employeeDetailData);
    })

    $(document).on('click', '#confirmDeleteEmployee', function() {
        const id = $(this).data('id');
        retrieveEmployeeById(id);
    })

    $(document).on('click', '#deleteEmployee', function(){
        const payload = {
            id: $('#deleteEmployeeId').val(),
            password: $('#employeePasswordInput').val()
        }
        deleteEmployeeDetail(payload);
    })

    // Pagination click event for employee
    $(document).on('click', '.employee-page-link', function(e) {
        e.preventDefault();
        clearTimeout(employeeDebounceTimer);
        let page = $(this).data('page');

        employeeDebounceTimer = setTimeout(() => {
            fetchEmployees(page, employeeCurrentSearch);
        }, 500);
        
    });

    // Debounced search input event for employee
    $('#search-employee').on('keyup', function() {
        clearTimeout(employeeDebounceTimer);
        let searchQuery = $(this).val();

        employeeDebounceTimer = setTimeout(() => {
            employeeCurrentSearch = searchQuery;
            fetchEmployees(1, searchQuery);
        }, 500);
    });

    fetchEmployees(1, '');
})

function fetchEmployees(page, searchQuery){
    jQuery.ajax({
        url: './controller/employee/ListOfEmployeeController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            // Populate table with fetched data
            jQuery('#employee-data-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let dateOfHire = new Date(response.data[i].date_of_hire);
                let dateOfBirth = new Date(response.data[i].date_of_birth);
                let employeeId = response.data[i].id;
                jQuery('#employee-data-container').append(`<tr>
                    <td>${response.data[i].full_name}</td>
                    <td class="text-capitalize">${response.data[i].working_department}</td>
                    <td class="text-capitalize">${response.data[i].phone_number}</td>
                    <td>${dateOfHire.toDateString()}</td>
                    <td class="text-capitalize">${response.data[i].job}</td>
                    <td class="text-capitalize">${response.data[i].educational_level}</td>
                    <td class="text-capitalize">${response.data[i].gender}</td>
                    <td>${dateOfBirth.toDateString()}</td>
                    <td class="text-capitalize">${formatCurrency(response.data[i].salary)}</td>
                    <td>${response.data[i].email}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm" id="retrieveEmployee" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#retrieveEmployeeModal" data-bs-auto-close="false">
                            <i class="bi bi-pencil-square fs-4 text-success"></i>
                        </button>
                        <button type="button" class="btn btn-sm" id="confirmDeleteEmployee" data-id="${employeeId}" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal" data-bs-auto-close="false">
                            <i class="bi bi-trash fs-4 text-danger"></i>
                        </button>
                    </td>
                </tr>`);
            }

            jQuery('#totalEmployees').text(response.total_employees ? response.total_employees : 0);

            // Generate pagination links
            jQuery('#employee-pagination-links').empty();

            // Previous Button
            jQuery('#employee-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link employee-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                jQuery('#employee-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link employee-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            jQuery('#employee-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link employee-page-link" href="#" data-page="${page + 1}" aria-label="Next">
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

function retrieveEmployeeById(id){
    jQuery.ajax({
        type: 'GET',
        url: './controller/employee/RetrieveEmployeeController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                const genderValue = response.gender;
                const departmentValue = response.working_department;
                const jobValue = response.job;
                const educationalLevelValue = response.educational_level
                jQuery('#editedWorkingDepartmentInput').find(`option[value="${departmentValue}"]`).remove();
                jQuery('#editedJobInput').find(`option[value="${jobValue}"]`).remove();
                jQuery('#employeeId').val(id);
                jQuery('#deleteEmployeeId').val(id);
                jQuery('#editedFirstNameInput').val(response.first_name);
                jQuery('#editedMiddleNameInput').val(response.middle_initial);
                jQuery('#editedLastNameInput').val(response.last_name);
                jQuery('#employeeNameToBeDelete').text(`${response.first_name} ${response.last_name}`);
                const existingDepartmentOption = $(`#editedWorkingDepartmentInput option[value="${departmentValue}"]`)
                if (existingDepartmentOption.length > 0) {
                    existingDepartmentOption.prop('selected', true);
                } else {
                    $('#editedWorkingDepartmentInput').prepend(`<option value="${departmentValue}" selected>${departmentValue}</option>`);
                }
                jQuery('#editedPhoneNumberInput').val(response.phone_number);
                jQuery('#editedDateOfHireInput').val(response.date_of_hire);
                const existingJobOption = jQuery(`#editedJobInput option[value="${jobValue}"]`)
                if (existingJobOption.length > 0) {
                    existingJobOption.prop('selected', true);
                } else {
                    jQuery('#editedJobInput').prepend(`<option value="${jobValue}" selected>${jobValue}</option>`);
                }
                const existingEducationalLevelOption = jQuery(`#editedEducationalLevelInput option[value="${educationalLevelValue}"]`)
                if (existingEducationalLevelOption.length > 0) {
                    existingEducationalLevelOption.prop('selected', true);
                } else {
                    jQuery('#editedEducationalLevelInput').prepend(`<option value="${jobValue}" selected>${educationalLevelValue}</option>`);
                }
                const existingGenderOption = jQuery(`#editedGenderInput option[value="${genderValue}"]`);
                if (existingGenderOption.length > 0) {
                    existingGenderOption.prop('selected', true);
                } else {
                    jQuery('#editedGenderInput').prepend(`<option value="${genderValue}" selected>${genderValue}</option>`);
                }
                jQuery('#editedDateOfBirthInput').val(response.date_of_birth);
                jQuery('#editedSalaryInput').val(response.salary);
                jQuery('#editedEmployeeEmail').val(response.email)
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

function saveEmployeeDetails(data) {
    jQuery.ajax({
        type: "POST",
        url: "./controller/employee/AddEmployeeController.php",
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                Swal.fire("Success", response.message, "success");
            } else {
                Swal.fire("Error", response.message.join('<br>'), "error");
            }
            jQuery('#saveEmployeeData')[0].reset();
            jQuery('#addEmployeeModal').modal('hide');
            fetchEmployees(1, '');
        },
        error: function(error) {
            console.error("AJAX Error:", error);
        }
    });
}

function updateEmployeeDetail(data){
   jQuery.ajax({
        type: "POST",
        url: "./controller/employee/UpdateEmployeeDetailController.php",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                Swal.fire("Success", response.message, "success")
                .then((result) => {
                    if(result.isConfirmed){
                        fetchEmployees(1, '');
                    }
                });
            } else {
                Swal.fire("Error", response.message[0], "error");
            }
        },
        error: function (error) {
            console.error("AJAX Error:", error);
        }
    });
}

function deleteEmployeeDetail(payload){
    jQuery.ajax({
        type: 'POST',
        url: './controller/employee/DeleteEmployeeController.php',
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
                        fetchEmployees(1, '');
                        $('#employeePasswordInput').val('');
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
                $('#employeePasswordInput').val('');
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