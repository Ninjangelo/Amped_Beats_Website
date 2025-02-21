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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Jockey+One&family=Michroma&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Library Links for CSS and Javascript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles/reviews1.css" />

</head>


<body>
    <?php
    session_start();
    if (!isset($_SESSION["customerID"])) {
        die("You must be logged in to submit a review.");
    }
    
    // Connecting to the database
    include "db_connection.php";

    $customerID = $_SESSION["customerID"];
    $username = $_SESSION["username"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitReview"])) {
        $reviewdescription = trim($_POST["reviewdescription"]);
        $ratingvalue = intval($_POST["ratingvalue"]);

        if (empty($reviewdescription)) {
            echo "Review cannot be empty.";
        } elseif ($ratingvalue < 1 || $ratingvalue > 5) {
            echo "Invalid rating.";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO review (customerID, reviewdescription, ratingvalue) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $customerID, $reviewdescription, $ratingvalue);
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Review submitted successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error submitting review: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        }
    }

    $mysqli->close();

    ?>

    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span id="logoText">Amped Beats</span>
            </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-5">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us1.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="services1.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="reviews.php">Reviews</a></li>
                </ul>
                <a class="btn btn-primary ms-md-2" role="button" href="customer_dashboard.php"><?php echo $username ?> Dashboard</a>
            </div>
        </div>
    </nav>


    <div id="section1">
    <div id="userSelectionBlock">
        <h1>Review Us</h1>
         <!-- Display message here -->
         <?php if (!empty($message)) echo $message; ?>       
         
        <form action="reviews1.php" method="post">
            <div class="mb-3">
                <label for="reviewdescription"></label> 
                <textarea id="entryBox" name="reviewdescription" required placeholder="Write Your Review"></textarea>
            </div>
            <h1>Rate Us:</h1>
            <div class="star-rating">
                <input type="radio" id="star5" name="ratingvalue" value="5" required>
                <label for="star5">★</label>
                <input type="radio" id="star4" name="ratingvalue" value="4">
                <label for="star4">★</label>
                <input type="radio" id="star3" name="ratingvalue" value="3">
                <label for="star3">★</label>
                <input type="radio" id="star2" name="ratingvalue" value="2">
                <label for="star2">★</label>
                <input type="radio" id="star1" name="ratingvalue" value="1">
                <label for="star1">★</label>
            </div>
            <div id="buttonBlock"> 
                <input id="registerAccountButton" type="submit" name="submitReview" value="Submit">
            </div>
        </form>
    </div>
</div>
    
    <div id="footer">
       <div class="text-white py-4 py-lg-5">
         <p style="font-family: 'Black Ops One', serif; font-size: 46px;">Amped Beats</p>
         <p class="text-muted mb-0">© Amped Beats - Haris Ahmed Dadd, Mohammed Abraar Hamid, Adrian Kosowski, Angelo Luis Lagdameo 2024</p>
         <div class="nav-links d-flex justify-content-center mt-3">
             <a class="nav-link text-white mx-2" href="services.php">Services</a>
             <a class="nav-link text-white mx-2" href="index.php">Home</a>
             <a class="nav-link text-white mx-2" href="register.php">Booking</a>
         </div>
       </div>
    </div>
</body>