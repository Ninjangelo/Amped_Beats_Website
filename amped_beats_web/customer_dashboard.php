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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/Lightbox-Gallery.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles/customer_dashboard.css" />

</head>



<body>
    <?php
    session_start();
    
    $username = $_SESSION["username"];
    $customerID = $_SESSION["customerID"];
    $email = $_SESSION["email"];
    
    if (isset($_POST["logout"])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
    ?>

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
            <form action="customer_dashboard.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>



    <div class="dashboard-container">
        <h1 id="personalTitle"><?php echo $username; ?>'s Dashboard</h1>
        <div class="dashboard-grid">
            <a href="customer_booking_history.php" class="dashboard-block">Booking History</a>
            <a href="customer_account_management.php" class="dashboard-block">Account Management</a>
            <a href="booking_form.php" class="dashboard-block booking-form">Booking Form</a>
        </div>
    </div>
</body>
</html>
