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
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_name, $hashed_password);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Store user data in session
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $db_name;

            // Redirect to the user dashboard after successful login
            header("Location: userdashboard.php");
            exit(); // Ensure no further code is executed
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this name.";
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
    <title>User Login</title>
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
            <li><a href="userdashboard.php">Profile</a></li>
            <li><a href="owenersign.php">Truck Owner</a></li>
            <li><a href="driversign.php">Driver</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <div class="container">
        <div class="form-container">
            <div class="heading-box">
                <h2>User Login</h2>
            </div>
            
            <!-- Display error message if login fails -->
            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <fieldset>
                    <legend>User Info</legend>
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Gmail" required>
                    <input type="password" name="password" placeholder="Password" required>
                </fieldset>

                <button type="submit">Login</button>
            </form>

            <div class="footer">
                <p>You don't have an account? <a href="signupcopy.html">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
