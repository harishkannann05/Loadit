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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .card-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            flex: 1;
            padding: 20px;
            background-color:rgb(238, 219, 180);
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #777;
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

    <!-- Container for Cards -->
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
        </div>

        <!-- Three Cards in a Row -->
        <div class="card-container">
            <!-- Bookings Card -->
            <div class="card" onclick="window.location.href='view_bookings.php';">
                <h3>Bookings</h3>
                <p>View and manage all booking details.</p>
            </div>

            <!-- Drivers Card -->
            <div class="card" onclick="window.location.href='drivercheck.php';">
                <h3>Drivers</h3>
                <p>Manage driver information and status.</p>
            </div>

            <!-- Owners Card -->
            <div class="card" onclick="window.location.href='owner_dashboard.php';">
                <h3>Owners</h3>
                <p>Manage truck owners and their details.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; LoadIt. All Rights Reserved.</p>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
