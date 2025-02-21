<?php
session_start();
// Connecting to the database
include "db_connection.php";

$customerID = $_SESSION["customerID"];
$successMessage = "";
$errorMessage = "";

// Fetch customer details if ID is provided
if ($customerID) {
    $query = "SELECT customer.customerID, customer.firstName, customer.lastName, account.username, account.email, account.phone, account.address 
              FROM customer customer
              JOIN account account ON customer.accountID = account.accountID
              WHERE customer.customerID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        die("Customer not found!");
    }
} else {
    die("Invalid request!");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerID = $_POST["customerID"];
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $address = $_POST["address"];

    // Update customer table
    $updateCustomerQuery = "UPDATE customer SET firstName = ?, lastName = ? WHERE customerID = ?";
    $stmt1 = $mysqli->prepare($updateCustomerQuery);
    $stmt1->bind_param("ssi", $firstName, $lastName, $customerID);
    $stmt1->execute();

    // Update account table
    $updateAccountQuery = "UPDATE account SET username = ?, email = ?, phone = ?, address = ? WHERE accountID = (SELECT accountID FROM customer WHERE customerID = ?)";
    $stmt2 = $mysqli->prepare($updateAccountQuery);
    $stmt2->bind_param("ssssi", $username, $email, $phoneNumber, $address, $customerID);
    $stmt2->execute();

    if ($stmt1->affected_rows > 0 || $stmt2->affected_rows > 0) {
        $successMessage = "Customer information updated successfully!";
    } else {
        $errorMessage = "No changes were made or an error occurred.";
    }

    // Refresh customer data
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
}
?>

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
    
    <!-- Bootstrap Library Links for CSS and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles/account_management.css" />
</head>
<body>

<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index1.php">
            <span id="logoText">Amped Beats</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="about_us1.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="services1.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="reviews">Reviews</a></li>
            </ul>
           
            <!-- Logout Button -->
            <form class="navbar-form" action="customer_dashboard.php" method="post">
                <button class="btn btn-primary ms-md-2" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

    <div class="container">
        <h2>Edit Customer Information</h2>

        <?php if ($successMessage): ?>
            <p class="alert alert-success"><?php echo $successMessage; ?></p>
        <?php elseif ($errorMessage): ?>
            <p class="alert alert-danger"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form id="form_main" method="post">
            <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>">

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $customer['firstName']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $customer['lastName']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $customer['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $customer['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Phone Number</label>
                <input type="tel" name="phoneNumber" class="form-control" value="<?php echo $customer['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $customer['address']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="customer_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php $mysqli->close(); ?>