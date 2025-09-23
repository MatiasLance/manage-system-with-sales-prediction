let newsDebounceTimer;
let newsCurrentSearch = '';

jQuery(function($){
    save($);
    list($, 1, '');
    archivedlist($, 1, '');

    $('#news-tab').on('click', function(){
        list($, 1, '');
    })

    $('#archived-news-tab').on('click', function(){
        archivedlist($, 1, '');
    })

    const imageInput = $('#newsImageInput');
    const imagePreview = $('#imagePreview');
    const imagePreviewContainer = $('#imagePreviewContainer');
    const editImageInput = $('#editNewsImageInput')
    const editImagePreview = $('#editImagePreview');
    const editImagePreviewContainer = $('#editImagePreviewContainer');

    imageInput.on('change', function () {
        const file = this.files[0];

        imagePreviewContainer.addClass('d-none');
        imagePreview.attr('src', '');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.attr('src', e.target.result);
                imagePreviewContainer.removeClass('d-none');
            };

            reader.readAsDataURL(file);
        }
    });

    editImageInput.on('change', function () {
        const file = this.files[0];

        editImagePreviewContainer.addClass('d-none');
        editImagePreview.attr('src', '');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                editImagePreview.attr('src', e.target.result);
                editImagePreviewContainer.removeClass('d-none');
            };

            reader.readAsDataURL(file);
        }
    });

    $('#search-news').on('keyup', function() {
        clearTimeout(newsDebounceTimer);
        let searchQuery = $(this).val();

        newsDebounceTimer = setTimeout(() => {
            newsDebounceTimer = searchQuery;
            list($, 1, searchQuery);
        }, 500);
    });

    $('#search-archived-news').on('keyup', function() {
        clearTimeout(newsDebounceTimer);
        let searchQuery = $(this).val();

        newsDebounceTimer = setTimeout(() => {
            newsDebounceTimer = searchQuery;
            archivedlist($, 1, searchQuery);
        }, 500);
    });

    $(document).on('click', '.news-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        list(page, newsDebounceTimer);
    });

    $(document).on('click', '.archived-news-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        archivedlist(page, newsDebounceTimer);
    });

    $(document).on('click', '#retrieveNews', function(){
        const newsId = $(this).data('news-id');
        retrieve($, newsId);
    })

    $(document).on('click', '#saveNewsChanges', function() {
        const newsId = $('#newsId').val();
        const title = $('#editNewsTitleInput').val();
        const content = $('#editNewsContentInput').val();
        const imageFile = $('#editNewsImageInput')[0].files[0];
        const fallBackImage = $('#editImagePreview').attr('src');

        if (!title || !content) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please fill in both title and content.',
                icon: 'warning',
            });
            return;
        }

        const formData = new FormData();
        formData.append('id', newsId);
        formData.append('title', title);
        formData.append('content', content);
        if (imageFile) {
            formData.append('image', imageFile);
        }else{
            formData.append('image', fallBackImage);
        }

        edit($, formData);
    });

    $(document).on('click', '#openDeleteNewsModal', function() {
        const newsId = $(this).data('news-id');
        $('#deleteNewsId').val(newsId);
        retrieve($, newsId);
    });

    $(document).on('click', '#retrieveArchivedNews', function() {
        const newsId = $(this).data('news-id');
        $('#restoreNewsId').val(newsId);
    });

    $(document).on('click', '#retrievePermanentDeleteNewsID', function() {
        const newsId = $(this).data('news-id');
        $('#permanentDeleteNewsId').val(newsId);
    });

    $('#restoreNewsFromArchived').on('click', function() {
        const payload = {
            id: $('#restoreNewsId').val(),
            password: $('#restoreNewsPasswordInput').val()
        };

        if (!payload.password) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please enter your password to confirm deletion.',
                icon: 'warning',
            });
            return;
        }

        restoreArchivedNews($, payload);
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

    $('#permanentDeleteArchivedNews').on('click', function() {
        const payload = {
            id: $('#permanentDeleteNewsId').val(),
            password: $('#permanentDeleteNewsPasswordInput').val()
        };

        if (!payload.password) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please enter your password to confirm deletion.',
                icon: 'warning',
            });
            return;
        }

        permanentDeleteNews($, payload);
    });

    $(document).on('click', '#viewImageInModal', function(){
        $('#viewImageModal').modal('show');
        const imagePath = $(this).data('image');
        const newsDate = $(this).data('date');
        const newsTitle = $(this).data('title');
        const newsContent = $(this).data('content');
        $('#imgSrc').attr('src', imagePath);
        $('#news-date-published').text(`
            ${new Date(newsDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
            })}
        `)
        $('#news-title').text(newsTitle);
        $('#news-content').text(newsContent);
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
                const websiteNewsContainer = $('#websiteNewsContainer');
                newsContainer.empty();
                websiteNewsContainer.empty();

                response.data.forEach(function(news) {
                    const newsItem = `
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                            ${news.image_path 
                                ? `<img src="${news.image_path}" 
                                        class="card-img-top" 
                                        alt="News Image" 
                                        loading="lazy"
                                        style="height: 200px; object-fit: cover; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">`
                                : ''}

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

                    websiteNewsContainer.append(`
                        <div class="news-item mb-4" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                            <div class="row g-0 align-items-start">
                                
                                ${news.image_path 
                                ? `<div class="col-md-4 col-12">
                                        <img src="${news.image_path}" 
                                        class="img-fluid rounded-start rounded-md-start object-fit-cover" 
                                        alt="News Image"
                                        loading="lazy"
                                        id="viewImageInModal"
                                        data-image="${news.image_path}"
                                        data-date="${news.created_at}"
                                        data-title="${news.title}"
                                        data-content="${news.content}"
                                        style="width: 100%; height: 180px; object-fit: cover; border-radius: 0.375rem; cursor: pointer;">
                                    </div>`
                                : ''}

                                <div class="${news.image_url ? 'col-md-8' : 'col-12'} ps-md-3 pt-2 pt-md-0">
                                <span class="text-black mb-1 d-block" style="font-size: 0.85rem;">
                                    <i class="bi bi-calendar-heart me-1"></i>
                                    ${new Date(news.created_at).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                    })}
                                </span>
                                <h3 class="h5 fw-bold text-dark mb-2">${news.title}</h3>
                                <p class="text-secondary mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                    ${news.content.length > 180 
                                    ? news.content.substring(0, 180) + '...' 
                                    : news.content}
                                </p>
                                </div>
                            </div>
                            </div>
                    `);
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
                        <a class="page-link news-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
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

function archivedlist($, page, searchQuery) {
    $.ajax({
        url: './controller/news/ArchivedNewsListController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        beforeSend: function() {
            $('#loading-spinner').removeClass('d-none');
        },
        success: function(response) {
            if(response.success === true) {
                const newsContainer = $('#archivedNewsList');
                newsContainer.empty();

                response.data.forEach(function(news) {
                    const newsItem = `
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-light">
                            ${news.image_path 
                                ? `<img src="${news.image_path}" 
                                        class="card-img-top" 
                                        alt="News Image" 
                                        loading="lazy"
                                        style="height: 200px; object-fit: cover; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">`
                                : ''}

                                <!-- Card Header with Icons -->
                                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom-0 pt-3 px-3 pb-0">
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-1" style="font-size: 0.75rem;">News</span>
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary"
                                                title="Restore News"
                                                id="retrieveArchivedNews"
                                                data-news-id="${news.id}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#askPasswordOnRestoreNewsModal"
                                                data-bs-auto-close="false"
                                                >
                                        <i class="bi bi-recycle"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete News"
                                                id="retrievePermanentDeleteNewsID"
                                                data-news-id="${news.id}"
                                                data-action="delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#askPasswordOnNewsPermanentDeletionModal"
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

                $('#archived-news-pagination-links').empty();

                // Previous Button
                $('#archived-news-pagination-links').append(`
                    <li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link archived-news-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `);

                // Page Numbers
                for (let i = 1; i <= response.total_pages; i++) {
                    $('#archived-news-pagination-links').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link archived-news-page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Button
                $('#archived-news-pagination-links').append(`
                    <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                        <a class="page-link archived-news-page-link" href="#" data-page="${page + 1}" aria-label="Next">
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
    $('#saveNews').on('click', function () {
        const title = $('#newsTitleInput').val().trim();
        const content = $('#newsContentInput').val().trim();
        const imageFile = $('#newsImageInput')[0].files[0];

        if (!title || !content) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please fill in both title and content.',
                icon: 'warning',
            });
            return;
        }

        const formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
        if (imageFile) {
            formData.append('image', imageFile);
        }


        $.ajax({
            url: './controller/news/AddNewsController.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                let res;
                if (typeof response === 'string') {
                    try {
                        res = JSON.parse(response);
                    } catch (e) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Invalid response from server.',
                            icon: 'error',
                        });
                        console.error('Parse error:', e);
                        return;
                    }
                } else {
                    res = response;
                }

                if (res.success === true) {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success',
                    });
                    $('#newsForm')[0].reset();
                    $('#imagePreviewContainer').addClass('d-none');
                    $('#imagePreview').attr('src', '');

                    setTimeout(function () {
                        $('#addNewsModal').modal('hide');
                        list($, 1, newsCurrentSearch);
                    }, 500);
                }

                if (res.error === true) {
                    Swal.fire({
                        title: 'Error!',
                        text: res.message,
                        icon: 'error',
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: 'Request Failed',
                    text: 'An error occurred while saving the news.',
                    icon: 'error',
                });
                console.error('AJAX Error:', error, xhr);
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
                $('#editImagePreviewContainer').removeClass('d-none');
                $('#editImagePreview').attr('src', response.image_path);
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
        contentType: false,
        processData: false,
        success: function(response) {
            if(response.success === true) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        $('#retrieveNewsModal').modal('hide');
                        list($, 1, newsCurrentSearch);
                    }
                });
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
                }).then((result) => {
                    if(result.isConfirmed){
                        $('#deleteNewsId').val(''),
                        $('#deleteNewsPasswordInput').val('')
                        $('#askPasswordOnNewsDeletionModal').modal('hide');
                        list($, 1, newsCurrentSearch);
                    }
                });
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

function restoreArchivedNews($, payload){
    $.ajax({
        url: './controller/news/RestoreNewsController.php',
        type: 'POST',
        data: payload,
        success: function(response) {
            if(response.success === true) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        $('#restoreNewsId').val(''),
                        $('#restoreNewsPasswordInput').val('')
                        $('#askPasswordOnRestoreNewsModal').modal('hide');
                        archivedlist($, 1, newsCurrentSearch);
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
                $('restoreNewsPasswordInput').val('')
            }
        },
        error: function(xhr, status, error) {
            console.error('Error restoring news: ' + error);
        }
    });
}

function permanentDeleteNews($, payload) {
    $.ajax({
        url: './controller/news/PermanentDeleteNewsController.php',
        type: 'POST',
        data: payload,
        success: function(response) {
            if(response.success === true) {
                Swal.fire({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                }).then((result) => {
                    if(result.isConfirmed){
                        $('#permanentDeleteNewsId').val(''),
                        $('#permanentDeleteNewsPasswordInput').val('')
                        $('#askPasswordOnNewsPermanentDeletionModal').modal('hide');
                        archivedlist($, 1, newsCurrentSearch);
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                });
                $('#permanentDeleteNewsPasswordInput').val('')
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting news: ' + error);
        }
    });
}