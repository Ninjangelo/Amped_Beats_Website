<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Amped Beats</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Jockey+One&family=Michroma&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="styles/about_us.css" />
    
    
</head>
<body>
    <?php
    session_start();
    
    $username = $_SESSION["username"];
    $customerID = $_SESSION["customerID"];
    $email = $_SESSION["email"];

    ?>

<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
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
                <a class="btn btn-primary ms-md-2" role="button" href="customer_dashboard.php"><?php echo $username ?> Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="about-us-box">
            <h1 class="text-center mb-4">What is Amped Beats?</h1>

            <section>
                <p>We are a DJ Booking Agency aiming to ease and simplify the process of finding and booking the perfect DJ for customers wanting to make their events and occasions ones to remember.</p>
                <p>Additionally, Amped Beats is a place for freelancing, independent DJs to promote their talents and unique services. Our site has a large community of DJs to choose from and get quick contact with. With our booking process, we help recommend the qualified DJ fit for your agenda.</p>
            </section>

            <h2>Our Origins:</h2>
            <section>
                <p>The origin came from a friend of ours, co-founder Angelo Luis Lagdameo. Being a young aspiring DJ, he sought a method to manage his bookings and improve communication with his clients.</p>
                <p>That's when the other three members—Abraar, Adrian, and Haris—decided to band together alongside Angelo to build a system capable of handling this issue effectively.</p>
            </section>

            <h2>Our Technology:</h2>
            <section>
                <p>Using an SQL database to house all our data, we built a database with information about our clients, DJs, and admins. This is integrated with a website coded in HTML, CSS, and PHP to allow for seamless user interaction.</p>
                <p>Our initial designs were created and planned out in documentation, declaring all our requirements, creating Entity Relationship Diagrams for our database concept, and explaining what we would implement and why.</p>
            </section>

            <h2>Our Design Process:</h2>
            <section>
                <p>When it came to designing our website, we primarily used Figma to create a website template, which served as the final design. Ultimately, we used it as a guide to build the rest of the site, making development more efficient.</p>
            </section>
        </div>
    </div>

    <footer id="footer">
        <div class="text-white py-4 py-lg-5">
            <p style="font-family: 'Black Ops One', serif; font-size: 46px;">Amped Beats</p>
            <p class="text-muted mb-0">© Amped Beats - Haris Ahmed Dadd, Mohammed Abraar Hamid, Adrian Kosowski, Angelo Luis Lagdameo 2024</p>
        <div class="nav-links d-flex justify-content-center mt-3">
            <a class="nav-link text-white mx-2" href="services1.php">Services</a>
            <a class="nav-link text-white mx-2" href="index1.php">Home</a>
            <a class="nav-link text-white mx-2" href="booking_form.php">Booking</a>
      </div>
    </div>
   </footer>
</body>
</html>
