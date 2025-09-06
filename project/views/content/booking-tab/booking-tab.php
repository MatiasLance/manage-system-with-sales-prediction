<div class="tab-pane fade show active" id="booking-tab-pane" role="tabpanel" aria-labelledby="booking-tab-pane" tabindex="0">
        <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addBookingModal" data-bs-auto-close="false">Add Booking</button>

        <!-- Search Input -->
        <input type="text" id="searchBooking" class="form-control mb-3" placeholder="Search by name...">

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
                    <th scope="col" class="text-center">
                        Setting
                    </th>
                </tr>
            </thead>
            <tbody id="booking-container"></tbody>
        </table>
        </div>

        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination justify-content-center" id="booking-pagination-links"></ul>
        </nav>
</div>