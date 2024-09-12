<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once '../configs/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $toll_name = $_POST['toll_name'];
    $location = $_POST['location'];

    // Prepare the SQL statement
    $sql = "INSERT INTO tolls (toll_name, location) VALUES (:toll_name, :location)";

    try {
        // Prepare the statement using PDO
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':toll_name', $toll_name);
        $stmt->bindParam(':location', $location);
        
        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the toll management page after successful insert
            header('Location: tolls.php?status=success');
            exit();
        } else {
            echo "Error: Could not insert toll.";
        }
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If not a POST request, redirect to the toll management page
    header('Location: tolls.php');
    exit();
}
?>
