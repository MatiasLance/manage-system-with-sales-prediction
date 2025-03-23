let bookingDebounceTimer; // Timer for debouncing
let currentSearchBooking = ''; // Store last search value

jQuery(function($){
    $('#saveBookingInformation').on('submit', function(e){
        e.preventDefault();

        const data = $(this).serializeArray();

        $.ajax({
            type: "POST",
            url: "./controller/booking/AddBookingController.php",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire("Success", response.message, "success").then((result) => {
                        if(result.isConfirmed){
                            $('#saveBookingInformation')[0].reset();
                            listOfBooking(1, '');
                        }
                    });
                }
                if(response.error){
                    Swal.fire("Warning!", response.message, "warning")
                    .then((result) => {
                        if(result.isConfirmed){
                            listOfBooking(1, '');
                        }
                    });
                    for(let i = 0; i < response.messages.length; i++){
                        Swal.fire("Warning!", response.messages[i], "warning")
                        .then((result) => {
                            if(result.isConfirmed){
                                listOfBooking(1, '');
                            }
                        });
                    }
                }

            },
            error: function(error) {
                console.error("AJAX Error:", error);
            }
        });
    })

   // Validate phone number
    $(document).on('keyup', '#bookingPhoneNumberInput', function(){
        let phoneNumber = $(this).val().trim();
        let phonePattern = /^09\d{9}$/;
    
        if (phonePattern.test(phoneNumber)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
        }
    });

    $(document).on('click', '#retrieveBooking', function() {
        const id = $(this).data('id');
        retrieveBooking(id);
    })

    $(document).on('click', '#editBookingDetail', function(){
        let editedBookingSchedule = $('#retrieveBookingScheduleDateInput').val()
        const payload = {
            id: $('#editBookingId').val(),
            first_name: $('#retrieveBookingFirstNameInput').val(),
            middle_name: $('#retrieveBookingMiddleNameInput').val(),
            last_name: $('#retrieveBookingLastNameInput').val(),
            email: $('#retrieveBookingEmailInput').val(),
            phone_number: $('#retrieveBookingPhoneNumberInput').val(),
            status: $('#retrieveBookingStatusSelect').val(),
            booking_schedule: editedBookingSchedule !== '' ? editedBookingSchedule : $('#currentBookingScheduleDateInput').val()
        }
        updateBookingDetail(payload);
    })

    $(document).on('click', '#confirmBookingDeletion', function() {
        const id = $(this).data('id');
        retrieveBooking(id);
    })

    $(document).on('click', '#deleteBooking', function(){
        const payload = {
            id: $('#deleteBookingId').val(),
            password: $('#bookingPasswordInput').val()
        }
        deleteBookingDetail(payload);
    })

    // Pagination click event for employee
    $(document).on('click', '.booking-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        listOfBooking(page, currentSearchBooking);
    });

    // Debounced search input event for employee
    $('#searchBooking').on('keyup', function() {
        clearTimeout(bookingDebounceTimer); // Clear previous timer
        let searchQuery = $(this).val();

        bookingDebounceTimer = setTimeout(() => {
            currentSearchBooking = searchQuery; // Update current search
            listOfBooking(1, searchQuery); // Fetch data after 5 seconds
        }, 500); // 5-second debounce
    });

    // Initially fetch employees
    listOfBooking(1, '');
})

function listOfBooking(page, searchQuery){
    $.ajax({
        url: './controller/booking/ListBookingController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            // Populate table with fetched data
            $('#booking-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let bookingScheduleDate = new Date(response.data[i].booking_schedule);
                let bookingId = response.data[i].id;
                
                $('#booking-container').append(`<tr>
                    <td>${response.data[i].first_name}</td>
                    <td>${response.data[i].middle_name || 'N/A'}</td>
                    <td>${response.data[i].last_name}</td>
                    <td class="text-capitalize">${response.data[i].email}</td>
                    <td class="text-capitalize">${response.data[i].phone_number}</td>
                    <td class="text-capitalize">
                        ${response.data[i].status === 'confirmed' 
                            ? `<span class="badge text-bg-success">${response.data[i].status}</span>` 
                            : response.data[i].status === 'cancelled' 
                                ? `<span class="badge text-bg-danger">${response.data[i].status}</span>` 
                                : `<span class="badge text-bg-warning">${response.data[i].status}</span>`}
                    </td>
                    <td>${bookingScheduleDate.toDateString()}</td>
                    <td class="flex flex-row justify-content-between">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" id="retrieveBooking" data-id="${bookingId}" data-bs-toggle="modal" data-bs-target="#retrieveBookingModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" id="confirmBookingDeletion" data-id="${bookingId}" data-bs-toggle="modal" data-bs-target="#bookingConfirmationDeleteModal" data-bs-auto-close="false" style="cursor: pointer;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M170.5 51.6L151.5 80l145 0-19-28.4c-1.5-2.2-4-3.6-6.7-3.6l-93.7 0c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80 368 80l48 0 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-8 0 0 304c0 44.2-35.8 80-80 80l-224 0c-44.2 0-80-35.8-80-80l0-304-8 0c-13.3 0-24-10.7-24-24S10.7 80 24 80l8 0 48 0 13.8 0 36.7-55.1C140.9 9.4 158.4 0 177.1 0l93.7 0c18.7 0 36.2 9.4 46.6 24.9zM80 128l0 304c0 17.7 14.3 32 32 32l224 0c17.7 0 32-14.3 32-32l0-304L80 128zm80 64l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0l0 208c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-208c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                    </td>
                </tr>`);
            }

            $('#totalBookings').text(response.total_bookings);

            // Generate pagination links
            $('#booking-pagination-links').empty();

            // Previous Button
            $('#booking-pagination-links').append(`
                <li class="page-item ${page === 1 ? 'disabled' : ''}">
                    <a class="page-link booking-page-link" href="#" data-page="${page - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
            
            // Page Numbers
            for (let i = 1; i <= response.total_pages; i++) {
                $('#booking-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link booking-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            $('#booking-pagination-links').append(`
                <li class="page-item ${page === response.total_pages ? 'disabled' : ''}">
                    <a class="page-link booking-page-link" href="#" data-page="${page + 1}" aria-label="Next">
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

function retrieveBooking(id){
    jQuery.ajax({
        type: 'GET',
        url: './controller/booking/RetrieveBookingController.php',
        data: { id: id },
        dataType: 'json',
        success: function(response){
            if(response){
                let formattedDate = response.booking_schedule.replace(/\s00:00:00$/, ""); // Remove time part
                jQuery('#editBookingId').val(id);
                jQuery('#deleteBookingId').val(id);
                jQuery('#retrieveBookingFirstNameInput').val(response.first_name);
                jQuery('#retrieveBookingMiddleNameInput').val(response.middle_name);
                jQuery('#retrieveBookingLastNameInput').val(response.last_name);
                jQuery('#retrieveBookingEmailInput').val(response.email);
                jQuery('#retrieveBookingPhoneNumberInput').val(response.phone_number);
                jQuery('#retrieveBookingStatusSelect').prepend(`<option value="" disabled selected data-temp="true">${response.status}</option>`);
                jQuery('#currentBookingScheduleDateInput').val(formattedDate);

                jQuery('#bookingName').text(`${response.first_name} ${response.last_name}`)

                // Remove the previously prepended selected option
                jQuery('#retrieveBookingStatusSelect').find('option[data-temp="true"]').remove();
        
                // Prepend the new selected status option
                jQuery('#retrieveBookingStatusSelect').prepend(`<option value="${response.status}" disabled selected data-temp="true">${response.status}</option>`);

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

function updateBookingDetail(payload){
    jQuery.ajax({
        type: "POST",
        url: "./controller/booking/UpdateBookingController.php",
        data: payload,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                Swal.fire("Success", response.message, "success")
                .then((result) => {
                    if(result.isConfirmed){
                        listOfBooking(1, '');
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

function deleteBookingDetail(payload){
    $.ajax({
        type: 'POST',
        url: './controller/booking/DeleteBookingController.php',
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
                        listOfBooking(1, '');
                        $('#bookingPasswordInput').val('');
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
                $('#bookingPasswordInput').val('');
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