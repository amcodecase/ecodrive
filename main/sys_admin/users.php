<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include '../configs/db.php'; // Database connection
include '../configs/details.php'; // Site details

$site_name = SITE_NAME;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

require '../../vendor/autoload.php'; // Ensure PHPMailer and QR code libraries are included

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $generated_password = substr(md5(rand()), 0, 4); // Generate a random 4-character password
    $hashed_password = md5($generated_password); // Hash the password

    // Generate QR Code
    $qrContent = "{$first_name} {$last_name}";
    $qrCode = new QrCode($qrContent);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);

    // Convert QR code to base64 string
    $writer = new PngWriter();
    $qrCodeResult = $writer->write($qrCode);
    $qrCodeData = $qrCodeResult->getString();
    $qrCodeBase64 = base64_encode($qrCodeData);

    // Insert the user into the database with QR code
    $query = "INSERT INTO users (first_name, last_name, email, password, role, qr_code) VALUES (:first_name, :last_name, :email, :password, :role, :qr_code)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':qr_code', $qrCodeBase64);

    if ($stmt->execute()) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // PHPMailer Server settings
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dedda8de931729'; // Mailtrap credentials
            $mail->Password   = '63e4c7635436c8'; // Mailtrap credentials
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            // Recipients
            $mail->setFrom('no-reply@yourwebsite.com', 'Admin');
            $mail->addAddress($email); // Add user's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = "Your new account at $site_name";
            $mail->Body    = "
                <p>Dear {$first_name} {$last_name},</p>
                <p>Your account has been created successfully. Here are your login details:</p>
                <p>Email: {$email}</p>
                <p>Password: {$generated_password}</p>
                <p>Regards,<br>$site_name Team</p>";

            $mail->send();
            echo "<script>alert('User added successfully, and login details have been sent to their email.');</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Failed to add the user.';
    }
}

// Fetch all users from the database
$query = "SELECT * FROM users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch unique roles from the database
$query = "SELECT DISTINCT role FROM users";
$stmt = $pdo->query($query);
$roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>


<!-- Your HTML code to display users or other information -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?> Admin - Manage Users</title>
    <link rel="icon" href="<?= LOGO_PATH; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .m-container {
            width: 100%;
            max-width: 1000px;
            background-color: white;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 300px;
        }

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
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="m-container mt-5">
    <button type="button" class="btn btn-primary m-4" data-toggle="modal" data-target="#addUserModal">
        Add New User
    </button>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search users by email or role..." onkeyup="filterTable()">

    <table class="table table-striped" id="usersTable">
        <thead>
            <tr>
                <th>SN</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($users) > 0) {
                foreach ($users as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo '<td>
                        <a href="edit_user.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_user.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>
                        </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addUserForm" action="users.php" method="POST">
          <div class="form-group">
            <label for="userFirstName">First Name</label>
            <input type="text" class="form-control" id="userFirstName" name="first_name" required>
          </div>
          <div class="form-group">
            <label for="userLastName">Last Name</label>
            <input type="text" class="form-control" id="userLastName" name="last_name" required>
          </div>
          <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="email" class="form-control" id="userEmail" name="email" required>
          </div>
          <div class="form-group">
            <label for="userRole">Role</label>
            <select class="form-control" id="userRole" name="role" required>
              <?php
              // Populate roles in the dropdown
              foreach ($roles as $role) {
                  echo "<option value='" . htmlspecialchars($role) . "'>" . htmlspecialchars($role) . "</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" name="addUser">Add User</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("usersTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdEmail = tr[i].getElementsByTagName("td")[2];
        let tdRole = tr[i].getElementsByTagName("td")[4];
        if (tdEmail || tdRole) {
            let emailValue = tdEmail.textContent || tdEmail.innerText;
            let roleValue = tdRole.textContent || tdRole.innerText;
            if (emailValue.toLowerCase().indexOf(filter) > -1 || roleValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
