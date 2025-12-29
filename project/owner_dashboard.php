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

// Fetch all owners from the database
$sql = "SELECT * FROM owners";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <style>
        /* CSS Styling */
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
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success {
            background-color: #4CAF50;
            color: white;
        }
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f9;
        }
        .action-btns {
            display: flex;
            gap: 10px; /* Space between buttons */
            align-items: center;
        }
        .remove-btn, .accept-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
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
    </style>
</head>
<body>
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
        <!-- Check for success or error messages -->
        <?php
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            if ($message == 'success') {
                echo "<div class='alert alert-success'>Operation was successful.</div>";
            } elseif ($message == 'error') {
                echo "<div class='alert alert-danger'>Error in operation.</div>";
            }
        }
        ?>

        <h1>Owner Dashboard</h1>

        <!-- Display the table of owners -->
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <!-- Show current status -->
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>
                            <td class="action-btns">
                                <!-- Remove button -->
                                <form method="POST" action="delete_owner.php" onsubmit="return confirm('Are you sure you want to delete this owner?')">
                                    <input type="hidden" name="owner_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>

                                <!-- Accept button (only if status is 'pending') -->
                                <?php if ($row['status'] == 'pending'): ?>
                                    <form method="POST" action="update_owner_status.php">
                                        <input type="hidden" name="owner_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="accept-btn">Accept</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No owners found.</p>
        <?php endif; ?>

    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
