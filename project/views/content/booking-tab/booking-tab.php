<div class="tab-pane fade show active" id="booking-tab-pane" role="tabpanel" aria-labelledby="booking-tab-pane" tabindex="0">
        <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addBookingModal" data-bs-auto-close="false">Add Booking</button>

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
            <input type="text" id="searchBooking" class="form-control mb-3 w-50" placeholder="Search by name...">
            <nav>
                <ul class="pagination justify-content-center" id="booking-pagination-links"></ul>
            </nav>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-milk-white">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Middle Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone #</th>
                    <th scope="col">Status</th>
                    <th scope="col">Guest Count</th>
                    <th scope="col">Selected Room</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th class="col-1" scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="booking-container"></tbody>
        </table>
        </div>
</div>