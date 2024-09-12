<?php

session_start();
include '../configs/db.php'; // This file should initialize the $pdo variable (PDO)
include '../configs/details.php'; // Assuming this file contains site_name variable

$site_name = SITE_NAME; 

// Query to fetch tolls data from the database
try {
    $query = "SELECT id, toll_name, location, created_at FROM tolls";
    $stmt = $pdo->prepare($query); // Prepare the query using the $pdo instance
    $stmt->execute(); // Execute the query
    $tolls = $stmt->fetchAll(); // Fetch all the results
} catch (PDOException $e) {
    // Handle any errors
    echo "Error fetching tolls: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?> Admin - Manage Tolls</title>
    <link rel="icon" href="<?= LOGO_PATH; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Style for the page background */
/* Style for the table container */
.table-container {
    width: 100%;
    max-width: 1000px;
    background-color: white;
    padding: 5px;
    border-radius: 10px;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 300px;
}

/* Table styling */
.table {
    width: 100%;
}

.table th, .table td {
    text-align: left;
    vertical-align: middle;
}

.table th {
    background-color: #0056b3;
    color: white;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f2f2f2;
}

.table-striped tbody tr:hover {
    background-color: #e9ecef;
}

/* Input field for live search */
#search-input {
    max-width: 250px;
}

/* Button styling */
.btn-primary {
    background-color: #0062cc;
    border-color: #005cbf;
}

.btn-primary:hover {
    background-color: #004085;
    border-color: #003366;
}

/* Modal customization */
.modal-content {
    border-radius: 10px;
}

    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <div class="table-container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Tolls</h2>
        <div class="d-flex">
            <input type="text" id="search-input" class="form-control mr-2" placeholder="Search...">
            <button class="btn btn-primary" data-toggle="modal" data-target="#createTollModal">Add New Toll</button>
        </div>
    </div>

    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>SN</th>
                <th>Toll Name</th>
                <th>Location</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="toll-table-body">
            <?php
            if (count($tolls) > 0) {
                foreach ($tolls as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['toll_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>
                            <a href='edit_toll.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='delete_toll.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No tolls found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for Creating a New Toll -->
<div class="modal fade" id="createTollModal" tabindex="-1" role="dialog" aria-labelledby="createTollModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTollModalLabel">Create New Toll</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="insert_toll.php" method="post">
            <div class="form-group">
                <label for="tollName">Toll Name</label>
                <input type="text" name="toll_name" id="tollName" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <?php include 'footer.php'; ?>
    <script>
        document.getElementById('search-input').addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase();
    var tableRows = document.querySelectorAll('#toll-table-body tr');

    tableRows.forEach(function(row) {
        var rowText = row.textContent.toLowerCase();
        if (rowText.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
