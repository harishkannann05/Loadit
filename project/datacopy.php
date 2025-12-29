<?php
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

// Check if form data has been posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email already exists! Please use a different email.'); window.history.back();</script>";
    } else {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        // Check for successful insertion
        if ($stmt->execute()) {
            // Redirect to user dashboard page after successful sign-up
            header("Location: book.html");
            exit();  // Make sure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $checkEmail->close();
}

// Close the database connection
$conn->close();
?>
