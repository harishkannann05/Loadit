<?php
$servername = "localhost";  // Hostname
$username = "root";         // MySQL username
$password = "";             // MySQL password (empty for XAMPP)
$dbname = "booking_data";   // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
