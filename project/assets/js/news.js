let debounceTimer;
let currentSearch = '';

jQuery(function($){
    save($);
    list($, 1, '');

    $('#search-news').on('keyup', function() {
        clearTimeout(debounceTimer);
        let searchQuery = $(this).val();

        debounceTimer = setTimeout(() => {
            currentSearch = searchQuery;
            list($, 1, searchQuery);
        }, 500);
    });

    $(document).on('click', '#retrieveNews', function(){
        const newsId = $(this).data('news-id');
        retrieve($, newsId);
    })

    $(document).on('click', '#saveNewsChanges', function() {
        const newsId = $('#newsId').val();
        const title = $('#editNewsTitleInput').val();
        const content = $('#editNewsContentInput').val();

        if (!title || !content) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please fill in both title and content.',
                icon: 'warning',
            });
            return;
        }

        const payload = {
            id: newsId,
            title: title,
            content: content
        };

        edit($, payload);
    });

    $(document).on('click', '#openDeleteNewsModal', function() {
        const newsId = $(this).data('news-id');
        $('#deleteNewsId').val(newsId);
        retrieve($, newsId);
    });

    $('#deleteNews').on('click', function() {
        const payload = {
            id: $('#deleteNewsId').val(),
            password: $('#deleteNewsPasswordInput').val()
        };

        if (!payload.password) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please enter your password to confirm deletion.',
                icon: 'warning',
            });
            return;
        }

        deleteNews($, payload);
    });
})

function list($, page, searchQuery) {
    $.ajax({
        url: './controller/news/ListNewsController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        beforeSend: function() {
            $('#loading-spinner').removeClass('d-none');
        },
        success: function(response) {
            if(response.success === true) {
                const newsContainer = $('#newsList');
                newsContainer.empty();

                response.data.forEach(function(news) {
                    const newsItem = `
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                                <!-- Card Header with Icons -->
                                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0 pt-3 px-3 pb-0">
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1" style="font-size: 0.75rem;">News</span>
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Edit News"
                                                id="retrieveNews"
                                                data-news-id="${news.id}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#retrieveNewsModal"
                                                data-bs-auto-close="false"
                                                >
                                        <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete News"
                                                id="openDeleteNewsModal"
                                                data-news-id="${news.id}"
                                                data-action="delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#newsConfirmationDeleteModal"
                                                data-bs-auto-close="false"
                                                >
                                        <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body pt-2">
                                    <h5 class="card-title fw-bold text-dark mb-2">${news.title}</h5>
                                    <p class="card-text text-secondary mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                        ${news.content.length > 120 
                                        ? news.content.substring(0, 120) + '...' 
                                        : news.content}
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                        Posted on ${new Date(news.created_at).toLocaleDateString('en-US', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    newsContainer.append(newsItem);
                });

                if (response.data.length === 0) {
                    $('#no-news-message').removeClass('d-none');
                } else {
                    $('#no-news-message').addClass('d-none');
                }

                $('#news-pagination-links').empty();

                // Previous Button
                $('#news-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link products-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);

                // Page Numbers
                for (let i = 1; i <= response.total_pages; i++) {
                    $('#news-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link news-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Button
                $('#news-pagination-links').append(`
                    <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                        <a class="page-link news-page-link" href="#" data-page="${page + 1}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `);

            }
        },
        complete: function() {
            $('#loading-spinner').addClass('d-none');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching news list: ' + error);
        }
    });
}

function save($) {
        $('#saveNews').on('click', function() {

        const title = $('#newsTitleInput').val();
        const content = $('#newsContentInput').val();

        if (!title || !content) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please fill in both title and content.',
                icon: 'warning',
            });
            return;
        }

        const payload = {
            title: title,
            content: content
        };

        $.ajax({
            url: './controller/news/AddNewsController.php',
            type: 'POST',
            data: payload,
            success: function(response) {
                if(response.success === true) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                    });
                    $('#newsTitleInput').val('');
                    $('#newsContentInput').val('');
                    setTimeout(function() {
                        $('#addNewsModal').modal('hide');
                        list($, 1, currentSearch);
                    }, 500);
                }

                if (response.error === true) {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    });
                    return;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error saving news: ' + error);
            }
        });
    });
}

function retrieve($, newsId) {
    $.ajax({
        url: './controller/news/RetrieveNewsController.php',
        type: 'GET',
        data: { id: newsId },
        success: function(response) {
            if(response.success === true) {
                $('#newsId').val(response.id);
                $('#editNewsTitleInput').val(response.title);
                $('#editNewsContentInput').val(response.content);
                $('#newsTitle').text(response.title);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error retrieving news: ' + error);
        }
    });
}

function edit($, payload) {
    $.ajax({
        url: './controller/news/EditNewsController.php',
        type: 'POST',
        data: payload,
        success: function(response) {
            if(response.success === true) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                });
                setTimeout(function() {
                    $('#retrieveNewsModal').modal('hide');
                    list($, 1, currentSearch);
                }, 500);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating news: ' + error);
        }
    });
}

function deleteNews($, payload) {
    $.ajax({
        url: './controller/news/DeleteNewsController.php',
        type: 'POST',
        data: payload,
        success: function(response) {
            if(response.success === true) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                });
                setTimeout(function() {
                    $('#deleteNewsId').val(''),
                    $('#deleteNewsPasswordInput').val('')
                    $('#askPasswordOnNewsDeletionModal').modal('hide');
                    list($, 1, currentSearch);
                }, 500);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
                $('#deleteNewsPasswordInput').val('')
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting news: ' + error);
        }
    });
}