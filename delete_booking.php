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

// Get the booking ID from POST data
$booking_id = $_POST['booking_id'];

// Delete the booking from the database
$sql = "DELETE FROM bookings WHERE id = ?";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);

// Execute the query
if ($stmt->execute()) {
    echo "Booking removed successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();

// Redirect back to the bookings list
header("Location: view_bookings.php");
exit();
?>
