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
    <link rel="stylesheet" type="text/css" href="styles/login_customer.css" />

</head>


<body>
  <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span id="logoText">Amped Beats</span>
        </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
            </ul>
           
            <a class="btn btn-primary ms-md-2" role="button" href="register.php">Register</a>
        </div>
    </div>
</nav>



<div id="formContainer">
        <form action="login_customer.php" method="post" >
            <a href="login.php" id="back-button" >Back to Login</a>
            <h1>Customer Login</h1>
            <?php
            session_start(); // Start the session

            // Connecting to the database
            include "db_connection.php";

            if (isset($_POST["login_customer"])) {
                // Get form data
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Prepare a SQL statement (fix: search by email)
                $customerStatement = $mysqli->prepare(
                    "SELECT email, password, customerID, username, adminID FROM account WHERE email = ?"
                );

                // Bind the parameters (fix: bind only email)
                $customerStatement->bind_param("s", $email);

                // Execute the statement
                $customerStatement->execute();
                $customerStatement->store_result();

                // Error messages
                $email_retrieve_error = "ERROR: Customer Account does not exist!";
                $password_retrieve_error = "ERROR: Incorrect password!";
                $not_customer_error = "ERROR: Only Customer Accounts can log in here!";

                // Check if the user exists
                if ($customerStatement->num_rows > 0) {
                    // Bind the result to variables
                    $customerStatement->bind_result($db_email, $hashed_password, $db_customerID, $db_username, $db_adminID);
                    $customerStatement->fetch();

                        // Verify the password
                    if (password_verify($password, $hashed_password)) {
                        // Check if the user is a customer (customerID is not null )
                        if (!is_null($db_adminID) ) {
                            // Set session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $db_email;
                            $_SESSION["adminID"] = $db_adminID;
                            $_SESSION["username"] = $db_username;

                            // Redirect to customer dashboard
                            header("Location: admin_panel.php");
                            exit();
                        } elseif (!is_null($db_customerID)) {
                            // Set session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $db_email;
                            $_SESSION["customerID"] = $db_customerID;
                            $_SESSION["username"] = $db_username;

                            header("Location: customer_dashboard.php");
                            exit();
                        } else {
                            echo "<p id=\"errorMessage\">" . $not_customer_error . "</p>";
                        }
                    } else {
                        echo "<p id=\"errorMessage\">" . $password_retrieve_error . "</p>";
                    }
                } else {
                    echo "<p id=\"errorMessage\">" . $email_retrieve_error . "</p>";
                }

                // Close the connection
                $customerStatement->close();
                $mysqli->close();
            }
            ?>

            <div class="mb-3">
                <label for="fullname" >email</label> 
                <input id="entryBox" name="email" required="" type="text" placeholder="Enter your email" />
                
            </div>
            <div class="mb-3">
                <label for="username">password</label>
                <input id="entryBox" name="password" required="" type="password" placeholder="Enter your password"  />
            </div>
          
            <input id="loginButton" name="login_customer" type="submit" value="Login" />
        </form>
    </div>

</body> 
