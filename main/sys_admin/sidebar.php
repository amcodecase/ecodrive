<div class="sidebar bg-light border-right" style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto;">
    <div class="sidebar-header text-center py-3">
        <img src="<?= LOGO_PATH; ?>" alt="<?= htmlspecialchars(SITE_NAME); ?>" style="width: 40px; height: 40px;">
        <h5 class="mt-2"><?= htmlspecialchars(SITE_NAME); ?></h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="tolls.php"><i class="bi bi-cash"></i> Manage Tolls</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="vehicles.php"><i class="bi bi-car-front-fill"></i> Manage Vehicles</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="reports.php"><i class="bi bi-file-earmark-text"></i> View Reports</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="users.php"><i class="bi bi-person-fill"></i> Manage Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="transactions.php"><i class="bi bi-wallet"></i> Transactions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="analytics.php"><i class="bi bi-graph-up-arrow"></i> Analytics</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user_roles.php"><i class="bi bi-person-lines-fill"></i> User Roles</a>
        </li>
    </ul>
</div>
