<div class="tab-pane fade" id="room-tab-pane" role="tabpanel" aria-labelledby="room-tab-pane" tabindex="0">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addRoomModal" data-bs-auto-close="false">Add Room</button>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-3">
        <div class="card-body p-5 text-center bg-light animate-card">
            <!-- Animated Icon -->
            <div class="d-flex justify-content-center mb-4">
            <span class="bi bi-info-circle text-primary animate-icon" style="font-size: 3rem; line-height: 1;"></span>
            </div>

            <h2 class="card-title mb-3 h3 fw-bold text-dark">Note</h2>

            <p class="lead text-muted mb-4 lh-lg" style="max-width: 720px; margin-left: auto; margin-right: auto;">
            To enforce uniqueness and prevent naming conflicts, the room name field is disabled for modification in edit mode. 
            If a different name is required, administrators must create a new room entry instead.
            </p>
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <input type="text" id="searchAvailableRoom" class="form-control mb-3 w-50" placeholder="Search by room #...">
        <nav>
            <ul class="pagination justify-content-center" id="room-pagination-links"></ul>
        </nav>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
                <th scope="col">Room #</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">
                    Setting
                </th>
            </tr>
        </thead>
        <tbody id="room-container"></tbody>
    </table>
    </div>
</div>