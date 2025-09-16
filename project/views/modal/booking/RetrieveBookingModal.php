<div class="modal fade" id="retrieveBookingModal" tabindex="-1" aria-labelledby="retrieveBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveBookingModalLabel">Edit Booking detail</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" id="editBookingId">
          <div class="container-fluid px-0">
            <div class="row">

              <div class="col-6 mb-3">
                <label for="retrieveBookingFirstNameInput" class="form-label text-capitalize">First Name</label>
                <input type="text" class="form-control" id="retrieveBookingFirstNameInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingMiddleNameInput" class="form-label text-capitalize">Middle Initial</label>
                <input type="text" class="form-control" id="retrieveBookingMiddleNameInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingLastNameInput" class="form-label text-capitalize">Last Name</label>
                <input type="text" class="form-control" id="retrieveBookingLastNameInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingEmailInput" class="form-label text-capitalize">Email</label>
                <input type="email" class="form-control" id="retrieveBookingEmailInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingPhoneNumberInput" class="form-label text-capitalize">phone number</label>
                <input type="text" class="form-control" id="retrieveBookingPhoneNumberInput">
                <div class="invalid-feedback">
                    Phone number must start with 09
                </div>
              </div>

              <div class="col-6 mb-3">
                <label for="bookingScheduleDateInput" class="form-label text-capitalize">Guest Count</label>
                <input type="number" class="form-control" id="retrieveBookingGuestCountInput" name="guest_count">
              </div>

              <div class="col-6 mb-3">
                <label class="form-label">Select Room</label>
                <select class="form-select" aria-label="Default select example" id="retrieveBookingSelectRoomID" name="selected_room_id">
                </select>
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingStatusSelect" class="form-label text-capitalize">status</label>
                <select class="form-select text-capitalize" id="retrieveBookingStatusSelect" name="status">
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="done">Done</option>
                </select>
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveStartDateInput" class="form-label text-capitalize">Start Date</label>
                <input type="text" class="form-control" id="retrieveStartDateInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveEndDateInput" class="form-label text-capitalize">End Date</label>
                <input type="text" class="form-control" id="retrieveEndDateInput" readonly="true">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingScheduleDateInput" class="form-label text-capitalize">Reschedule Booking</label>
                <input type="text" class="form-control" id="retrieveBookingScheduleDateInput" name="booking_schedule">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingCheckInInput" class="form-label text-capitalize">Check In</label>
                <input type="time" class="form-control" id="retrieveBookingCheckInInput" name="check_in">
              </div>

              <div class="col-6 mb-3">
                <label for="retrieveBookingCheckOutInput" class="form-label text-capitalize">Check Out</label>
                <input type="time" class="form-control" id="retrieveBookingCheckOutInput" name="check_out">
              </div>

            </div>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal" id="editBookingDetail">Save</button>
       </div>
    </div>
  </div>
</div>