<div class="modal fade" id="retrieveBookingModal" tabindex="-1" aria-labelledby="retrieveBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveBookingModalLabel">Edit Booking detail</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <input type="hidden" id="editBookingId">
          <div class="mb-3">
            <label for="retrieveBookingFirstNameInput" class="form-label text-capitalize">First Name</label>
            <input type="text" class="form-control" id="retrieveBookingFirstNameInput" readonly="true">
          </div>

          <div class="mb-3">
            <label for="retrieveBookingMiddleNameInput" class="form-label text-capitalize">Middle Initial</label>
            <input type="text" class="form-control" id="retrieveBookingMiddleNameInput" readonly="true">
          </div>

          <div class="mb-3">
            <label for="retrieveBookingLastNameInput" class="form-label text-capitalize">Last Name</label>
            <input type="text" class="form-control" id="retrieveBookingLastNameInput" readonly="true">
          </div>

          <div class="mb-3">
            <label for="retrieveBookingEmailInput" class="form-label text-capitalize">Email</label>
            <input type="email" class="form-control" id="retrieveBookingEmailInput" readonly="true">
          </div>

          <div class="mb-3">
            <label for="retrieveBookingPhoneNumberInput" class="form-label text-capitalize">phone number</label>
            <input type="text" class="form-control" id="retrieveBookingPhoneNumberInput" readonly="true">
            <div class="invalid-feedback">
                Phone number must start with 09
            </div>
          </div>

          <div class="mb-3">
            <label for="retrieveBookingStatusSelect" class="form-label text-capitalize">status</label>
            <select class="form-select text-capitalize" id="retrieveBookingStatusSelect" name="status">
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="currentBookingScheduleDateInput" class="form-label text-capitalize">Current Booking Schedule</label>
            <input type="text" class="form-control" id="currentBookingScheduleDateInput" readonly="true">
          </div>

          <div class="mb-3">
            <label for="retrieveBookingScheduleDateInput" class="form-label text-capitalize">Move Booking Schedule</label>
            <input type="date" class="form-control" id="retrieveBookingScheduleDateInput" name="booking_schedule">
          </div>

      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal" id="editBookingDetail">Save</button>
       </div>
    </div>
  </div>
</div>