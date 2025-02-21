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
    <link rel="stylesheet" type="text/css" href="styles/booking_form.css" />
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
                <li class="nav-item"><a class="nav-link" href="reviews1.php">Reviews</a></li>
            </ul>
           
            <!--<a class="btn btn-primary ms-md-2" role="button" href="register_account.php">Logout</a>-->
            <form  action="customer_dashboard.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>


<?php
session_start();

// Global Array Variables
$username = $_SESSION["username"];
$customerID = $_SESSION["customerID"];
$email = $_SESSION["email"];

$alertMessage = "";

// Connecting to the database
include "db_connection.php";

// Fetch DJ details
$sql = "SELECT discjockeyID, firstname, lastname, genre FROM discjockey";
$result = $mysqli->query($sql);

if (!$result) {
    die("Error fetching DJs: " . $mysqli->error);
}

// Check if the form was submitted
if (isset($_POST["booking_form"])) {
    // Collect form data
    $dj_firstname = $_POST["dj_firstname"];
    $dj_lastname = $_POST["dj_lastname"];
    $booking_name = $_POST["event_name"];
    $booking_date = $_POST["booking_date"];
    $location = $_POST["location"];
    $description = $_POST["extra_details"];
    $status = "Pending";

    $sql = "SELECT discjockeyID FROM discjockey WHERE firstname = ? AND lastname = ?";

    $getDiscJockeyID = $mysqli->prepare($sql);
    $getDiscJockeyID->bind_param("ss", $dj_firstname, $dj_lastname);
    $getDiscJockeyID->execute();
    $getDiscJockeyID->store_result();

    $getDiscJockeyID->bind_result($db_discjockeyID);
    $getDiscJockeyID->fetch();

    // Fetch the full name of the customer
    $sql = "SELECT firstName, lastName FROM customer WHERE customerID = ?";
    $getFullName = $mysqli->prepare($sql);
    $getFullName->bind_param("i", $customerID);
    $getFullName->execute();
    $getFullName->store_result();

    // Check if the customer was found
    if ($getFullName->num_rows > 0) {
        $getFullName->bind_result($customerFirstName, $customerLastName);
        $getFullName->fetch();
    } else {
        die("Customer not found.");
    }

    // Prepare the SQL query to insert data into the `booking` table
    $sql = "INSERT INTO booking (customerID, discjockeyID, bookingname, description, location, date, status, customerFirstName, customerLastName)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $insertBooking = $mysqli->prepare($sql);

    if ($insertBooking) {
        // Bind the parameters to the statement
        $insertBooking->bind_param("iisssssss", $customerID, $db_discjockeyID, $booking_name, $description, $location, $booking_date, $status, $customerFirstName, $customerLastName);

        // Execute the statement
        if ($insertBooking->execute()) {
            echo "Booking successfully submitted!";
        } else {
            echo "Error: " . $insertBooking->error;
        }

        // Close the statement
        $insertBooking->close();
        $getDiscJockeyID->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>

<h2>Available DJs</h2>
<div class="dj-table-container">
    <table>
        <thead>
            <tr>
                <th>DJ Name</th>
                <th>Genre</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</td><td>" . htmlspecialchars($row['genre']) . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No DJs available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<h2>Booking</h2>
<form id="form_main" action="booking_form.php" method="POST">
    <label for="dj_name">First Name of DJ:</label>
    <input type="text" id="dj_firstname" name="dj_firstname" required><br><br>

    <label for="dj_name">Last Name of DJ:</label>
    <input type="text" id="dj_lastname" name="dj_lastname" required><br><br>

    <label for="dj_name">Event Name:</label>
    <input type="text" id="event_name" name="event_name" required><br><br>

    <label for="booking_date">Date of Booking:</label>
    <input type="date" id="booking_date" name="booking_date" required><br><br>

    <label for="event_type">Location:</label>
    <input type="text" id="location" name="location" required><br><br>

    <label for="extra_details">Extra Details:</label>
    <textarea id="extra_details" name="extra_details" rows="4" cols="50"></textarea><br><br>

    <input type="submit" name="booking_form" value="Book Now">

    <a href="customer_dashboard.php" class="back-button">Back to Dashboard</a>
</form>

</body>
</html>