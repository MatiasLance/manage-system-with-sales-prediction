<div class="modal fade" id="askPasswordOnBookingDeletionModal" tabindex="-1" aria-labelledby="askPasswordOnBookingDeletionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="askPasswordOnBookingDeletionModalLabel">Enter Password to Confirm Deletion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" id="deleteBookingId">
          <div class="mb-3">
            <label for="bookingPasswordInput" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" id="bookingPasswordInput" required>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" id="deleteBooking" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Submit</button>
       </div>
    </div>
  </div>
</div>