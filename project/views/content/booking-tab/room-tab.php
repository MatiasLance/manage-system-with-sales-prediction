<div class="tab-pane fade" id="room-tab-pane" role="tabpanel" aria-labelledby="room-tab-pane" tabindex="0">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addRoomModal" data-bs-auto-close="false">Add Room</button>

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