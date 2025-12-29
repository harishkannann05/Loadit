<?php
// Start the session
session_start();

// Check if the owner is logged in
if (!isset($_SESSION['owner_name'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get owner name from session
$owner_name = $_SESSION['owner_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Font Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #fffaf0;
            color: #333;
        }

        /* Header Styling */
        header {
            background-color: #000;
            color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        header nav {
            display: flex;
            justify-content: flex-end; /* Aligning navbar content to the right */
            padding: 0 30px;
        }

        header .nav-links {
            display: flex;
            list-style-type: none;
        }

        header .nav-links li {
            margin-left: 40px;
        }

        header .nav-links li a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        header .nav-links li a:hover {
            color: #ff9900;
        }

        /* Owner Profile Section */
        .owner-profile {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 30px 50px 30px;
            background-color: #1a1a1a;
            color: #fff;
            position: relative;
        }

        .owner-img-container {
            margin-right: 40px;
        }

        .owner-img {
            font-size: 160px;
            color: #ff9900;
            background: #333;
            border-radius: 50%;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
        }

        .owner-info h1 {
            font-size: 36px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .owner-info p {
            font-size: 20px;
            color: #b0b0b0;
        }

        .owner-rating {
            font-size: 18px;
            margin-top: 15px;
            color: #ff9900;
        }

        /* Vehicle Stats Section */
        .stats {
            display: flex;
            justify-content: space-around;
            padding: 40px 30px;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-box {
            text-align: center;
            padding: 30px;
            background-color: #f2f2f2;
            border-radius: 12px;
            width: 30%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-box h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #1a1a1a;
        }

        .stat-box p {
            font-size: 28px;
            font-weight: 700;
            color: #000; /* Changed number color to black */
        }

        /* Vehicle Info Section */
        .vehicle-info {
            padding: 60px 30px;
            background-color: #f4f7f6;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .vehicle-info h3 {
            font-size: 32px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        /* Vehicle Cards */
        .vehicle-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            justify-items: center;
        }

        .vehicle-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 100%;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .vehicle-card h4 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .vehicle-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }

        /* Owner Earnings Section */
        .earnings-section {
            display: flex;
            justify-content: space-between;
            padding: 60px 30px;
            background-color: #fff;
            margin-bottom: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .earnings-box {
            width: 48%;
            background-color: #e6f7ff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .earnings-box:hover {
            transform: translateY(-5px);
        }

        .earnings-box h4 {
            font-size: 24px;
            font-weight: 600;
            color: #0044cc;
            margin-bottom: 15px;
        }

        .earnings-box p {
            font-size: 40px;
            font-weight: 700;
            color: #28a745;
        }

        /* Footer */
        footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 16px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <!-- <li><a href="ownerprofile.php">Profile</a></li> -->
                <li><a href="ownerlogin.php">Truck Owner</a></li>
                <li><a href="driverlogin.php">Driver</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Owner Profile Section -->
    <section class="owner-profile">
        <div class="owner-img-container">
            <span class="owner-img">👤</span> <!-- Owner Profile Icon -->
        </div>
        <div class="owner-info">
            <h1><?php echo htmlspecialchars($owner_name); ?></h1> <!-- Owner Name from Session -->
            <p>Vehicle Owner</p>
            <div class="owner-rating">
                <span>★★★★★</span> <small>4.8/5 (12 Reviews)</small>
            </div>
        </div>
    </section>

    <!-- Vehicle Stats Section -->
    <section class="stats">
        <div class="stat-box">
            <h3>Total Vehicles</h3>
            <p>5</p>
        </div>
        <div class="stat-box">
            <h3>Total Earnings</h3>
            <p>₹20,00,000</p>
        </div>
        <div class="stat-box">
            <h3>Total Transported Loads</h3>
            <p>1500 Loads</p>
        </div>
    </section>

    <!-- Vehicle Info Section -->
    <section class="vehicle-info">
        <h3>Vehicle Information</h3>
        <div class="vehicle-cards">
            <!-- Vehicle 1 -->
            <div class="vehicle-card">
                <h4>Tata Xenon</h4>
                <p><strong>Year:</strong> 2020</p>
                <p><strong>Engine Type:</strong> Diesel (150 HP)</p>
                <p><strong>Fuel Efficiency:</strong> 12 km/l</p>
                <p><strong>Load Capacity:</strong> 5 tons</p>
                <p><strong>Insurance Status:</strong> Valid until Dec 2025</p>
            </div>
            <!-- Vehicle 2 -->
            <div class="vehicle-card">
                <h4>Mahindra Scorpio</h4>
                <p><strong>Year:</strong> 2018</p>
                <p><strong>Engine Type:</strong> Diesel (130 HP)</p>
                <p><strong>Fuel Efficiency:</strong> 10 km/l</p>
                <p><strong>Load Capacity:</strong> 4 tons</p>
                <p><strong>Insurance Status:</strong> Valid until Nov 2025</p>
            </div>
            <!-- Vehicle 3 -->
            <div class="vehicle-card">
                <h4>Ford Ranger</h4>
                <p><strong>Year:</strong> 2019</p>
                <p><strong>Engine Type:</strong> Diesel (140 HP)</p>
                <p><strong>Fuel Efficiency:</strong> 11 km/l</p>
                <p><strong>Load Capacity:</strong> 4.5 tons</p>
                <p><strong>Insurance Status:</strong> Valid until Aug 2025</p>
            </div>
            <!-- Vehicle 4 -->
            <div class="vehicle-card">
                <h4>Isuzu D-Max</h4>
                <p><strong>Year:</strong> 2021</p>
                <p><strong>Engine Type:</strong> Diesel (160 HP)</p>
                <p><strong>Fuel Efficiency:</strong> 13 km/l</p>
                <p><strong>Load Capacity:</strong> 5 tons</p>
                <p><strong>Insurance Status:</strong> Valid until Jan 2026</p>
            </div>
            <!-- Vehicle 5 -->
            <div class="vehicle-card">
                <h4>Honda CRV</h4>
                <p><strong>Year:</strong> 2022</p>
                <p><strong>Engine Type:</strong> Petrol (170 HP)</p>
                <p><strong>Fuel Efficiency:</strong> 15 km/l</p>
                <p><strong>Load Capacity:</strong> 3 tons</p>
                <p><strong>Insurance Status:</strong> Valid until Mar 2026</p>
            </div>
        </div>
    </section>

    <!-- Earnings Section -->
    <section class="earnings-section">
        <div class="earnings-box">
            <h4>Total Earnings This Year</h4>
            <p>₹15,00,000</p>
        </div>
        <div class="earnings-box">
            <h4>Total Loads Transported</h4>
            <p>1200</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 LoadIt. All Rights Reserved.</p>
    </footer>

</body>
</html>
