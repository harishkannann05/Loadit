<?php
// Initialize variables for error message and redirect
$error_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hardcoded credentials for admin
    $admin_name = "admin";
    $admin_password = "admin";  // You can change this to your desired password
    
    // Capture form inputs
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Validate login credentials
    if ($name === $admin_name && $password === $admin_password) {
        // Redirect to admin page (index1.php)
        header('Location: index1.php');
        exit();
    } else {
        // If login fails, set error message
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/user.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fffaf0;
        }
        </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="Load.itwhite.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="userdashboard.html">Profile</a></li>
            <li><a href="owenersign.html">Truck Owner</a></li>
            <li><a href="driverlogin.html">Driver</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <div class="container">
        <div class="form-container">
            <div class="heading-box">
                <h2>Admin Login</h2>
            </div>
            
            <!-- Display error message if login fails -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <fieldset>
                    <legend>Admin Info</legend>
                    <input type="text" name="name" placeholder="Admin Name" required>
                    <input type="password" name="password" placeholder="Password" required>
                </fieldset>

                <button type="submit">Login</button>
            </form>

            
        </div>
    </div>
</body>
</html>
