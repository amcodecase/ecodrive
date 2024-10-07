<?php
session_start();
include '../configs/db.php'; 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT first_name, last_name, email, role, qr_code, toll_crossings, payments_made, outstanding_balance FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $firstName = htmlspecialchars($user['first_name']);
    $lastName = htmlspecialchars($user['last_name']);
    $email = htmlspecialchars($user['email']);
    $role = htmlspecialchars($user['role']);
    $qrCodeBase64 = htmlspecialchars($user['qr_code']);
    $tollCrossings = htmlspecialchars($user['toll_crossings']);
    $paymentsMade = htmlspecialchars($user['payments_made']);
    $outstandingBalance = htmlspecialchars($user['outstanding_balance']);
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Ecodrive Beta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #007bff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .dashboard-container {
            padding: 40px 30px;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .stats-card {
            text-align: center;
            background-color: #007bff;
            color: white;
            border-radius: 20px;
        }
        .stats-card h5, .stats-card p {
            margin: 0;
        }
        .profile-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        .qr-code img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
        }
        .icon-text {
            display: flex;
            align-items: center;
        }
        .icon-text i {
            margin-right: 10px;
            color: #007bff;
            font-size: 1.2em; /* Adjust icon size */
        }
        .navbar-nav li:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ecodrive Beta</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Payments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container dashboard-container">
        <div class="row mb-4">
            <!-- User Profile Card -->
            <div class="col-md-4">
                <div class="card profile-info">
                    <h5 class="card-title">User Profile</h5>
                    <p class="icon-text"><i class="bi bi-person-circle"></i> <strong>Name:</strong> <?= $firstName . ' ' . $lastName; ?></p>
                    <p class="icon-text"><i class="bi bi-envelope-fill"></i> <strong>Email:</strong> <?= $email; ?></p>
                    <p class="icon-text"><i class="bi bi-shield-lock"></i> <strong>Role:</strong> <?= $role; ?></p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="col-md-4 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Your Login QR Code</h5>
                        <?php if (!empty($qrCodeBase64)) : ?>
                            <img src="data:image/png;base64,<?= $qrCodeBase64 ?>" alt="QR Code" class="img-fluid rounded">
                        <?php else: ?>
                            <p>No QR code available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Toll Crossings and Payments -->
            <div class="col-md-4">
                <div class="card stats-card mb-3">
                    <h5>Total Toll Crossings</h5>
                    <p><i class="bi bi-check-circle"></i> <?= $tollCrossings ?></p>
                </div>
                <div class="card stats-card mb-3">
                    <h5>Total Payments Made</h5>
                    <p><i class="bi bi-cash"></i> <?= $paymentsMade ?></p>
                </div>
            </div>
        </div>

        <!-- Additional Information and Stats -->
        <div class="row">
            <div class="col-md-4">
                <!-- Outstanding Balance -->
                <div class="card stats-card">
                    <h5>Outstanding Balance</h5>
                    <p>$<?= $outstandingBalance ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Notifications or Alerts -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Notifications</h5>
                        <p>No new notifications</p>
                        <!-- You can loop through database notifications here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
