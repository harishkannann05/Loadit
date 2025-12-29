<?php
session_start();

// Check if the owner is logged in
if (!isset($_SESSION['owner_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve the owner's name from the session
$owner_name = $_SESSION['owner_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar styling */
        .navbar {
            background-color: #222;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        /* Logo styling */
        .logo img {
            height: 35px; /* Adjust size as needed */
            width: auto;
        }

        /* Nav links styling */
        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .nav-links li a:hover {
            color: #ddd;
        }

        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Blurred background */
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('background image dash.webp') no-repeat center center fixed;
            background-size: cover;
            filter: blur(8px);
            z-index: -1;
        }

        /* Main content */
        .container {
            position: relative;
            z-index: 1;
            color: #ffffff;
        }

        .dashboard-card {
            box-shadow: 0 4px 6px rgb(88, 85, 85);
            border-radius: 10px;
            overflow: hidden;
        }

        .profile-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="Load.itwhite.png" style="height: 30px; width: 90px;" alt="Logo">
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="ownerdashboard.php">Profile</a></li>
                <li><a href="ownersign.php">Truck Owner</a></li>
                <li><a href="driverlogin.php">Driver</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>
    <!-- Blurred Background -->
    <div class="background-image"></div>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Profile Section -->
        <div class="profile-container">
            <img src="dashboard image.png" alt="Profile Picture" class="profile-picture">
            <h2 class="mt-3">Welcome <?php echo htmlspecialchars($owner_name); ?></h2> <!-- Display owner name -->
        </div>

        <!-- Dashboard Section -->
        <h1 class="text-center mb-4"></h1>
        <div class="row g-4">
            <!-- Card 1: Active Loads -->
            <div class="col-md-4">
                <a href="ownermap.html" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Active Loads</h5>
                            <p class="card-text">One active trip at the moment & Locate your truck.</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card 2: Load History -->
            <div class="col-md-4">
                <a href="loadhistoryowner.html" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Load History</h5>
                            <p class="card-text">You have completed 3 trips this month.</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card 3: Bookings Under Review -->

            <div class="col-md-4">
                <a href="ownerprofile.php" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text">Click here to view</p>
                        </div>
                    </div>
                </a>
            </div>


            <!-- Card 4: Money Saved -->
            <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Wallet Balance</h5>
                            <p class="card-text">You have saved: ₹6000</p>
                        </div>
                    </div>
            </div>
            <!-- Card 5: Profile Settings -->
            <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Maintenance</h5>
                            <p class="card-text">Next service at 28p.2.2025. Update your personal details and preferences.</p>
                        </div>
                    </div>
            </div>
            <!-- Card 6: Update Settings -->

            <div class="col-md-4">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Waiting Orders</h5>
                            <p class="card-text">You have 2 trips under review.</p>
                        </div>
                    </div>
            </div>

            
        </div>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
