let loginHistoryDebounceTimer;
let loginHistoryCurrentSearch = '';
let isLoadingLoginHistoryData = false;

jQuery(function(){
    loginHistoryList(1, '');

    $('#refreshLoginHistoryTable').on('click', function(){
        clearTimeout(loginHistoryDebounceTimer);
        loginHistoryDebounceTimer = setTimeout(() => {
            loginHistoryList(1, '');
        }, 500);
    });
});

function loginHistoryList(page, searchQuery) {
    jQuery.ajax({
        url: './controller/ListOfLoginHistoryController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: "json",
        beforeSend: function() {
            jQuery('#login-history-data-container').empty();
            jQuery('#login-history-data-container').append(
                `<tr>
                    <td colspan="6" class="text-center">
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>`);
            isLoadingLoginHistoryData = true
        },
        success: function(response) {
            jQuery('#login-history-data-container').empty();
            if (response.total_pages > 0) {
                const loginHistoryData = response.data;
                loginHistoryData.forEach(value => {
                    jQuery('#login-history-data-container').append(
                    `<tr>
                        <td class="text-capitalize">${value.firstname} ${value.lastname}</td>
                        <td>${value.user_agent}</td>
                        <td><span class="badge ${value.status === 'Active' ? 'text-bg-success' : 'text-bg-warning'} text-capitalize">${value.status}</span></td>
                        <td>${value.created_at}</td>
                        <td>${value.updated_at}</td>
                    </tr>`);
                });

                jQuery('#login-history-pagination-links').empty();

                jQuery('#login-history-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link login-history-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);
                
                for (let i = 1; i <= response.total_pages; i++) {
                    jQuery('#login-history-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link login-history-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                jQuery('#login-history-pagination-links').append(`
                    <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                        <a class="page-link login-history-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `);

                isLoadingLoginHistoryData = false

            } else {
                jQuery('#login-history-data-container').empty();
                jQuery('#login-history-data-container').append(
                `<tr>
                    <td colspan="6" class="text-center">
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>`);
                console.error('Failed to load users:', response.message);
                isLoadingLoginHistoryData = true
            }
        },
        error: function() {
            console.error('An error occurred while fetching the user list.');
        }
    });
}