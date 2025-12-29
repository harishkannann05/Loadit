<?php
// Start the session
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root"; // Default phpMyAdmin username
$password = "";     // Default password (often empty for localhost)
$dbname = "booking_data"; // Name of the database

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, name, email, password FROM owners WHERE name = ? AND email = ?");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_name, $db_email, $hashed_password);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Store user data in session
            $_SESSION['owner_id'] = $id;
            $_SESSION['owner_name'] = $db_name;
            $_SESSION['owner_email'] = $db_email;

            // Redirect to the owner dashboard after successful login
            header("Location: ownerdashboard.php");
            exit(); // Ensure no further code is executed
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No owner found with this name and email.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="Load.itwhite.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <!-- <li><a href="ownerprofile.php">Profile</a></li> -->
            <li><a href="ownersign.php">Truck Owner</a></li>
            <li><a href="driverlogin.php">Driver</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <div class="container">
        <div class="form-container">
            <div class="heading-box">
                <h2>Owner Login</h2>
            </div>
            
            <!-- Display error message if login fails -->
            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <fieldset>
                    <legend>Owner Info</legend>
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                </fieldset>

                <button type="submit">Login</button>
            </form>

            <div class="footer">
                <p>You don't have an account? <a href="ownersign.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
