<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$driver_name = $_SESSION['driver_name']; // Get the driver's name from session

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

// Fetch driver details from the database
$driver_id = $_SESSION['driver_id']; // Use driver id from session
$stmt = $conn->prepare("SELECT * FROM drivers WHERE id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $driver_data = $result->fetch_assoc();
} else {
    echo "No driver found.";
}

$stmt->close();

// Fetch vehicle details from the database (assuming a `vehicle_info` table exists)
$vehicle_stmt = $conn->prepare("SELECT * FROM drivers WHERE name = ?");
$vehicle_stmt->bind_param("i", $driver_id);
$vehicle_stmt->execute();
$vehicle_result = $vehicle_stmt->get_result();
$vehicle_data = $vehicle_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Font Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fffaf0;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #000;
            color: #fff;
            padding: 15px 0;
        }

        header nav {
            display: flex;
            justify-content: flex-end; /* Aligning content to the right */
            padding: 0 20px;
        }

        header .nav-links {
            display: flex;
            list-style-type: none;
        }

        header .nav-links li {
            margin-right: 20px;
        }

        header .nav-links li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header .nav-links li a:hover {
            color: #ff9900;
        }

        /* Profile Header Section */
        .profile-header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-img-container {
            margin-right: 20px;
        }

        .profile-img {
            font-size: 150px;
            color: #0044cc; /* Set the icon color */
        }

        .profile-info {
            background-color: #e6f7ff; /* Light blue background */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .profile-info h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 18px;
            color: #555;
        }

        .rating {
            font-size: 16px;
            color: #f39c12;
        }

        /* Stats Section */
        .stats {
            display: flex;
            justify-content: space-around;
            padding: 40px 20px;
            background-color: #fff;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
            background-color: #e6f7ff;
            border-radius: 10px;
            width: 25%;
        }

        .stat-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 22px;
            font-weight: bold;
            color: #0044cc; /* Slight blue color */
        }

        /* Reviews Section */
        .reviews {
            padding: 30px 20px;
            background-color: #fff;
        }

        .reviews h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .review {
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .review .reviewer-img {
            font-size: 40px; /* Icon size */
            color: #0044cc;
            margin-right: 15px;
        }

        .review .reviewer-info {
            font-weight: bold;
        }

        .review .review-text {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }

        .review .rating {
            color: #f39c12;
        }

        /* Vehicle Info Section */
        .vehicle-info {
            padding: 30px 20px;
            background-color: #fff;
            margin-bottom: 30px;
        }

        .vehicle-info h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .vehicle-details {
            display: flex;
            align-items: center;
        }

        .vehicle-img {
            font-size: 50px;
            margin-right: 20px;
            color: #0044cc;
        }

        .vehicle-info-text p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="userlogin.php">user</a></li>
                <li><a href="ownerlogin.php">Truck Owner</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Profile Header Section -->
    <section class="profile-header">
        <div class="profile-img-container">
            <span class="profile-img">👤</span>
        </div>
        <div class="profile-info">
            <h1><?php echo $driver_name; ?></h1> <!-- Display logged-in driver's name -->
            <p>Driver</p>
            <div class="rating">
                <span>★★★★★</span> <small>4.8/5 (4 Reviews)</small> <!-- Adjusted review count -->
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-box">
            <h3>Total Distance</h3>
            <p>1,250 km</p>
        </div>
        <div class="stat-box">
            <h3>Total Earnings</h3>
            <p>₹3,50,000</p>
        </div>
        <div class="stat-box">
            <h3>Transported Loads</h3>
            <p>350 Loads</p>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="reviews">
        <h3>Customer Reviews</h3>
        <div class="review">
            <div class="reviewer-img">👤</div> <!-- Reviewer icon -->
            <div class="reviewer-info">
                <strong>Vijay</strong> - ★★★★★
                <div class="review-text">"Excellent service! Rajesh was prompt and professional."</div>
            </div>
        </div>
        <div class="review">
            <div class="reviewer-img">👤</div> <!-- Reviewer icon -->
            <div class="reviewer-info">
                <strong>Priya</strong> - ★★★★☆
                <div class="review-text">"Very reliable, though I wish the ride was a bit smoother."</div>
            </div>
        </div>
        <div class="review">
            <div class="reviewer-img">👤</div> <!-- Reviewer icon -->
            <div class="reviewer-info">
                <strong>Saravanan</strong> - ★★★★★
                <div class="review-text">"Great driver, made the journey comfortable!"</div>
            </div>
        </div>
        <div class="review">
            <div class="reviewer-img">👤</div> <!-- Reviewer icon -->
            <div class="reviewer-info">
                <strong>Ravi</strong> - ★★★★☆
                <div class="review-text">"Good experience overall, will use again."</div>
            </div>
        </div>
    </section>

    <!-- Vehicle Info Section -->
    <section class="vehicle-info">
        <h3>Vehicle Information</h3>
        <div class="vehicle-details">
            <div class="vehicle-img">🚚</div> <!-- Vehicle icon replaced -->
            <div class="vehicle-info-text">
                <p><strong>Make:</strong> Tata</p>
                <p><strong>Model:</strong> Xenon</p>
                <p><strong>License Plate:</strong> TN-10-AB-1234</p>
                <p><strong>Vehicle Type:</strong> Heavy-duty</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Your Company. All Rights Reserved.</p>
    </footer>
</body>
</html>
