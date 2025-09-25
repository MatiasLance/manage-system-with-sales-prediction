<div class="modal fade" id="changeBookingStatusModal" tabindex="-1" aria-labelledby="changeBookingStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="changeBookingStatusModalLabel">Change Booking Status</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="saveChangeBookingStatus">
          <input type="hidden" id="retrieveUpdatedBookingStatusID">
          <div class="mb-3">
            <label for="retrieveUpdatedBookingStatus" class="form-label text-capitalize">status</label>
            <select class="form-select text-capitalize" id="retrieveUpdatedBookingStatus" name="status">
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
                <option value="done">Done</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>