<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if owner_id is provided
if (isset($_POST['owner_id'])) {
    $ownerId = $_POST['owner_id'];

    // Update the status to 'accepted'
    $updateQuery = "UPDATE owners SET status = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $ownerId);

    if ($stmt->execute()) {
        // Redirect back to the owner dashboard page after accepting
        header("Location: owner_dashboard.php?message=success");
        exit();
    } else {
        // If there was an error, redirect back with an error message
        header("Location: owner_dashboard.php?message=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
