<div class="modal fade" id="addBookingModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addBookingModalLabel">Add Booking</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="saveBookingInformation">
          <div class="mb-3">
            <label for="bookingFirstNameInput" class="form-label text-capitalize">First Name</label>
            <input type="text" class="form-control" id="bookingFirstNameInput" name="first_name" required>
          </div>

          <div class="mb-3">
            <label for="bookingMiddleNameInput" class="form-label text-capitalize">Middle Initial</label>
            <input type="text" class="form-control" id="bookingMiddleNameInput" name="middle_initial" placeholder="Optional">
          </div>

          <div class="mb-3">
            <label for="bookingLastNameInput" class="form-label text-capitalize">Last Name</label>
            <input type="text" class="form-control" id="bookingLastNameInput" name="last_name" required>
          </div>

          <div class="mb-3">
            <label for="bookingEmailInput" class="form-label text-capitalize">Email</label>
            <input type="email" class="form-control" id="bookingEmailInput" name="email" required>
          </div>

          <div class="mb-3">
            <label for="bookingPhoneNumberInput" class="form-label text-capitalize">phone number</label>
            <input type="text" class="form-control" id="bookingPhoneNumberInput" name="phone_number" required>
            <div class="invalid-feedback">
                Phone number must start with 09, followed by 9 digits.
            </div>
          </div>

          <div class="mb-3">
            <label for="bookingScheduleDateInput" class="form-label text-capitalize">Guest Count</label>
            <input type="number" class="form-control" id="bookingGuestCountInput" name="guest_count" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Select Room</label>
            <select class="form-select" aria-label="Default select example" id="bookingSelectRoomID" name="selected_room_id">
            </select>
          </div>

          <div class="mb-3">
            <label for="bookingScheduleDateInput" class="form-label text-capitalize">Booking Schedule</label>
            <input type="date" class="form-control" id="bookingScheduleDateInput" name="booking_schedule" required>
          </div>

          <div class="mb-3">
            <label for="bookingCheckInInput" class="form-label text-capitalize">Check In</label>
            <input type="time" class="form-control" id="bookingCheckInInput" name="check_in">
          </div>

          <div class="mb-3">
            <label for="bookingCheckOutInput" class="form-label text-capitalize">Check Out</label>
            <input type="time" class="form-control" id="bookingCheckOutInput" name="check_out">
          </div>

      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>