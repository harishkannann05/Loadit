<?php
header("Content-Type: application/json");

// Database connection credentials
$host = 'localhost';
$db = 'mapbase';
$user = 'your_username';  // Replace with your MySQL username
$pass = 'your_password';  // Replace with your MySQL password

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve data from POST request
    $device_id = $_POST['device_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Insert the data into the gps_data table
    $stmt = $pdo->prepare("INSERT INTO gps_data (device_id, latitude, longitude) VALUES (?, ?, ?)");
    $success = $stmt->execute([$device_id, $latitude, $longitude]);

    // Return a JSON response
    echo json_encode(["status" => $success ? "success" : "error"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
