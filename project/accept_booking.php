<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['booking_id'])) {
    $bookingId = $data['booking_id'];

    $sql = "UPDATE bookings SET status = 'Accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking accepted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to accept booking.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();
?>
