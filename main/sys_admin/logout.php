<?php
session_start(); // Start the session

// Destroy all session variables
$_SESSION = array();

// Destroy the session itself
session_destroy();

// Redirect to the login page
header("Location: ../index.php"); // Adjust the path based on your file structure
exit;
?>
