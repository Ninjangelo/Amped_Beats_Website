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

    <!-- CSS Stylesheet (FOR OVERRIDING) -->
    <link rel="stylesheet" type="text/css" href="styles/register_customer.css" />

</head>


<body>
    <nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
        <div class="container">
            <a id="" class="navbar-brand d-flex align-items-center" href="index.php">
                <span id="logoText">Amped Beats</span>
            </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-5">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                </ul>
                <a class="btn btn-primary ms-md-2" role="button" href="login.php">Login</a>
            </div>
        </div>
    </nav>
    
    <!-- Register Customer Form -->
    <div id="formContainer">
        <form action="register_customer.php" method="post" >
        <a href="register.php" id="back-button" >Back</a>
        <h1>Customer Register</h1>

        <?php
        $alertMessage = "";

        // Connecting to the database
        include "db_connection.php";

        // Obtaining data from the POSTED Form
        if (isset($_POST["register_customer"])) {
            // Getting the Form Values for ACCOUNT Table
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $phoneNumber = $_POST["phoneNumber"];
            $address = $_POST["address"];

            // Hashing the Password
            $password = password_hash($password, PASSWORD_DEFAULT);

            // SQL Query for Checking if any existing Accounts contain the same Email inputted
            $emailCheckStatement = $mysqli->prepare(
                "SELECT * FROM account WHERE email = ?"
            );
            $emailCheckStatement->bind_param("s", $email);
            $emailCheckStatement->execute();
            $emailCheckResult = $emailCheckStatement->get_result();


            if ($emailCheckResult->num_rows > 0) {
                echo "<p id=\"errorMessage\">The Email you entered already has an Account!</p>";
            } else {
                
                // Preparing a SQL statement for the ACCOUNT Table --------------------------------------------
                $accountStatement = $mysqli->prepare(
                    "INSERT INTO account (username, password, email, phone, address) VALUES (?, ?, ?, ?, ?)"
                );
                $accountStatement->bind_param("sssss", $username, $password, $email, $phoneNumber, $address);

                if ($accountStatement->execute() == false) {
                    echo "Error: " . $accountStatement->error;
                    exit();
                }

                // Obtaining the Last Inserted accountID of the Recently Inserted Account  --------------------------------------------
                $obtainedAccountID = $mysqli->insert_id;

                // Getting the Form Values for CUSTOMER Table
                $firstName = $_POST["first_name"];
                $lastName = $_POST["last_name"];

                // Preparing a SQL statement for the CUSTOMER Table --------------------------------------------
                $customerStatement = $mysqli->prepare(
                    "INSERT INTO customer (accountID, firstName, lastName) VALUES (?, ?, ?)"
                );

                // Bind the VALUES Parameters for the CUSTOMER Table SQL statement
                $customerStatement->bind_param("sss", $obtainedAccountID, $firstName, $lastName);

                // Execute the Customer Table INSERT INTO SQL statement
                if ($customerStatement->execute() == false) {
                    echo "Error: " . $customerStatement->error;
                    exit();
                }

                // Obtaining the Last Inserted accountID of the Recently Inserted Account  --------------------------------------------
                $obtainedCustomerID = $mysqli->insert_id;

                // Preparing a SQL UPDATE Statement for the CUSTOMER Table --------------------------------------------
                $customerUpdateStatement = $mysqli->prepare(
                    "UPDATE account SET customerID = ? WHERE accountID = ?"
                );

                // Bind the VALUES Parameters for the CUSTOMER Table SQL statement
                $customerUpdateStatement->bind_param("ii", $obtainedCustomerID, $obtainedAccountID);

                if ($customerUpdateStatement->execute()) {
                    echo "<p id=\"successMessage\">Account created!</p>";
                } else {
                    echo "Error: " . $customerUpdateStatement->error;
                }

                $customerStatement->close();
                $accountStatement->close();
                $customerUpdateStatement->close();
            }

            // Close the connection
            $emailCheckStatement->close();
            $mysqli->close();
        }
        ?>

            <div class="mb-3">
                <label for="fullname" >Name</label> 
                <input id="entryBox" name="first_name" required="" type="text" placeholder="Input your First Name" />
                <input id="entryBox" name="last_name" required="" type="text" placeholder="Input your Last Name" />
            </div>
            <div class="mb-3">
                <label for="username">Username</label>
                <input id="entryBox" name="username" required="" type="text" placeholder="Input your Username"  />
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input id="passwordInput" name="password" required="" type="password" placeholder="Input your Password" />
                <input id="checkBox" type="checkbox" onclick="revealPassword()"/> Show Password
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input id="entryBox" name="email" required="" type="email" placeholder="Input your Email Address" />
            </div>
            <div class="mb-3">
                <label for="phonenumber">Phone No.</label>
                <input id="entryBox" name="phoneNumber" required="" type="tel" placeholder="Input your Phone Number (+44)" pattern="^[0-9]{11}$" required />
            </div>
            <div class="mb-3">
                <label for="address">Address</label>
                <input id="entryBox" name="address" required="" type="text" placeholder="Input your Phone Number (+44)"  />
            </div>
            <input id="registerAccountButton" name="register_customer" type="submit" value="Register" />
            <div>
            </div>
        </form>
    </div>

    <!-- Password Toggle -->
    <script>
        function revealPassword() {
            var x = document.getElementById("passwordInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>