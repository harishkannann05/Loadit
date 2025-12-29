<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pincode = $_POST['pincode'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists in the database
    $checkEmailQuery = "SELECT email FROM drivers WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, show error message
        echo "<script>alert('Error: Email already exists!');</script>";
        $stmt->close();
    } else {
        // Email doesn't exist, proceed with insert

        // Read file contents
        $aadhar = file_get_contents($_FILES['aadhar']['tmp_name']); // Aadhar Document
        $license = file_get_contents($_FILES['license']['tmp_name']); // License Document
        $photo = file_get_contents($_FILES['photo']['tmp_name']);     // Photo

        // Prepare SQL statement to insert data into the database
        $stmt = $conn->prepare("
            INSERT INTO drivers 
            (name, phone, email, password, pincode, aadhar, license, photo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssss", 
            $name, 
            $phone, 
            $email, 
            $hashed_password, // Store the hashed password
            $pincode, 
            $aadhar, // Binary content
            $license, // Binary content
            $photo    // Binary content
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Sign-up successful! Redirecting to dashboard.'); window.location.href = 'driverdashboard.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Sign-Up Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/owner.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="Load.itwhite.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <!-- <li><a href="driverdashboard.php">Profile</a></li> -->
            <li><a href="ownerlogin.php">Truck Owner</a></li>
            <li><a href="driverlogin.php">Driver</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <!-- Sign-Up Form -->
    <div class="container">
        <div class="form-container">
            <div class="heading-box">
                <h2>Driver Sign-Up</h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Driver Info</legend>
                    <input type="text" name="name" placeholder="Full Name (as per Aadhar card)" required>
                    <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="pincode" placeholder="Pincode with state name (e.g., Tamil Nadu 000-000)" required>
                </fieldset>

                <fieldset>
                    <legend>Upload Documents</legend>
                    <label for="aadhar">Upload Aadhar Document</label>
                    <input type="file" name="aadhar" accept="image/*, .pdf" required>
                    <label for="license">Upload your License</label>
                    <input type="file" name="license" accept="image/*" required>
                    <label for="photo">Upload your Photo</label>
                    <input type="file" name="photo" accept="image/*, .pdf" required>
                </fieldset>

                <button type="submit">Sign Up</button>
            </form>

            <div class="footer">
                <p>Already have an account? <a href="driverlogin.php">Login</a></p>
            </div>
        </div>
    </div>
    <script>
        document.body.style.background = "url('slider8.jpg') no-repeat center center fixed";
        document.body.style.backgroundSize = "cover";
        document.body.style.height = "100vh";
        document.body.style.backgroundAttachment = "fixed";
    </script>
</body>
</html>
