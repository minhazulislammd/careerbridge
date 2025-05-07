<?php
     include("connection.php");
     session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding Seekers For Long</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="find_seekers_for_long_term.css">
    <style>
        #map {
            margin-top: 20px;
            height: 400px;
            width: 100%;
            z-index: 1;
        }
        .leaflet-control-geocoder-form input {
            width: 300px;
        }
        #suggestions {
            position: absolute;
            background: white;
            border: 1px solid black;
            width: 300px;
            max-height: 150px;
            overflow-y: auto;
        }
        #suggestions div {
            padding: 5px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<div class="page">
       <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo"><a href="client_home_page.php">CareerBridge</a></div>
            <ul> 
                <li class="dropdown">
                    <a href="#">Jobs</a>
                    <div class="dropdown-content">
                        <a href="client_home_page.php">Your dashboard</a>
                        <a href="client_all_job_post.php">All jobs posts</a>
                        <a href="client_all_contract.php">All contracts</a>
                    </div>
                </li>
                <li class="dropdown1">
                    <a href="#">Talent</a>
                    <div class="dropdown-content1">
                        <a href="client_discover.php">Discover</a>
                        <a href="client_hires.php">Your hires</a>
                        <a href="client_saved_talent.php">Saved talent</a>
                    </div>
                </li>
                <li><a href="#">Messages</a></li>
            </ul>
                <img src="logo/user.png" class="user_pic" onclick="toggleMenu()">
                <span class="account-text">Account</span>
                    
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="logo/user.png">
                        <h3><?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) .' '.htmlspecialchars(ucfirst($_SESSION['lastname'])); ?></h3>
                    </div>
                    <hr>
                    <a href="client_profile.php" class="sub-menu-link">
                        <img src="logo/edit.png">
                        <p>Profile</p>
                        <span>></span>
                    </a>
                    
                    <a href="#" class="sub-menu-link">
                        <img src="logo/setting.png">
                        <p>Settings & Privacy</p>
                        <span>></span>
                    </a>

                    <a href="#" class="sub-menu-link">
                        <img src="logo/help.png">
                        <p>Help & Support</p>
                        <span>></span>
                    </a>

                    <a href="logout.php" class="sub-menu-link">
                        <img src="logo/logout.png">
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>

         <!-- Map Section -->
    <div id="map"></div>
</div>



<!-- Map and Geolocation Script -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>

    var dhakaBounds = [
        [23.6700, 90.3500],
        [23.9500, 90.5400]
    ];

    var map = L.map('map', {
        center: [23.8103, 90.4125],
        zoom: 12,
        minZoom: 10,
        maxZoom: 16,
        maxBounds: dhakaBounds,
        maxBoundsViscosity: 1.0
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var userLat = null;
    var userLng = null;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            userLat = position.coords.latitude;
            userLng = position.coords.longitude;
            var userLocation = [userLat, userLng];

            L.marker(userLocation).addTo(map)
                .bindPopup("You are here!")
                .openPopup();

            map.setView(userLocation, 13);
        });
    }

    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: true
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        L.marker(latlng).addTo(map)
            .bindPopup(e.geocode.name)
            .openPopup();
        map.setView(latlng, 13);
    }).addTo(map);

    const searchBox = document.querySelector('.leaflet-control-geocoder-form input');
    searchBox.addEventListener('input', function () {
        const searchTerm = searchBox.value;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchTerm}&addressdetails=1&limit=5`)
            .then(response => response.json())
            .then(data => {
                const suggestionsDiv = document.querySelector('#suggestions');
                if (suggestionsDiv) suggestionsDiv.remove();

                const suggestionContainer = document.createElement('div');
                suggestionContainer.id = 'suggestions';
                suggestionContainer.style.position = 'absolute';
                suggestionContainer.style.background = 'white';
                suggestionContainer.style.border = '1px solid black';
                suggestionContainer.style.width = searchBox.offsetWidth + 'px';

                data.forEach(place => {
                    const suggestion = document.createElement('div');
                    suggestion.innerText = `${place.display_name}`;
                    suggestion.addEventListener('click', () => {
                        searchBox.value = `${place.display_name}`;
                        userLat = place.lat;
                        userLng = place.lon;
                        map.setView([place.lat, place.lon], 13);
                        if (typeof marker !== 'undefined') map.removeLayer(marker);
                        marker = L.marker([place.lat, place.lon]).addTo(map);
                        suggestionContainer.remove();
                    });
                    suggestionContainer.appendChild(suggestion);
                });

                searchBox.insertAdjacentElement('afterend', suggestionContainer);
            });
    });

    function getCoordinates() {
        document.getElementById('lat').value = userLat;
        document.getElementById('lon').value = userLng;
    }


    let subMenu = document.getElementById("subMenu");
    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }
</script>

<footer class="page-footer" style="background-color: #424242; padding: 20px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col" style="flex: 0 0 60%; padding: 10px;">
                    <h2 style="color:  rgb(255, 221, 0);">About CareerBridge</h2>
                    <p style="color: #bdbdbd;">
                    CareerBridge is a dynamic chat platform designed to connect clients and job-seekers seamlessly. It allows buyers and sellers, or clients and freelancers, to communicate directly after logging in. The platform supports multi-way messaging, enabling clients to reach multiple job-seekers and vice versa. With a focus on efficient and clear communication, HustlUp simplifies the job-seeking process while fostering professional connections between buyers and sellers.
                    </p>
                    
                </div>

                <div class="col" style="flex: 0 0 30%; padding: 10px;">
                    <h2 style="color: rgb(255, 221, 0);">Connect</h2>
                    <ul style="list-style-type: none; padding: 0;">
                        <li><a href="#" style="color: #bdbdbd; text-decoration: none;">Facebook</a></li>
                        <li><a href="#" style="color: #bdbdbd; text-decoration: none;">Twitter</a></li>
                        <li><a href="#" style="color: #bdbdbd; text-decoration: none;">LinkedIn</a></li>
                        <li><a href="#" style="color: #bdbdbd; text-decoration: none;">Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright" style="background-color: #212121; padding: 10px;">
            <div class="container" style="text-align: center; color: white;">&copy;2025 CareerBridge</div>
        </div>
    </footer>

</body>
</html>
