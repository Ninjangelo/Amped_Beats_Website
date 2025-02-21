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
    <link rel="stylesheet" type="text/css" href="styles/dj_upcoming_bookings.css" />
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3" action="dj_dashboard.php" method="post">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index2.php">
            <span id="logoText">Amped Beats</span>
        </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="about_us2.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="services2.php">Services</a></li>
            </ul>
           
            
            <form action="dj_dashboard.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>


<?php
// Connect to MySQL database
session_start();

$username = $_SESSION["username"];
$discjockeyID = $_SESSION["discjockeyID"];
$email = $_SESSION["email"];

// Connecting to the database
include "db_connection.php";

$alertMessage = "";

// Handle form submission to update status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookingID"]) && isset($_POST["status"])) {
    $bookingID = $_POST["bookingID"];
    $status = $_POST["status"];

    // Update booking status
    $updateQuery = "UPDATE booking SET status = ? WHERE bookingID = ? AND discjockeyID = ?";
    $stmt = $mysqli->prepare($updateQuery);
    $stmt->bind_param("sii", $status, $bookingID, $discjockeyID);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "<p style='color: green;'>Booking status updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>No changes were made or an error occurred.</p>";
    }

    $stmt->close();
}

// Fetch bookings assigned to the DJ
/*$sql = "SELECT booking.bookingID, booking.customerID, booking.bookingname, booking.description, booking.location, booking.date, booking.status, customer.firstname, customer.lastname
        FROM booking 
        JOIN customer ON booking.customerID = customer.customerID
        WHERE booking.discjockeyID = ?";*/
$sql = "SELECT bookingID, customerID, bookingname, description, location, date, status, customerFirstName, customerLastName
FROM booking 
WHERE booking.discjockeyID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $discjockeyID);
$stmt->execute();
$result = $stmt->get_result();



// Close the database connection
$mysqli->close();
?>

<a href="dj_dashboard.php" class="back-button">Back</a>
<h2>Upcoming Bookings</h2>
<div class="dj-table-container">
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Event Name</th>
                <th>Event Details</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['customerFirstName']) . " " . htmlspecialchars($row['customerLastName']) . "</td>
                            <td>" . htmlspecialchars($row['bookingname']) . "</td>
                            <td>" . htmlspecialchars($row['description']) . "</td>
                            <td>" . htmlspecialchars($row['location']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='bookingID' value='" . $row['bookingID'] . "'>
                                    <select name='status' required>
                                        <option value='Confirmed' " . ($row['status'] == 'Confirmed' ? 'selected' : '') . ">Confirmed</option>
                                        <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                        <option value='Cancelled' " . ($row['status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                    </select>
                                    <button type='submit'>Update</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No bookings made</td></tr>";
            }
            ?>
        </tbody>
    </table>
    

</div>

</body>