<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
include '../configs/db.php';
include '../configs/details.php'; // Assuming this file contains site_name variable

$site_name = SITE_NAME; 

$userEmail = $fetchedUser['email']; // Assuming you fetched user data from the database
$_SESSION['email'] = $userEmail; // Set user email in the session


// Fetching counts from the database
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalTolls = $pdo->query("SELECT COUNT(*) FROM tolls")->fetchColumn(); // Assuming you have a tolls table
$totalVehicles = $pdo->query("SELECT COUNT(*) FROM vehicles")->fetchColumn(); // Assuming you have a vehicles table

// Fetch monthly vehicle counts
$query = "SELECT MONTH(created_at) AS month, COUNT(*) AS vehicle_count
          FROM vehicles
          WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
          GROUP BY MONTH(created_at)
          ORDER BY month";

$result = $pdo->query($query);

$months = [];
$vehicleCounts = array_fill(0, 12, 0); // Initialize array with 0

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $months[] = $row['month'];
    $vehicleCounts[$row['month'] - 1] = $row['vehicle_count']; // Store vehicle counts
}

// Convert month numbers to month names
$monthsNames = array_map(function($month) {
    return date('M', mktime(0, 0, 0, $month, 1)); // Convert to month name
}, $months);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?> Admin</title>
    <link rel="icon" href="<?= LOGO_PATH; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Your custom styles -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Include only the navbar -->
    <?php include 'sidebar.php'; ?> <!-- Include only the side bar -->

    <div class="container dashboard-container">
        <h2 class="mb-4">Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-4">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h5 class="card-title" id="totalUsers"><?= htmlspecialchars($totalUsers) ?></h5>
                        <p class="card-text">Number of registered users in the system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-4">
                    <div class="card-header">Total Tolls</div>
                    <div class="card-body">
                        <h5 class="card-title" id="totalTolls"><?= htmlspecialchars($totalTolls) ?></h5>
                        <p class="card-text">Number of active tolls managed by the system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-4">
                    <div class="card-header">Total Vehicles</div>
                    <div class="card-body">
                        <h5 class="card-title" id="totalVehicles"><?= htmlspecialchars($totalVehicles) ?></h5>
                        <p class="card-text">Total number of vehicles registered in the system.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart Container -->
<!-- Line Chart Container -->
<div class="mb-4">
    <h3>Monthly Vehicle Stats</h3>
    <div class="chart-container" style="position: relative; height: 300px; width: 80%; margin: auto;">
        <canvas id="vehicleIncreaseChart"></canvas>
    </div>
</div>

    </div>

    <?php include 'footer.php'; ?> <!-- Include only the footer -->

    <script>
        // Data fetched from the database
        const months = <?php echo json_encode($monthsNames); ?>;
        const vehicleCounts = <?php echo json_encode($vehicleCounts); ?>;

        const ctx = document.getElementById('vehicleIncreaseChart').getContext('2d');
        const vehicleIncreaseChart = new Chart(ctx, {
            type: 'line', // Type of chart
            data: {
                labels: months,
                datasets: [{
                    label: 'Vehicle Statistics',
                    data: vehicleCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    borderWidth: 2,
                    fill: true,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Point color
                    pointRadius: 5, // Size of points
                    pointHoverRadius: 8, // Size of points on hover
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Vehicles',
                            font: {
                                size: 16, // Title font size
                                weight: 'bold' // Title font weight
                            }
                        },
                        ticks: {
                            color: '#333', // Tick color
                            font: {
                                size: 14 // Tick font size
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                            font: {
                                size: 16, // Title font size
                                weight: 'bold' // Title font weight
                            }
                        },
                        ticks: {
                            color: '#333', // Tick color
                            font: {
                                size: 14 // Tick font size
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14 // Legend font size
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Vehicles: ' + tooltipItem.raw; // Custom tooltip label
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
