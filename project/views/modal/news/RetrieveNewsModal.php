<div class="modal fade" id="retrieveNewsModal" tabindex="-1" aria-labelledby="retrieveBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="retrieveNewsModalLabel">Edit News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data">
          <input type="hidden" id="newsId" name="id">
          <div class="mb-3">
            <label for="editNewsTitleInput" class="form-label text-capitalize">Title</label>
            <input type="text" class="form-control" id="editNewsTitleInput" name="title" required>
          </div>

          <div class="mb-3">
            <label for="editNewsContentInput" class="form-label text-capitalize">Content</label>
            <textarea class="form-control" id="editNewsContentInput" rows="3" name="content" required></textarea>
          </div>

          <div class="mb-3">
            <label for="editNewsImageInput" class="form-label text-capitalize">Upload Image</label>
            <input class="form-control" type="file" id="editNewsImageInput" name="image"
                   accept="image/*">
            <div class="form-text text-white">Choose a JPG, PNG, or WebP image (optional).</div>
          </div>

          <div class="mb-3 d-none" id="editImagePreviewContainer">
            <img id="editImagePreview" src="" class="img-fluid rounded" alt="Preview" style="max-height: 200px;">
          </div>

      </div>
      <div class="modal-footer">
            <button type="button"  id="saveNewsChanges" class="btn btn-golden-wheat btn-sm">Save</button>
       </div>
       </form>
    </div>
  </div>
</div>