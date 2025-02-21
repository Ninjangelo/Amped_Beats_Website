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

// Fetch booking details
$sql = "SELECT reviewID, ratingvalue, reviewdescription FROM review";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching reviews: " . $mysqli->error);
}

// Close the database connection
$mysqli->close();
?>

<a href="admin_panel.php" class="back-button">Back</a>
<h2>Review Summary</h2>
<div class="dj-table-container">
<!--Making the table to display all the Accounts-->    
<table>
        <thead>
            <tr>
                <th>Review ID</th>
                <th>Review Rating out of 5</th>
                <th>Review Description</th>
                      
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['reviewID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ratingvalue']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['reviewdescription']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No reviews made</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



</body>