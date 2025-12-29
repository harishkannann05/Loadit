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

// Handle Accept request
if (isset($_POST['accept_driver'])) {
    $driverId = $_POST['driver_id'];
    
    // Update the status to 'accepted'
    $stmt = $conn->prepare("UPDATE drivers SET status = 'accepted' WHERE id = ?");
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $stmt->close();
}

// Handle Remove request
if (isset($_POST['remove_driver'])) {
    $driverId = $_POST['driver_id'];
    
    // Delete the driver from the database
    $stmt = $conn->prepare("DELETE FROM drivers WHERE id = ?");
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $stmt->close();
}

// Fetch all drivers from the database
$sql = "SELECT * FROM drivers";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fffaf0;
            color: #333;
        }

        .navbar {
            background-color: #000;
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
        }

        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 18px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 36px;
            color: black;
        }

        .driver-table {
            width: 100%;
            border-collapse: collapse;
        }

        .driver-table th, .driver-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .driver-table th {
            background-color: #f4f4f9;
        }

        .actions {
            display: flex;
            gap: 10px; /* Space between buttons */
            justify-content: flex-start; /* Align to the left */
        }

        .remove-btn, .accept-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 20px;
            cursor: pointer;
            margin-right: 10px;
        }

        .accept-btn {
            background-color: green;
        }

        .remove-btn:hover {
            background-color: #cc0000;
        }

        .accept-btn:hover {
            background-color: #006400;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <img src="Load.itwhite.png" alt="LoadIt">
        </div>
        <div class="nav-links">
            <a href="index1.php">Home</a>
            <a href="view_bookings.php">Load</a>
            <a href="owner_dashboard.php">Truck Owner</a>
            <a href="drivercheck.php">Driver</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Driver Management</h1>
        </div>

        <!-- Display the table of drivers -->
        <?php if ($result->num_rows > 0): ?>
            <table class="driver-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr id="driver-<?php echo $row['id']; ?>">
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="actions">
                                <!-- Accept button -->
                                <?php if ($row['status'] == 'pending'): ?>
                                    <form method="POST">
                                        <input type="hidden" name="driver_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="accept_driver" class="accept-btn">Accept</button>
                                    </form>
                                <?php else: ?>
                                    <button class="accept-btn" disabled>Accepted</button>
                                <?php endif; ?>

                                <!-- Remove button -->
                                <form method="POST" onsubmit="return confirm('Are you sure you want to remove this driver?')">
                                    <input type="hidden" name="driver_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="remove_driver" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No drivers found.</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; LoadIt. All Rights Reserved.</p>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
