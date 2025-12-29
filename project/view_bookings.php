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

// Fetch all bookings from the database
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
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

        .booking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .booking-table th, .booking-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .booking-table th {
            background-color: #f4f4f9;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }

        .remove-btn, .accept-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 20px;
            cursor: pointer;
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
            <h1>Booking Details</h1>
        </div>

        <!-- Display the table of bookings -->
        <?php if ($result->num_rows > 0): ?>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Sender Name</th>
                        <th>Receiver Name</th>
                        <th>From Address</th>
                        <th>To Address</th>
                        <th>Truck Type</th>
                        <th>Goods Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr id="booking-<?php echo $row['id']; ?>">
                            <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['from_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['to_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['truck_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['goods_type']); ?></td>
                            <td id="status-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="actions">
                                <form method="POST" action="delete_booking.php" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                                <button class="accept-btn" id="accept-<?php echo $row['id']; ?>" onclick="acceptBooking(<?php echo $row['id']; ?>)">Accept</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>

    </div>

    <div class="footer">
        <p>&copy; LoadIt. All Rights Reserved.</p>
    </div>

    <script>
    function acceptBooking(bookingId) {
        const acceptBtn = document.getElementById('accept-' + bookingId);
        const statusCell = document.getElementById('status-' + bookingId);

        // Disable the button and update UI
        acceptBtn.textContent = 'Accepted';
        acceptBtn.style.backgroundColor = '#4CAF50';
        acceptBtn.disabled = true;

        // Send AJAX request to update the status in the database
        fetch('accept_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusCell.textContent = 'Accepted';
                console.log('Booking accepted successfully!');
            } else {
                console.log('Failed to accept booking.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    </script>

</body>
</html>

<?php
$conn->close();
?>
