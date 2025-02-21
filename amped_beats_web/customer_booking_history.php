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

    <!-- CSS Link (FOR OVERWRITING) -->
    <link rel="stylesheet" type="text/css" href="styles/customer_booking_history.css" />
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" action="customer_dashboard.php" method="post">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index1.php">
            <span id="logoText">Amped Beats</span>
        </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="about_us1.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="services1.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
            </ul>
            <form action="customer_dashboard.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>


<?php
// Connect to MySQL database
session_start();

$username = $_SESSION["username"];
$customerID = $_SESSION["customerID"];
$email = $_SESSION["email"];

// Connecting to the database
include "db_connection.php";

$alertMessage = "";

// Fetch booking details
$sql = "SELECT booking.discjockeyID, booking.bookingname, booking.description, booking.location, booking.date, booking.status, discjockey.firstname, discjockey.lastname
        FROM booking booking
        JOIN discjockey discjockey ON booking.discjockeyID = discjockey.discjockeyID
        where customerID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching bookings: " . $mysqli->error);
}

// Close the database connection
$mysqli->close();
?>

<a href="customer_dashboard.php" class="back-button">Back</a>
<h2>Booking History</h2>
<div class="dj-table-container">
    <table>
        <thead>
            <tr>
                <th>DJ</th>
                <th>Event Name</th>
                <th>Event Details</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td><td>" . htmlspecialchars($row['bookingname']) . "</td><td>" . htmlspecialchars($row['description']) . "</td><td>" . htmlspecialchars($row['location']) . "</td><td>" . htmlspecialchars($row['date'] ) . "</td><td>" . htmlspecialchars($row['status'] ) . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No bookings made</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



</body>