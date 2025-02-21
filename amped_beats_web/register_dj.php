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
    <link rel="stylesheet" type="text/css" href="styles/register_dj.css" />

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
        <form action="register_dj.php" method="post" >
        <a href="register.php" id="back-button" >Back</a>
        <h1>DJ Register</h1>

        <?php
        $alertMessage = "";

        // Connecting to the database
        include "db_connection.php";

        // Obtaining data from the POSTED Form
        if (isset($_POST["register_dj"])) {

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

                // Getting the Form Values for Disc Jockey Table
                $firstName = $_POST["first_name"];
                $lastName = $_POST["last_name"];
                $description = $_POST["description"];
                $genre = $_POST["genre"];
                $type = $_POST["dj_type"];

                // Preparing a SQL statement for the DISC JOCKEY Table --------------------------------------------
                $discjockeyStatement = $mysqli->prepare(
                    "INSERT INTO discjockey (accountID, firstName, lastName, description, genre, type) VALUES (?, ?, ?, ?, ?, ?)"
                );

                // Bind the VALUES Parameters for the DISC JOCKEY Table SQL statement
                $discjockeyStatement->bind_param("ssssss", $obtainedAccountID, $firstName, $lastName, $description, $genre, $type);

                // Execute the Customer Table INSERT INTO SQL statement
                if ($discjockeyStatement->execute() == false) {
                    echo "Error: " . $discjockeyStatement->error;
                    exit();
                }

                // Obtaining the Last Inserted accountID of the Recently Inserted Account  --------------------------------------------
                $obtainedDiscJockeyID = $mysqli->insert_id;

                // Preparing a SQL UPDATE Statement for the DISC JOCKEY Table --------------------------------------------
                $discjockeyUpdateStatement = $mysqli->prepare(
                    "UPDATE account SET discjockeyID = ? WHERE accountID = ?"
                );

                // Bind the VALUES Parameters for the DISC JOCKEY Table SQL statement
                $discjockeyUpdateStatement->bind_param("ii", $obtainedDiscJockeyID, $obtainedAccountID);

                if ($discjockeyUpdateStatement->execute()) {
                    echo "<p id=\"successMessage\">Account created!</p>";
                } else {
                    echo "Error: " . $accountStatement->error;
                }

                
            }

            
            // Close the connection
            $emailCheckStatement->close();
            $discjockeyStatement->close();
            $accountStatement->close();
            $discjockeyUpdateStatement->close();
            $mysqli->close();
        }
        ?>

            <div class="mb-3" id="formContainerSection">
                <label for="fullname" >Name</label> 
                <input id="entryBox" name="first_name" required="" type="text" placeholder="Input your First Name" />
                <input id="entryBox" name="last_name" required="" type="text" placeholder="Input your Last Name" />
            </div>
            <div class="mb-3" id="formContainerSection">
                <label for="username">Username</label>
                <input id="entryBox" name="username" required="" type="text" placeholder="Input your Username"  />
            </div>
            <div class="mb-3" id="formContainerSection">
                <label for="password">Password</label>
                <input id="passwordInput" name="password" required="" type="password" placeholder="Input your Password" />
                <input id="checkBox" type="checkbox" onclick="revealPassword()"/> Show Password
            </div>
            <div class="mb-3" id="formContainerSection">
                <label for="email">Email</label>
                <input id="entryBox" name="email" required="" type="email" placeholder="Input your Email Address" />
            </div>
            <div class="mb-3" id="formContainerSection">
                <label for="phonenumber">Phone No.</label>
                <input id="entryBox" name="phoneNumber" required="" type="tel" placeholder="Input your Phone Number (+44)" pattern="^[0-9]{11}$" required />
            </div>
            <div class="mb-3" id="formContainerSection">
                <label for="address">Address</label>
                <input id="entryBox" name="address" required="" type="text" placeholder="Input your Phone Number (+44)"  />
            </div>
            <div id="formContainerSection">
                <h2 id="descriptionTitle">About You</h2>
                <textarea name="description" placeholder="Tell us about who you are as a DJ..." rows="4"></textarea>
            </div>
            <div id="dropDownSection">
                <div>
                    <label for="genre">Genre</label>
                    <select name="genre" required>
                        <option value="Disco">Disco</option>
                        <option value="EDM">EDM</option>
                        <option value="Hip Hop">Hip Hop</option>
                        <option value="UK Drill">UK Drill</option>
                        <option value="Pop">Pop</option>
                        <option value="Techno">Techno</option>
                        <option value="Rock">Rock</option>
                        <option value="RnB">RnB</option>
                    </select>
                    <label for="dj_type">Type</label>
                    <select name="dj_type" required>
                        <option value="Concert">Concert</option>
                        <option value="Wedding">Wedding</option>
                        <option value="Store Event">Store Event</option>
                        <option value="Club">Club</option>
                        <option value="Birthday">Birthday</option>
                        <option value="Kids Party">Kids Party</option>
                        <option value="Prom">Prom</option>
                        <option value="Bar Mitzvah">Bar Mitzvah</option>
                    </select>
                </div>
            </div>
            <input id="registerAccountButton" name="register_dj" type="submit" value="Register" />
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