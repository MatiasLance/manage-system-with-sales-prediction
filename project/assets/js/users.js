const password = $('#userPassword');
const confirmPassword = $('#userConfirmPassword');
const passwordIcon = $('#toggleEmployeePassword i');
const confirmPasswordIcon = $('#toggleEmployeeConfirmPassword i');

jQuery(function($){
    save($)
    listUsers($, 1, '');

    $(document).on('click', '#toggleEmployeePassword', function() {
        const type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        passwordIcon.toggleClass('fa-eye fa-eye-slash');
    })

    $(document).on('click', '#toggleEmployeeConfirmPassword', function() {
        const type = confirmPassword.attr('type') === 'password' ? 'text' : 'password';
        confirmPassword.attr('type', type);
        confirmPasswordIcon.toggleClass('fa-eye fa-eye-slash');
    })

    $(document).on('click', '#retrieveUser', function() {
        const userId = $(this).data('id');
        retrieveUser($, userId);
    });
});

function listUsers($, page, searchQuery) {
    $.ajax({
        url: './controller/user/ListUserController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: "json",
        success: function(response) {
            $('#user-data-container tbody').empty();
            if (response.total_pages > 0) {
                const users = response.data;
                let userList = '';
                users.forEach(user => {
                    userList += `<tr>
                        <td class="text-capitalize">${user.full_name}</td>
                        <td>${user.email}</td>
                        <td><span class="badge text-bg-warning text-capitalize">${user.user_type}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm" id="retrieveUser" data-id="${user.id}"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-sm" id="deleteUser" data-id="${user.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                });
                $('#user-data-container').html(userList);

                $('#user-pagination-links').empty();

                $('#user-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link user-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);
                
                for (let i = 1; i <= response.total_pages; i++) {
                    $('#user-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link user-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                $('#user-pagination-links').append(`
                    <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                        <a class="page-link user-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `);

            } else {
                console.error('Failed to load users:', response.message);
            }
        },
        error: function() {
            console.error('An error occurred while fetching the user list.');
        }
    });
}

 function retrieveUser($, id) {
    $.ajax({
        url: './controller/user/RetrieveUserController.php',
        type: 'GET',
        data: { id: id },
        dataType: "json",
        success: function(response) {
            if (response) {
                const user = response;
                $('#userId').val(id);
                $('#editUserFirstNameInput').val(user.first_name);
                $('#editUserLastNameInput').val(user.last_name);
                $('#editUserEmail').val(user.email);

                const selectUserRole = user.user_type.toLowerCase();
                const roleSelect = $('#editUserRole');

                let option = roleSelect.find(`option[value="${selectUserRole}"]`);

                if (option.length === 0 && selectUserRole !== '') {
                    const newOption = $(`<option value="${selectUserRole}">${capitalize(selectUserRole)}</option>`);
                    roleSelect.append(newOption);
                }

                roleSelect.val(selectUserRole);

                roleSelect.trigger('change');

                $('#retrieveUserModal').modal('show');
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
            }
        },
        error: function() {
            console.error('An error occurred while retrieving the user.');
        }
    }); 
}

function save($) {
    $('#saveUserData').on('submit', function(e) {
        e.preventDefault();
        const data = $(this).serializeArray();

        $.ajax({
            url: './controller/user/AddUserController.php',
            type: 'POST',
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                    }).then((result) => {
                        if(result.isConfirmed) {
                            $('#saveUserData')[0].reset();
                            $('#addUserModal').modal('hide');
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'error',
                        text: response.message,
                        icon: 'error',
                    });
                }
            },
            error: function() {
                console.error('An error occurred while adding the user.');
            }
        });
    });
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}