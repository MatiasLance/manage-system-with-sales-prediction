<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addRoomModalLabel">Add Room</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="saveAddedRoomNumber">
          <div class="mb-3">
            <label for="roomInput" class="form-label text-capitalize">Room</label>
            <input type="text" class="form-control" id="roomInput" name="room" required>
          </div>

          <div class="mb-3">
            <label for="selectStatusInput" class="form-label text-capitalize">Status</label>
            <select class="form-select" aria-label="Default select example" id="status" name="status">
              <option value="">Select status</option>
              <option value="available">Available</option>
              <option value="occupied">Occupied</option>
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