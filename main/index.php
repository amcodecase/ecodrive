<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// After validating the user's credentials
require "loader.html";

session_start();
include 'configs/db.php';
include 'configs/details.php'; // Assuming this file contains site name and logo path

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    error_log("User is already logged in with role: " . $_SESSION['user_role']);
    
    switch ($_SESSION['user_role']) {
        case 'admin':
            header("Location: main/sys_admin/dashboard.php");
            exit();
        case 'toll_assistant':
            header("Location: /ecodrive/toll_assistant/dashboard.php");
            exit();
        case 'driver':
            header("Location: driver/dashboard.php");
            exit();
        case 'police':
            header("Location: /ecodrive/police/dashboard.php");
            exit();
        default:
            header("Location: sys_admin/dashboard.php");
            exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        switch ($user['role']) {
            case 'admin':
                header("Location: sys_admin/dashboard.php");
                exit();
            case 'toll_assistant':
                header("Location: /ecodrive/toll_assistant/dashboard.php");
                exit();
            case 'driver':
                header("Location: driver/dashboard.php");
                exit();
            case 'police':
                header("Location: /ecodrive/police/dashboard.php");
                exit();
            default:
                header("Location: /ecodrive/main/dashboard.php");
                exit();
        }
    } else {
        $error_message = "Invalid login credentials. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(SITE_NAME) ?> Login</title>
    <link rel="icon" href="<?= LOGO_MAIN; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <style>
    body{
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        position: relative; /* Required for positioning pseudo-element */
        overflow: hidden; /* Prevent scrollbars from appearing */
    }
    body::before {
    content: ""; /* Creates an empty pseudo-element */
    position: fixed; /* Fixed positioning for the background */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('assets/img/bg.jpg'); /* Background image path */
    background-size: cover; /* Cover the whole viewport */
    background-position: center; /* Center the background image */
    filter: blur(8px); /* Blur effect on the background */
    z-index: 0; /* Behind all other content */
}
    .container {
        width: 300px; /* Narrower width */
        margin-top: 5rem;
        background-color: #ffffff; /* White background for better contrast */
        padding: 2rem; /* Padding for inner spacing */
        border-radius: 0.5rem; /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        position: relative; /* Position relative for layering */
        width: 300px; /* Narrower width */
        margin-top: 5rem;
        background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background for better contrast */
        padding: 2rem; /* Padding for inner spacing */
        border-radius: 0.5rem; /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        z-index: 1; /* Ensure the container is above the blurred background */
    }
    h2 {
        color: #007bff;
        font-weight: 600;
    }
    .form-control {
        border-radius: 0.25rem;
    }
    button {
        background-image: linear-gradient(to right, #0062cc, #00bbff); 
        color: white; /* White text color */
        font-weight: 600;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: background-image 0.3s ease-in-out; /* Smooth transition for hover effect */
    }
    button:hover {
        transition: background-image 0.3s ease-in-out; /* Smooth transition for hover effect */
        background-image: linear-gradient(to right, #0056b3, #0099e6); /* Darker gradient on hover */
    }
    .alert {
        border-radius: 0.25rem;
        font-size: 0.9rem;
    }
    .forgot-password {
        text-align: right;
        margin-top: 0.5rem;
    }
    .forgot-password a {
        color: #007bff;
        text-decoration: none;
    }
    .forgot-password a:hover {
        text-decoration: underline;
    }
    .footer {
        margin-top: 2rem;
        text-align: center;
        font-size: 0.9rem;
        color: #000;
        position: relative;
    }
    .footer p{
        color: #000;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <img src="<?= LOGO_MAIN ?>" alt="<?= htmlspecialchars(SITE_NAME); ?>" style="width: 50px; height: 50px;">
            <h2 class="my-3"><?= htmlspecialchars(SITE_NAME); ?></h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12"> <!-- Changed to col-md-12 for full-width -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="forgot-password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-custom btn-block mt-3">Login</button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date("Y") ?> <?= htmlspecialchars(SITE_NAME) ?>. All rights reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
