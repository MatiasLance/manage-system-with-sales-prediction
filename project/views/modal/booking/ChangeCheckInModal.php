<div class="modal fade" id="updateCheckInModal" tabindex="-1" aria-labelledby="updateCheckInModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateCheckInModalLabel">Update Check In</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="saveChangeCheckIn">
            <input type="hidden" id="retrieveUpdatedCheckInId">
            <label for="retrieveUpdatedBookingCheckIn" class="form-label text-capitalize">Check In</label>
            <input type="time" class="form-control" id="retrieveUpdatedBookingCheckIn" name="check_in">
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-golden-wheat btn-sm" data-bs-dismiss="modal">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>