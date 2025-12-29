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

// Initialize messages
$message = "";
$message_type = ""; // success or danger

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $pincode = $_POST['pincode'];
    $vnum = $_POST['vnum'];
    $vname = $_POST['vname'];
    $load1 = $_POST['load1'];
    $yn = $_POST['yn'];
    $uname = $_POST['uname'];

    // Check if email already exists in the database
    $checkEmailQuery = "SELECT email FROM owners WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, set error message
        $message = "Error: Email already exists!";
        $message_type = "danger"; // Bootstrap class for error
        $stmt->close();
    } else {
        // Email doesn't exist, proceed with insert

        // Read file contents
        $vage = file_get_contents($_FILES['vage']['tmp_name']); // Vehicle Age Document
        $vpic = file_get_contents($_FILES['vpic']['tmp_name']); // Vehicle Picture
        $rc = file_get_contents($_FILES['rc']['tmp_name']);     // RC Document

        // Prepare SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO owners (name, fname, phone, email, password, pincode, vnum, vname, load1, yn, uname, vage, vpic, rc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssssssssssss", 
            $name, 
            $fname, 
            $phone, 
            $email, 
            $password, // Store hashed password
            $pincode, 
            $vnum, 
            $vname, 
            $load1, 
            $yn, 
            $uname, 
            $vage, // Binary content
            $vpic, // Binary content
            $rc    // Binary content
        );

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to owner dashboard after successful signup
            header("Location: ownerdashboard.php");
            exit(); // Ensure no further code is executed after redirection
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "danger";
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
    <title>Owner SignUp Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/owner.css">
    <style>
        .alert {
            width: 100%;
            margin: 0; /* Remove margins */
            border-radius: 0; /* Remove rounded edges */
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
            <!-- <li><a href="ownerdashboard.php">Profile</a></li> -->
            <li><a href="ownersign.php">Truck Owner</a></li>
            <li><a href="driverlogin.php">Driver</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

    <!-- Display Alert If Message Exists -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Sign Up Form -->
    <div class="container">
        <div class="form-container">
            <div class="heading-box">
                <h2>Sign Up</h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Owner Info</legend>
                    <input type="text" name="name" placeholder="Full Name (as per Aadhar card)" required>
                    <input type="text" name="fname" placeholder="Father's Name" required>
                    <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="pincode" placeholder="Pincode with state name (e.g., Tamil Nadu 000-000)" required>
                </fieldset>

                <fieldset>
                    <legend>Vehicle Details</legend>
                    <input type="text" name="vnum" placeholder="Vehicle No." required>
                    <input type="text" name="vname" placeholder="Vehicle Name & Model" required>
                    <input type="text" name="load1" placeholder="Truck Load Capacity (e.g., 10 ton)" required>
                </fieldset>

                <fieldset>
                    <legend>Upload Documents</legend>
                    <label for="vage">Upload Vehicle Age Document</label>
                    <input type="file" name="vage" accept="image/*, .pdf" required>
                    <label for="vpic">Upload your Truck Photo</label>
                    <input type="file" name="vpic" accept="image/*" required>
                    <label for="rc">Upload your RC Document</label>
                    <input type="file" name="rc" accept="image/*, .pdf" required>
                </fieldset>

                <fieldset>
                    <legend>Driver Info</legend>
                    <input type="text" name="yn" placeholder="Do you have a driver? (Yes/No)" required>
                    <input type="text" name="uname" placeholder="If yes, enter driver username">
                </fieldset>

                <button type="submit">Sign Up</button>
            </form>

            <div class="footer">
                <p>Already have an account? <a href="ownerlogin.php">Login</a></p>
            </div>
        </div>
    </div>
    <script>
        document.body.style.background = "url('slider8.jpg') no-repeat center center fixed";
        document.body.style.backgroundSize = "cover";
        document.body.style.height = "100vh";
        document.body.style.backgroundAttachment = "fixed";
    </script>
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
