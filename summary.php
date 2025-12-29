<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Integration with Sidebar and Booking Summary</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-geosearch/dist/bundle.min.js"></script>
    <style>
        /* Add your existing styles here */
        /* Adjusted to fit additional sidebar content */
        .sidebar {
            width: 300px;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="Load.itwhite.png" alt="Transport App Logo">
        </div>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="ownerdashboard.html">Profile</a></li>
            <li><a href="owenersign.html">Truck Owner</a></li>
            <li><a href="driverlogin.html">Driver</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <!-- Main Content (Map and Sidebar) -->
    <div id="map"></div>
    <div class="sidebar">
        <h1>Route Viewer & Booking Summary</h1>
        <div class="inputs">
            <!-- Truck Type -->
            <select id="truckType" required>
                <option value="" disabled selected>Select Truck Type</option>
                <option value="Open Truck">Open Truck</option>
                <option value="Closed Truck">Closed Truck</option>
                <option value="Container">Container</option>
            </select>

            <!-- Tonnage -->
            <select id="tonnage" required>
                <option value="" disabled selected>Select Tonnage</option>
                <option value="5 Tons">5 Tons</option>
                <option value="10 Tons">10 Tons</option>
                <option value="15 Tons">15 Tons</option>
            </select>

            <!-- Origin and Destination -->
            <input type="text" id="origin" placeholder="Enter origin">
            <input type="text" id="destination" placeholder="Enter destination">
            <button onclick="confirmBooking()">Confirm Booking</button>
        </div>
        <div class="route-info">
            <h2>Booking Details</h2>
            <div id="summary-details"></div>
            <p><span class="label">Distance:</span> <span id="distance"></span></p>
            <p><span class="label">Duration:</span> <span id="duration"></span></p>
        </div>
    </div>

    <script>
        const map = L.map('map').setView([20.5937, 78.9629], 5); // Default view for India

        // Add OpenStreetMap tiles
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const searchControl = new GeoSearch.GeoSearchControl({
            provider: new GeoSearch.OpenStreetMapProvider(),
            style: 'bar',
            autoClose: true,
            retainZoomLevel: false,
            searchLabel: 'Search for a place...'
        });
        map.addControl(searchControl);

        let control = null;

        // Fetch coordinates for a location
        async function getCoordinates(location) {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(location)}&format=json&limit=1`);
            const data = await response.json();

            if (data.length === 0) {
                throw new Error(`Location not found: ${location}`);
            }

            return {
                lat: parseFloat(data[0].lat),
                lon: parseFloat(data[0].lon),
            };
        }

        async function confirmBooking() {
            const truckType = document.getElementById('truckType').value;
            const tonnage = document.getElementById('tonnage').value;
            const originName = document.getElementById('origin').value;
            const destinationName = document.getElementById('destination').value;

            if (!truckType || !tonnage || !originName || !destinationName) {
                alert('Please fill in all fields.');
                return;
            }

            try {
                const origin = await getCoordinates(originName);
                const destination = await getCoordinates(destinationName);

                if (control) {
                    control.remove();
                }

                control = L.Routing.control({
                    waypoints: [
                        L.latLng(origin.lat, origin.lon),
                        L.latLng(destination.lat, destination.lon)
                    ],
                    routeWhileDragging: true,
                    createMarker: () => null,
                    lineOptions: { styles: [{ color: 'blue', opacity: 0.7, weight: 8 }] }
                }).addTo(map);

                control.on('routesfound', function(e) {
                    const route = e.routes[0];
                    const distance = (route.summary.totalDistance / 1000).toFixed(1); // Convert meters to kilometers
                    const duration = (route.summary.totalTime / 60).toFixed(0); // Convert seconds to minutes

                    // Display booking details in the sidebar
                    document.getElementById('summary-details').innerHTML = `
                        <p><strong>Truck Type:</strong> ${truckType}</p>
                        <p><strong>Tonnage:</strong> ${tonnage}</p>
                        <p><strong>Origin:</strong> ${originName}</p>
                        <p><strong>Destination:</strong> ${destinationName}</p>
                    `;
                    document.getElementById('distance').textContent = `${distance} km`;
                    document.getElementById('duration').textContent = `${duration} min`;
                });

            } catch (error) {
                alert(error.message);
            }
        }
    </script>
</body>
</html>
