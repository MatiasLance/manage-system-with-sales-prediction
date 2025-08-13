<div class="modal fade" id="retrieveNewsModal" tabindex="-1" aria-labelledby="retrieveBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveNewsModalLabel">Edit News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="newsId" name="id">
          <div class="mb-3">
            <label for="editNewsTitleInput" class="form-label text-capitalize">Title</label>
            <input type="text" class="form-control" id="editNewsTitleInput" name="title" required>
          </div>

          <div class="mb-3">
            <label for="editNewsContentInput" class="form-label text-capitalize">Content</label>
            <textarea class="form-control" id="editNewsContentInput" rows="3" name="content" required></textarea>
          </div>

      </div>
      <div class="modal-footer">
            <button type="button"  id="saveNewsChanges" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>