let bookingDebounceTimer;
let currentSearchBooking = '';

jQuery(function($){
    $('.animate-card').each(function() {
        const card = $(this);
        setTimeout(function() {
        card.addClass('visible');
        }, 100);
    });

    $(document).on('click', '#updateBookingStatus', function(){
        const id = $(this).data('id');
        $('#retrieveUpdatedBookingStatusID').val(id);
    })

    $(document).on('click', '#updateCheckIn', function(){
        const id = $(this).data('id');
        $('#retrieveUpdatedCheckInId').val(id);
    })

    $(document).on('click', '#updateCheckOut', function(){
        const id = $(this).data('id');
        $('#retrieveUpdatedCheckOutId').val(id);
    })

    $('#saveChangeBookingStatus').on('submit', function(e){
        e.preventDefault();
        const payload = {
            id: $('#retrieveUpdatedBookingStatusID').val(),
            booking_status: $('#retrieveUpdatedBookingStatus').val()
        }
        handleBookingStateUpdate(payload);
    });

    $('#saveChangeCheckIn').on('submit', function(e){
        e.preventDefault();
        const payload = {
            id: $('#retrieveUpdatedCheckInId').val(),
            check_in: $('#retrieveUpdatedBookingCheckIn').val()
        }
        handleBookingCheckInUpdate(payload);
    });

    $('#saveChangeCheckOut').on('submit', function(e){
        e.preventDefault();
        const payload = {
            id: $('#retrieveUpdatedCheckOutId').val(),
            check_out: $('#retrieveUpdatedBookingCheckOut').val()
        }
        handleBookingCheckOutUpdate(payload);
    });

    $('#saveBookingInformation, #bookNow').on('submit', function(e){
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
                            $('#saveBookingInformation, #bookNow')[0].reset();
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

    $('#filterSalesByDate, #retrieveBookingScheduleDateInput, #bookingScheduleDateRangeInput').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    },
    function(start, end, label) {
        $('#filterSalesByDate, #retrieveBookingScheduleDateInput, #bookingScheduleDateRangeInput').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
    });

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
        const payload = {
            id: $('#editBookingId').val(),
            selected_room_id: $('#retrieveBookingSelectRoomID').val(),
            first_name: $('#retrieveBookingFirstNameInput').val(),
            middle_name: $('#retrieveBookingMiddleNameInput').val(),
            last_name: $('#retrieveBookingLastNameInput').val(),
            email: $('#retrieveBookingEmailInput').val(),
            phone_number: $('#retrieveBookingPhoneNumberInput').val(),
            guest_count: $('#retrieveBookingGuestCountInput').val(),
            status: $('#retrieveBookingStatusSelect').val(),
            booking_schedule: $('#retrieveBookingScheduleDateInput').val(),
            start_date: $('#retrieveStartDateInput').val(),
            end_date: $('#retrieveEndDateInput').val(),
            check_in: $('#retrieveBookingCheckInInput').val(),
            check_out: $('#retrieveBookingCheckOutInput').val()
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

    $(document).on('click', '.booking-page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        listOfBooking(page, currentSearchBooking);
    });

    $('#searchBooking').on('keyup', function() {
        clearTimeout(bookingDebounceTimer);
        let searchQuery = $(this).val();

        bookingDebounceTimer = setTimeout(() => {
            currentSearchBooking = searchQuery;
            listOfBooking(1, searchQuery); 
        }, 500);
    });

    listOfBooking(1, '');
})

function listOfBooking(page, searchQuery){
    $.ajax({
        url: './controller/booking/ListBookingController.php',
        type: 'GET',
        data: { page: page, search: searchQuery },
        dataType: 'json',
        success: function(response) {
            $('#booking-container').empty();
            for (let i = 0; i < response.data.length; i++){
                let startDate = new Date(response.data[i].start_date);
                let endDate = new Date(response.data[i].end_date);
                let bookingId = response.data[i].id;
                
                $('#booking-container').append(`<tr>
                    <td>${response.data[i].first_name}</td>
                    <td>${response.data[i].middle_name || 'N/A'}</td>
                    <td>${response.data[i].last_name}</td>
                    <td>${response.data[i].email}</td>
                    <td class="text-capitalize">${response.data[i].phone_number}</td>
                    <td>
                        ${response.data[i].booking_status === 'confirmed' || response.data[i].booking_status === 'done'
                            ? `<button type="button" class="btn text-bg-success btn-sm text-capitalize" id="updateBookingStatus" data-bs-toggle="modal" data-bs-target="#changeBookingStatusModal" data-bs-auto-close="false" data-id="${bookingId}" style="cursor: pointer">${response.data[i].booking_status}</button>` 
                            : response.data[i].booking_status === 'cancelled' 
                                ? `<button type="button" class="btn text-bg-danger btn-sm text-capitalize" id="updateBookingStatus" data-bs-toggle="modal" data-bs-target="#changeBookingStatusModal" data-bs-auto-close="false" data-id="${bookingId}" style="cursor: pointer">${response.data[i].booking_status}</button>` 
                                : `<button type="button" class="btn text-bg-warning btn-sm text-capitalize" id="updateBookingStatus" data-bs-toggle="modal" data-bs-target="#changeBookingStatusModal" data-bs-auto-close="false" data-id="${bookingId}" style="cursor: pointer">${response.data[i].booking_status}</button>`}
                    </td>
                    <td>${response.data[i].guest_count}</td>
                    <td>${response.data[i].room_number}</td>
                    <td>${startDate.toDateString()}</td>
                    <td>${endDate.toDateString()}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" id="updateCheckIn" data-bs-toggle="modal" data-bs-target="#updateCheckInModal" data-bs-auto-close="false" data-id="${bookingId}">
                            ${response.data[i].check_in}
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" id="updateCheckOut" data-bs-target="#updateCheckOutModal" data-bs-auto-close="false" data-id="${bookingId}">
                            ${response.data[i].check_out}
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm" id="retrieveBooking" data-id="${bookingId}" data-bs-toggle="modal" data-bs-target="#retrieveBookingModal" data-bs-auto-close="false">
                            <i class="bi bi-pencil-square fs-4 text-success"></i>
                        </button>
                        <button type="button" class="btn btn-sm" id="confirmBookingDeletion" data-id="${bookingId}" data-bs-toggle="modal" data-bs-target="#bookingConfirmationDeleteModal" data-bs-auto-close="false">
                            <i class="bi bi-trash fs-4 text-danger"></i>
                        </button>
                    </td>
                </tr>`);
            }

            $('#totalBookings').text(response.pagination.total_items);

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
            for (let i = 1; i <= response.pagination.total_pages; i++) {
                $('#booking-pagination-links').append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link booking-page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }

            // Next Button
            $('#booking-pagination-links').append(`
                <li class="page-item ${page === response.pagination.total_pages ? 'disabled' : ''}">
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
            if(response.success){
                jQuery('#editBookingId').val(response.data.booking.id);
                jQuery('#deleteBookingId').val(response.data.booking.id);
                jQuery('#retrieveBookingFirstNameInput').val(response.data.booking.first_name);
                jQuery('#retrieveBookingMiddleNameInput').val(response.data.booking.middle_name);
                jQuery('#retrieveBookingLastNameInput').val(response.data.booking.last_name);
                jQuery('#retrieveBookingEmailInput').val(response.data.booking.email);
                jQuery('#retrieveBookingPhoneNumberInput').val(response.data.booking.phone_number);
                jQuery('#retrieveStartDateInput').val(response.data.booking.start_date);
                jQuery('#retrieveEndDateInput').val(response.data.booking.end_date);
                jQuery('#retrieveBookingCheckInInput').val(response.data.booking.check_in);
                jQuery('#retrieveBookingCheckOutInput').val(response.data.booking.check_out);
                jQuery('#bookingName').text(`${response.data.booking.full_name}`)
                jQuery('#retrieveBookingGuestCountInput').val(response.data.booking.guest_count)

                const existingBookingStatusOption = jQuery(`#retrieveBookingStatusSelect option[value="${response.data.booking.status}"]`)
                if (existingBookingStatusOption.length > 0) {
                    existingBookingStatusOption.prop('selected', true);
                } else {
                    jQuery('#retrieveBookingStatusSelect').prepend(`<option value="${response.data.booking.status}" selected>${response.data.booking.status}</option>`);
                }

                const existingBookingSelectedRoomID = jQuery(`#retrieveBookingSelectRoomID option[value="${response.data.room.id}"]`)
                if (existingBookingSelectedRoomID.length > 0) {
                    existingBookingSelectedRoomID.prop('selected', true);
                } else {
                    jQuery('#retrieveBookingSelectRoomID').prepend(`<option value="${response.data.room.id}" selected>${response.data.room.room_number}</option>`);
                }
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
            }

            if (response.errors) {
                for(let i = 0; i < response.messages.length; i++){
                    Swal.fire("Warning", response.messages[i], "warning");
                }
            }

            if(response.error){
                Swal.fire("Warning", response.message, "warning");
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

function handleBookingStateUpdate(payload){
    jQuery.ajax({
        type: "POST",
        url: "./controller/booking/UpdateBookingStatusController.php",
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
            }

            if (response.errors) {
                for(let i = 0; i < response.messages.length; i++){
                    Swal.fire("Warning", response.messages[i], "warning");
                }
            }

            if(response.error){
                Swal.fire("Warning", response.message, "warning");
            }

        },
        error: function (error) {
            console.error("AJAX Error:", error);
        }
    });
}
function handleBookingCheckInUpdate(payload){
    jQuery.ajax({
        type: "POST",
        url: "./controller/booking/UpdateBookingCheckInController.php",
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
            }

            if (response.errors) {
                for(let i = 0; i < response.messages.length; i++){
                    Swal.fire("Warning", response.messages[i], "warning");
                }
            }

            if(response.error){
                Swal.fire("Warning", response.message, "warning");
            }

        },
        error: function (error) {
            console.error("AJAX Error:", error);
        }
    });
}
function handleBookingCheckOutUpdate(payload){
    jQuery.ajax({
        type: "POST",
        url: "./controller/booking/UpdateBookingCheckOutController.php",
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
            }

            if (response.errors) {
                for(let i = 0; i < response.messages.length; i++){
                    Swal.fire("Warning", response.messages[i], "warning");
                }
            }

            if(response.error){
                Swal.fire("Warning", response.message, "warning");
            }

        },
        error: function (error) {
            console.error("AJAX Error:", error);
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