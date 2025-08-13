<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addNewsModalLabel">Add News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="newsTitleInput" class="form-label text-capitalize">Title</label>
            <input type="text" class="form-control" id="newsTitleInput" name="title" required>
          </div>

          <div class="mb-3">
            <label for="newsContentInput" class="form-label text-capitalize">Content</label>
            <textarea class="form-control" id="newsContentInput" rows="3" name="content" required></textarea>
          </div>

      </div>
      <div class="modal-footer">
            <button type="button"  id="saveNews" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>