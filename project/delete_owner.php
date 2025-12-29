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

    // Delete the owner from the database
    $deleteQuery = "DELETE FROM owners WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $ownerId);

    if ($stmt->execute()) {
        // After deletion, redirect back to the owner dashboard page with a success message
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
