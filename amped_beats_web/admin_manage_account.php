<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Character Encoding -->
    <meta charset="utf-8">
    <!-- Viewport Settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Website Tab Title -->
    <title>Amped Beats | DJ Booking and Agency</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Jockey+One&family=Michroma&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Library Links for CSS and Javascript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" type="text/css" href="styles/customer_booking_history.css" />
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" action="admin_panel.php" method="post">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="admin_panel.php">
            <span id="logoText">Amped Beats</span>
        </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
            </ul>
            <form action="admin_panel.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>


<?php
// Connect to MySQL database
session_start();

$username = $_SESSION["username"];
$customerID = $_SESSION["adminID"];
$email = $_SESSION["email"];

// Connecting to the database
include "db_connection.php";

$alertMessage = "";

// Fetch account details
$sql = "SELECT accountID, username, email, phone , address FROM account";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching accounts: " . $mysqli->error);
}

// Handle deletion if a request is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteaccount"])) {
    $accountID = intval($_POST["accountID"]);

    $stmt = $mysqli->prepare("DELETE FROM account WHERE accountID = ?");
    $stmt->bind_param("i", $accountID);

    if ($stmt->execute()) {
        $successMessage = "Account deleted successfully!";
        header("Location: admin_manage_account.php");
    } else {
        $errorMessage = "Error deleting account.";
    }
    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>

<a href="admin_panel.php" class="back-button">Back</a>
<h2>Accounts Management</h2>
<div class="dj-table-container">
<!--Making the table to display all the Accounts-->    
<table>
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Location</th>
                <th>Address</th>
        
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['accountID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
          
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
          
                    echo "<td>";
            ?>
                        <form method="post" action="admin_manage_account.php" onsubmit="return confirm('Are you sure you want to delete this account?');">
                            <input type="hidden" name="accountID" value="<?= htmlspecialchars($row['accountID']); ?>">
                            <button type="submit" name="deleteaccount" class="btn btn-danger">Delete</button>
                        </form>
                    <?php
                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No account made</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



</body>