<?php include __DIR__ . '/../sidebar.php' ?>

<div id="overlay" class="overlay"></div>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container-fluid padding-custom">
        <i class="fas fa-bars me-3" id="menuToggle"></i>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="#" role="button" id="logout" title="Logout here...">
                    <i class="fas fa-sign-out-alt me-2"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container users-content">
    <button type="button" class="btn btn-milk-white btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#addUserModal" data-bs-auto-close="false">Add User</button>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <input type="text" id="search-user" class="form-control mb-3 w-50" placeholder="Search user here...">
        <nav>
            <ul class="pagination justify-content-center" id="user-pagination-links"></ul>
        </nav>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-milk-white">
            <tr>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">User Role</th>
                <th scope="col" class="text-center">
                    Setting
                </th>
            </tr>
        </thead>
        <tbody id="user-data-container"></tbody>
    </table>
    </div>
</div>

<?php include __DIR__ . '/../footer.php' ?>

<?php
include __DIR__ . '/../modal/users/AddUserModal.php';
include __DIR__ . '/../modal/users/RetrieveUserModal.php';
include __DIR__ . '/../modal/users/DeleteUserModal.php';
include __DIR__ . '/../modal/users/AskPasswordOnUserDeletionModal.php';

