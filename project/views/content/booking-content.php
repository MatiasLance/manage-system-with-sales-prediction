<?php include __DIR__ . '/../sidebar.php' ?>

<!-- Overlay -->
<div id="overlay" class="overlay"></div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container-fluid padding-custom">
        <!-- Sidebar toggle -->
        <i class="fas fa-bars me-3" id="menuToggle"></i>

        <!-- Right-side nav links -->
        <ul class="navbar-nav ms-auto">
            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#" role="button" id="logout" title="Logout here...">
                    <i class="fas fa-sign-out-alt me-2"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container booking-content">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-5 justify-content-center" id="myTab" role="tablist">
        <!-- Booking Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link active" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-tab-pane" type="button" role="tab" aria-controls="booking-tab-pane" aria-selected="true">
                Booking
            </button>
        </li>
        <!-- Room Tab -->
        <li class="nav-item" role="presentation">
            <button class="nav-link product-link" id="room-tab" data-bs-toggle="tab" data-bs-target="#room-tab-pane" type="button" role="tab" aria-controls="room-tab-pane" aria-selected="false">
                Room
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
      <div class="tab-content" id="myTabContent">
        <?php include __DIR__ . '/booking-tab/booking-tab.php'; ?>
        <?php include __DIR__ . '/booking-tab/room-tab.php'; ?>
    </div>

</div>

<!-- Footer -->
<?php include __DIR__ . '/../footer.php' ?>

<!-- Modal -->
<?php
include __DIR__ . '/../modal/booking/AddBookingModal.php';
include __DIR__ . '/../modal/room/AddRoomModal.php';
include __DIR__ . '/../modal/booking/ChangeBookingStatusModal.php';
include __DIR__ . '/../modal/booking/ChangeCheckInModal.php';
include __DIR__ . '/../modal/booking/ChangeCheckOutModal.php';
include __DIR__ . '/../modal/booking/RetrieveBookingModal.php';
include __DIR__ . '/../modal/room/RetrieveRoomModal.php';
include __DIR__ . '/../modal/booking/DeleteBookingModal.php';
include __DIR__ . '/../modal/room/DeleteRoomModal.php';
include __DIR__ . '/../modal/booking/AskPasswordOnBookingDeletionModal.php';
include __DIR__ . '/../modal/room/AskPasswordOnRoomDeletionModal.php';
?>

