<?php
session_start();

include '../configs/db.php'; // Database connection
include '../configs/details.php'; // Database connection

// Fetch vehicle classes from the database
$query_classes = "SELECT id, class_name FROM vehicle_classes";
$stmt_classes = $pdo->prepare($query_classes);
$stmt_classes->execute();
$vehicle_classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

// Fetch drivers from the database
$query_drivers = "SELECT id, email FROM users WHERE role = 'driver'";
$stmt_drivers = $pdo->prepare($query_drivers);
$stmt_drivers->execute();
$drivers = $stmt_drivers->fetchAll(PDO::FETCH_ASSOC);

// Fetch vehicles and join with vehicle classes using PDO
$query_vehicles = "SELECT vehicles.id, vehicles.vehicle_number, vehicles.created_at, vehicle_classes.class_name, vehicle_classes.toll_fee 
                   FROM vehicles 
                   JOIN vehicle_classes ON vehicles.class_id = vehicle_classes.id";

try {
    $stmt_vehicles = $pdo->prepare($query_vehicles); // Use PDO to prepare the query
    $stmt_vehicles->execute(); // Execute the query
    $vehicles = $stmt_vehicles->fetchAll(); // Fetch all the results
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?> Admin - Manage Vehicles</title>
    <link rel="icon" href="<?= LOGO_PATH; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 offset-md-3">
            <div class="content">
                <h2 class="mb-4">Manage Vehicles</h2>
                
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addVehicleModal">Add Vehicle</button>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehicle Number</th>
                            <th>Class</th>
                            <th>Toll Fee (K)</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($vehicles) > 0) {
                            foreach ($vehicles as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['vehicle_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
                                echo "<td>" . $row['toll_fee'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-sm btn-warning' data-toggle='modal' data-target='#editVehicleModal' data-id='" . $row['id'] . "' data-vehicle-number='" . htmlspecialchars($row['vehicle_number']) . "'>Edit</button>
                                        <a href='archive_vehicle.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Archive</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No vehicles found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Vehicle Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVehicleModalLabel">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="insert_vehicle.php" method="POST" id="addVehicleForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehicle_number">Vehicle Number</label>
                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" required>
                    </div>
                    <div class="form-group">
                        <label for="driver_id">Driver</label>
                        <select class="form-control" id="driver_id" name="driver_id" required>
                            <option value="">Select Driver</option>
                            <?php foreach ($drivers as $driver): ?>
                                <option value="<?= $driver['id'] ?>"><?= htmlspecialchars($driver['email']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_id">Class</label>
                        <select class="form-control" id="class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            <?php foreach ($vehicle_classes as $class): ?>
                                <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="other_details">Other Details</label>
                        <textarea class="form-control" id="other_details" name="other_details"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Vehicle Modal -->
<div class="modal fade" id="editVehicleModal" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVehicleModalLabel">Edit Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="update_vehicle.php" method="POST" id="editVehicleForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_vehicle_number">Vehicle Number</label>
                        <input type="text" class="form-control" id="edit_vehicle_number" name="vehicle_number" required>
                    </div>
                    <input type="hidden" id="edit_vehicle_id" name="vehicle_id">
                    <div class="form-group">
                        <label for="edit_driver_id">Driver</label>
                        <select class="form-control" id="edit_driver_id" name="driver_id" required>
                            <option value="">Select Driver</option>
                            <?php foreach ($drivers as $driver): ?>
                                <option value="<?= $driver['id'] ?>"><?= htmlspecialchars($driver['email']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_class_id">Class</label>
                        <select class="form-control" id="edit_class_id" name="class_id" required>
                            <option value="">Select Class</option>
                            <?php foreach ($vehicle_classes as $class): ?>
                                <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_other_details">Other Details</label>
                        <textarea class="form-control" id="edit_other_details" name="other_details"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fetch vehicle details based on vehicle number (mock function)
    $(document).ready(function () {
        $('#vehicle_number').on('blur', function () {
            var vehicleNumber = $(this).val();
            // Here you would implement an AJAX call to fetch vehicle details from an API or database
            // For demo purposes, we will mock the data
            if (vehicleNumber === 'ABC123') { // Replace this with actual AJAX call
                $('#class_id').val('1'); // Example class ID
                $('#other_details').val('Some details about the vehicle');
            } else {
                $('#class_id').val('');
                $('#other_details').val('');
            }
        });

        // Populate edit modal with vehicle data
        $('#editVehicleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var vehicleId = button.data('id');
            var vehicleNumber = button.data('vehicle-number');

            // You would fetch the vehicle details from the database here
            $('#edit_vehicle_id').val(vehicleId);
            $('#edit_vehicle_number').val(vehicleNumber);
            // Populate additional fields as necessary
        });
    });
</script>

</body>
</html>
