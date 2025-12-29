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

// Get the raw POST data and decode it
$inputData = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
if ($inputData) {
    $senderName = $conn->real_escape_string($inputData['senderName']);
    $senderPhone = $conn->real_escape_string($inputData['senderPhone']);
    $receiverName = $conn->real_escape_string($inputData['receiverName']);
    $receiverPhone = $conn->real_escape_string($inputData['receiverPhone']);
    $fromAddress = $conn->real_escape_string($inputData['fromAddress']);
    $toAddress = $conn->real_escape_string($inputData['toAddress']);
    $date = $conn->real_escape_string($inputData['date']);
    $truckType = $conn->real_escape_string($inputData['truckType']);
    $goodsType = $conn->real_escape_string($inputData['goodsType']);
    $truckLoadType = $conn->real_escape_string($inputData['truckLoadType']);
    $tonnage = $conn->real_escape_string($inputData['tonnage']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (sender_name, sender_phone, receiver_name, receiver_phone, from_address, to_address, booking_date, truck_type, goods_type, truck_load_type, tonnage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $senderName, $senderPhone, $receiverName, $receiverPhone, $fromAddress, $toAddress, $date, $truckType, $goodsType, $truckLoadType, $tonnage);

    // Execute the query
    if ($stmt->execute()) {
        echo "Booking saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
} else {
   // echo "Invalid data received!";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary</title>
    <link rel="stylesheet" href="css/summary.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <img src="Load.itwhite.png" alt="Logo">
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="userdashboard.php">Profile</a></li>
                <li><a href="owenersign.html">Truck Owner</a></li>
                <li><a href="driverlogin.html">Driver</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <h1>Booking Summary</h1>

    <main>
        <!-- Combined Card -->
        <div class="card1">
            <div class="card-image"></div>
            <div class="card-content">
                <!-- Truck Load Type Selection -->
                <h2>Select Truck Load Type</h2>
                <label>
                    <input type="radio" name="truckLoadType" value="Open" onclick="setTruckLoadType('Open')"> Open
                </label>
                <label>
                    <input type="radio" name="truckLoadType" value="Closed" onclick="setTruckLoadType('Closed')"> Closed
                </label>

                <!-- Tonnage Selection -->
                <h2>Select Tonnage</h2>
                <select id="tonnage-dropdown" onchange="setTonnage()">
                    <option value="" disabled selected>Select tonnage</option>
                    <option value="5 Tons">5 Tons</option>
                    <option value="10 Tons">10 Tons</option>
                    <option value="15 Tons">15 Tons</option>
                    <option value="20 Tons">20 Tons</option>
                    <option value="25 Tons">25 Tons</option>
                </select>
            </div>
        </div>
    </main>
    
    <main>
        <div class="card">
            <div class="card-image"></div>
            <div class="card-content">
                <!-- <h2>Your Booking Details</h2> -->
                <div id="summary-details"></div><br>
                <div class="button-container">
                    <button onclick="goBack()">Back</button>
                    <button onclick="confirmAction()">Proceed payment</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let truckLoadType = "";
        let tonnage = "";
        let truckType = ""; // Variable for Truck Type
        let goodsType = ""; // Variable for Goods Type
    
        // Function to set the Truck Load Type and update the summary
        function setTruckLoadType(selectedType) {
            truckLoadType = selectedType;
            updateSummary();
        }
    
        // Function to set the Tonnage and update the summary
        function setTonnage() {
            const dropdown = document.getElementById("tonnage-dropdown");
            tonnage = dropdown.value;
            updateSummary();
        }
    
        // Function to update the booking summary details dynamically
        function updateSummary() {
            // Retrieve booking details from local storage or use default values
            const senderName = localStorage.getItem("senderName") || "John Doe";
            const senderPhone = localStorage.getItem("senderPhone") || "1234567890";
            const receiverName = localStorage.getItem("receiverName") || "Jane Doe";
            const receiverPhone = localStorage.getItem("receiverPhone") || "0987654321";
            const fromAddress = localStorage.getItem("fromAddress") || "123 From Street";
            const toAddress = localStorage.getItem("toAddress") || "456 To Avenue";
            const date = localStorage.getItem("date") || "2024-11-15";
    
            // Retrieve Truck Type and Goods Type from local storage or use default values
            truckType = localStorage.getItem("truckType") || "Not Specified";
            goodsType = localStorage.getItem("loadType") || "Not Selected"; // Retrieve Goods Type
    
            // Update the summary details on the page
            const summaryDiv = document.getElementById("summary-details");
            summaryDiv.innerHTML = `
                <h2>Your Booking Details</h2>
                <p><strong>Sender Name:</strong> ${senderName}</p>
                <p><strong>Sender Phone:</strong> ${senderPhone}</p>
                <p><strong>Receiver Name:</strong> ${receiverName}</p>
                <p><strong>Receiver Phone:</strong> ${receiverPhone}</p>
                <p><strong>From Address:</strong> ${fromAddress}</p>
                <p><strong>To Address:</strong> ${toAddress}</p>
                <p><strong>Date:</strong> ${date}</p>
                <p><strong>Truck Type:</strong> ${truckType}</p>
                <p><strong>Goods Type:</strong> ${goodsType}</p>
                <p><strong>Truck Load Type:</strong> ${truckLoadType || "Not Selected"}</p>
                <p><strong>Tonnage:</strong> ${tonnage || "Not Selected"}</p>
            `;
        }

        function saveToDatabase() {
    const data = {
        senderName: localStorage.getItem("senderName") || "John Doe",
        senderPhone: localStorage.getItem("senderPhone") || "1234567890",
        receiverName: localStorage.getItem("receiverName") || "Jane Doe",
        receiverPhone: localStorage.getItem("receiverPhone") || "0987654321",
        fromAddress: localStorage.getItem("fromAddress") || "123 From Street",
        toAddress: localStorage.getItem("toAddress") || "456 To Avenue",
        date: localStorage.getItem("date") || "2024-11-15",
        truckType: localStorage.getItem("truckType") || "Not Specified",
        goodsType: localStorage.getItem("loadType") || "Not Selected",
        truckLoadType: truckLoadType || "Not Selected",
        tonnage: tonnage || "Not Selected"
    };

    console.log("Sending data to server:", data);  // Add this line to see the data being sent

    fetch("save_booking.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
    })
    .catch(error => {
        console.error("Error saving data:", error);
    });
}


    
        // Function to go back to the previous page
        function goBack() {
            window.history.back();
        }
    
        function confirmAction() {
    if (confirm("Are you sure you want to proceed?")) {
        saveToDatabase(); // Save data before redirecting
        window.location.href = "paymentpage.html";
    }
}

    
        // Initialize the summary when the page loads
        window.onload = updateSummary;
    </script>
</body>
</html>