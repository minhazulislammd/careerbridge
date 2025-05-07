<?php
session_start();
include("connection.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response array
$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);
    $no_worker = mysqli_real_escape_string($conn, $_POST['no_worker']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);
    $bargain = isset($_POST['bargain']) ? 1 : 0;

    // Getting client_id from session
    if (isset($_SESSION['user_id'])) {
        $client_id = $_SESSION['user_id'];
    } else {
        $response['message'] = "Error: User not logged in.";
        echo json_encode($response);
        exit;
    }

    // Get job type
    $is_instant_job = isset($_POST['select']) && $_POST['select'] === 'instant' ? 1 : 0;
    $is_long_term_job = isset($_POST['select']) && $_POST['select'] === 'long_term' ? 1 : 0;
    $type = $is_instant_job ? 'instant' : 'long_term';

    // Get visibility
    $visibility = isset($_POST['pref_select']) ? mysqli_real_escape_string($conn, $_POST['pref_select']) : 'everyone';

    // Get coordinates from the form
    $lat = isset($_POST['lat']) ? mysqli_real_escape_string($conn, $_POST['lat']) : null;
    $lon = isset($_POST['lon']) ? mysqli_real_escape_string($conn, $_POST['lon']) : null;

    // Get current timestamp
    $created_at = date('Y-m-d H:i:s');

    // Construct the SQL query
    $query = "INSERT INTO job_posts (client_id, title, description, skills_and_requirements, number_of_workers, fare, is_instant_job, is_long_term_job, type, visibility, can_bargain, created_at, latitude, longitude) 
              VALUES ('$client_id', '$title', '$description', '$skills', '$no_worker', '$payment', '$is_instant_job', '$is_long_term_job', '$type', '$visibility', '$bargain', '$created_at', '$lat', '$lon')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
        $response['message'] = "Job posted successfully.";
    } else {
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response); // Return response as JSON
    mysqli_close($conn);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Job Post</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="instant_post.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
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
        <div class="logo"><a href="client_home_page.php">CarrerBridge</a></div>
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

    <div class="box_container_content">
        <aside class="aside">
            <div class="additional">
                <h2>Additional Details</h2>
            <p>What do you want to do?
            </p>
            <div class="content">
                <div class="box_container">
                    <div class="content_box_container">
                        <div class="box" id="instant_box">
                            <p>Instant Job</p>
                            <input type="radio" class="radio" id="instant" name="select">
                        </div>
    
                        <div class="box" id="long_term_box">
                            <p>Long Term</p>
                            <input type="radio" class="radio" id="long_term" name="select">
                        </div>
                    </div>
                </div>
            </div>

            </div>

            <div class="preferences">
                <h2>Preferences</h2>
                <p>Who can see your jobs?</p>
                <div class="radio-options">
                  <label>
                  <input type="radio" id="everyone" name="pref_select" value="everyone">
                  <span class="custom-radio"></span>
                  Everyone
                  </label>
                  <label>
                  <input type="radio" id="all_contracts" name="pref_select" value="all_contracts">
                  <span class="custom-radio"></span>
                  All contracts
                  </label>
                  <label>
                  <input type="radio" id="invited_only" name="pref_select" value="invited_only">
                  <span class="custom-radio"></span>
                  Invited only
                  </label>
            </div>
            </div>

            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" name="bargain">
                    <span class="slider round"></span>
                </label>
                <span>Option to bargain</span>
            </div>
        </aside>
        <main>
            <div class="container">
                <form action="instant_post.php" method="post" onsubmit="getCoordinates(); return true;">
                    <div class="post">
                        <div class="header_content">
                            <div class="header_content_heading">
                                <h3>Let's start with a strong title</h3>
                            </div>
                        </div>
                        <label for="title">Write a title for your job post</label>
                        <input type="text" id="title" name="title">
                        
                        <label for="text">Description</label>
                        <textarea id="description" name="description"></textarea>
                        <label for="text">Skills and requirements</label>
                        <textarea id="skills" name="skills"></textarea>
                        <label for="no_worker">Number of workers</label>
                        <input type="text" id="no_worker" class="no_worker" name="no_worker">
                        <label for="payment">Offer your fare</label>
                        <input type="text" id="payment" class="payment" name="payment">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lon" name="lon">
                        <div class="submit_container">
                            <button type="button" id="submit_btn" class="submit_btn disabled" disabled>Select Option</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
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

    //dropdown menu
    let subMenu = document.getElementById("subMenu");
    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }


    //
    document.addEventListener('DOMContentLoaded', () => {
    const instantRadio = document.getElementById('instant');
    const longTermRadio = document.getElementById('long_term');
    const submitBtn = document.getElementById('submit_btn');
    const instantBox = document.getElementById('instant_box');
    const longTermBox = document.getElementById('long_term_box');
    const latInput = document.getElementById('lat');
    const lonInput = document.getElementById('lon');
    let userLat = null;
    let userLng = null;

    // Function to get and set coordinates
    const getCoordinates = (callback) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;

                // Set latitude and longitude to hidden input fields
                latInput.value = userLat;
                lonInput.value = userLng;

                // Call the callback function if defined (after setting coordinates)
                if (callback) callback();
            }, function (error) {
                alert('Unable to retrieve your location');
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    };

    // Function to update the state of the submit button
    const updateButtonState = () => {
        if (instantRadio.checked) {
            submitBtn.textContent = 'Find seekers for instant';
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.classList.add('enabled');
        } else if (longTermRadio.checked) {
            submitBtn.textContent = 'Find seekers for long term';
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            submitBtn.classList.add('enabled');
        } else {
            submitBtn.textContent = 'Find Seekers';
            submitBtn.disabled = true;
            submitBtn.classList.remove('enabled');
            submitBtn.classList.add('disabled');
        }
    };

    const selectOption = (radio, box) => {
        radio.checked = true;
        updateButtonState();
        document.querySelectorAll('.box').forEach(box => box.classList.remove('selected'));
        box.classList.add('selected');
    };

    instantBox.addEventListener('click', () => selectOption(instantRadio, instantBox));
    longTermBox.addEventListener('click', () => selectOption(longTermRadio, longTermBox));

    // Handle form submission
    submitBtn.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default form submission

    // Ensure geolocation is captured before submitting the form
    getCoordinates(() => {
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value; 
        const skills = document.getElementById('skills').value; 
        const noWorker = document.getElementById('no_worker').value;
        const payment = document.getElementById('payment').value;
        const visibility = document.querySelector('input[name="pref_select"]:checked'); // Ensure visibility is captured

        // Debugging step: Log the visibility to check if it's being captured correctly
        if (visibility) {
            console.log('Visibility selected:', visibility.value);
        } else {
            console.log('No visibility selected');
        }

        if (!title || !description || !skills || !noWorker || !payment || !latInput.value || !lonInput.value || !visibility) {
            alert('Please fill out all fields and allow location access before submitting.');
            return; // Prevent submission if not all fields are filled
        }

        // Prepare form data to send to the server
        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('skills', skills);
        formData.append('no_worker', noWorker);
        formData.append('payment', payment);
        formData.append('bargain', document.querySelector('input[name="bargain"]').checked ? 1 : 0);
        formData.append('select', instantRadio.checked ? 'instant' : 'long_term');
        formData.append('pref_select', visibility.value); // Append the selected visibility value
        formData.append('lat', latInput.value); // Latitude value
        formData.append('lon', lonInput.value); // Longitude value

        // Send the form data using fetch
        fetch('instant_post.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect based on the selected radio button
                if (instantRadio.checked) {
                    window.location.href = 'find_seekers_for_instant_job.php';
                } else if (longTermRadio.checked) {
                    window.location.href = 'find_seekers_for_long_term.php';
                }
            } else {
                // Handle errors
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error during fetch:', error);
        });
    });
});
    // Update button state on page load
    updateButtonState();
});

</script>

<footer class="page-footer" style="background-color: #424242; padding: 20px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col" style="flex: 0 0 60%; padding: 10px;">
                    <h2 style="color:  rgb(255, 221, 0);">About CarrerBridge</h2>
                    <p style="color: #bdbdbd;">
                    CarrerBridge is a dynamic chat platform designed to connect clients and job-seekers seamlessly. It allows buyers and sellers, or clients and freelancers, to communicate directly after logging in. The platform supports multi-way messaging, enabling clients to reach multiple job-seekers and vice versa. With a focus on efficient and clear communication, HustlUp simplifies the job-seeking process while fostering professional connections between buyers and sellers.
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
            <div class="container" style="text-align: center; color: white;">&copy;2025 CarrerBridge</div>
        </div>
    </footer>



</body>
</html>