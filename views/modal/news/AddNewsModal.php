<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addNewsModalLabel">Add News</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="newsForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="newsTitleInput" class="form-label text-capitalize">Title</label>
            <input type="text" class="form-control" id="newsTitleInput" name="title" required>
          </div>

          <div class="mb-3">
            <label for="newsContentInput" class="form-label text-capitalize">Content</label>
            <textarea class="form-control" id="newsContentInput" rows="3" name="content" required></textarea>
          </div>

          <div class="mb-3">
            <label for="newsImageInput" class="form-label text-capitalize">Upload Image</label>
            <input class="form-control" type="file" id="newsImageInput" name="image"
                   accept="image/*">
            <div class="form-text text-white">Choose a JPG, PNG, or WebP image (optional).</div>
          </div>

          <div class="mb-3 d-none" id="imagePreviewContainer">
            <img id="imagePreview" src="" class="img-fluid rounded" alt="Preview" style="max-height: 200px;">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="saveNews" class="btn btn-golden-wheat btn-sm">Save</button>
      </div>
    </div>
  </div>
</div>