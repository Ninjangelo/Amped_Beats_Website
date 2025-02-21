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
    <link rel="stylesheet" type="text/css" href="styles/index.css" />
    

</head>


<body>
    <?php
    session_start();
    
    $username = $_SESSION["username"];
    $discjockeyID = $_SESSION["discjockeyID"];
    $email = $_SESSION["email"];

    ?>

    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index2.php">
                <span id="logoText">Amped Beats</span>
            </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-5">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us2.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="services2.php">Services</a></li>
                </ul>
                <a class="btn btn-primary ms-md-2" role="button" href="dj_dashboard.php"><?php echo $username ?> Dashboard</a>
            </div>
        </div>
    </nav>
    <div id="videoContainer">
        <video autoplay muted loop id="videoVisual">
            <source src="media/4124198-hd_1920_1080_24fps.mp4" type="video/mp4">
        </video>
        <h1 id="videoText1">Amped Beats</h1>
        <h2 id="videoText2">Bringing People Together Through Music.</h2>
        <div id="videoButtons">
            <a role="button" href="dj_upcoming_bookings.php">View Bookings</a>
            <a role="button" href="services2.php">Event Types</a>
        </div>
    </div>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Current Popular DJs</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="media/20241128_235245.jpg" class="card-img-top" alt="Weddings">
                    <div class="card-body">
                        <h5 class="card-title">AbraaRKadabraaR</h5>
                        <p class="card-text">Type: Club </p>
                            <p class="card-text">Genre: UK Drill</p> 
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/20241128_235217.jpg" class="card-img-top" alt="Store Events">
                    <div class="card-body">
                        <h5 class="card-title">HariSpins</h5>
                        <p class="card-text">Type: Concert</p>
                        <p class="card-text">Genre: Hip Hop</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/20241128_234615.jpg" class="card-img-top" alt="Club">
                    <div class="card-body">
                        <h5 class="card-title">Michael Ninjangelo</h5>
                        <p class="card-text">Type: Wedding</p>
                        <p class="card-text">Genre: Disco</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/john.jpg" class="card-img-top" alt="Birthdays">
                    <div class="card-body">
                        <h6 class="card-title">YoAdrian!</h6>
                        <p class="card-text">Type: Birthdays</p>
                        <p class="card-text">Genre: EDM</p>
                    </div>
                </div>
            </div>





            <div class="container mt-5">
        <h1 class="text-center mb-4">Specialised Events</h1>

        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="media/pexels-transtudios-3082764(1).jpg" class="card-img-top" alt="Weddings">
                    <div class="card-body">
                        <h5 class="card-title">Weddings</h5>
                        <p class="card-text">Celebrate your special day with unforgettable music and entertainment.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/istockphoto-96307569-612x612(1).jpg" class="card-img-top" alt="Store Events">
                    <div class="card-body">
                        <h5 class="card-title">Store Events</h5>
                        <p class="card-text">Make your corporate event memorable with top-notch DJ services.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/concert-8379979_1280(1).jpg" class="card-img-top" alt="Club">
                    <div class="card-body">
                        <h5 class="card-title">Club</h5>
                        <p class="card-text">Turn your private club into a night of classical tunes to build a night</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="media/Birthdays.jpg" class="card-img-top" alt="Birthdays">
                    <div class="card-body">
                        <h6 class="card-title">Birthdays</h6>
                        <p class="card-text">Happy Birthday! Why not celebrate another year of your life with a bang?</p>
                    </div>
                </div>
            </div>

   
    <footer id="footer">
        <div class="text-white py-4 py-lg-5">
            <p style="font-family: 'Black Ops One', serif; font-size: 46px;">Amped Beats</p>
            <p class="text-muted mb-0">© Amped Beats - Haris Ahmed Dadd, Mohammed Abraar Hamid, Adrian Kosowski, Angelo Luis Lagdameo 2024</p>
        <div class="nav-links d-flex justify-content-center mt-3">
            <a class="nav-link text-white mx-2" href="services2.php">Services</a>
            <a class="nav-link text-white mx-2" href="index2.php">Home</a>
            <a class="nav-link text-white mx-2" href="dj_upcoming_bookings.php">Booking</a>
      </div>
    </div>
    </footer>
</body>

</html>