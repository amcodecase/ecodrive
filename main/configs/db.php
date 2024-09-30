<?php
// Database configuration
$host = 'localhost'; // Change to your database host
$db   = 'ecodrive'; // Change to your database name
<<<<<<< HEAD
$user = 'bc'; // Change to your database username
$pass = 'Tasheni'; // Change to your database password
=======
$user = 'smith'; // Change to your database username
$pass = 'Amos1an@!'; // Change to your database password
>>>>>>> 59ba7358a96a34c3ccf2e3e7d3222bb27b9f6ea0
$charset = 'utf8mb4';

// Set up the Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Database connection successful!"; // For testing purposes
} catch (\PDOException $e) {
    // Handle connection errors
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
