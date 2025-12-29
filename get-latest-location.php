<?php
header("Content-Type: application/json");

// Database connection credentials
$host = 'localhost';
$db = 'mapbase';
$user = 'your_username';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get device ID from the request
    $device_id = $_GET['device_id'];

    // Query the latest GPS location for the device
    $stmt = $pdo->prepare("SELECT latitude, longitude, timestamp FROM gps_data WHERE device_id = ? ORDER BY timestamp DESC LIMIT 1");
    $stmt->execute([$device_id]);

    $location = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($location);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
