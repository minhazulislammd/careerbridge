<?php
include("connection.php");
session_start();

if (!isset($_SESSION['firstname']) || !isset($_SESSION['lastname'])) {
    header("Location: signin_page.php");
    exit();
}

$userId = $_SESSION['user_id'];
// Fetch job posts from the database
$query = "SELECT * FROM job_posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Send an error message as JSON if there's an issue
    echo json_encode(['error' => mysqli_error($conn)]);
    exit();
}

$jobPosts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobPosts[] = $row;
}

$userQuery = "SELECT * FROM seeker_information WHERE seeker_id = '$userId'";
$userResult = mysqli_query($conn, $userQuery);

if (!$userResult) {
    echo json_encode(['error' => mysqli_error($conn)]);
    exit();
}

$userData = mysqli_fetch_assoc($userResult);

// Encode the job posts array as JSON
//echo json_encode($job_posts);

// Example array of required fields
$requiredFields = ['firstname', 'lastname', 'email', 'country', 'contact', 'age', 'address', 'city', 'education', 'experience', 'skills', 'work_experience', 'certification', 'profile_description', 'profile_title', 'accomplishments'];
$completedFields = 0;

// Check each required field
foreach ($requiredFields as $field) {
    if (!empty($_SESSION[$field])) {
        $completedFields++;
    }
}

// Calculate the completion percentage
$completionPercentage = ($completedFields / count($requiredFields)) * 100;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user_home_page.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <title>user_home_page</title>
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

        .job-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .job-card:hover {
            background-color: #f9f9f9;
        }

        .popup {
            position: fixed;
            top: 0;
            right: -100%;
            width: 40%;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
            transition: right 0.4s ease;
            z-index: 1000;
            font-size: 14px;
        }

        .popup-content {
            padding: 20px;
        }

        #popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;

        }

        .popup.show {
            right: 0;
        }

        .popup-content1 {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .job-header1 {
            font-size: 12px;
            font-weight: 400;
        }

        .job-header1 h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .job-header1 {
            border-bottom: 1px solid #ccc;
        }

        .job-content {
            margin: 20px 0;
            border-bottom: 1px solid #ccc;
        }

        .job-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
        }

        .job-actions {
            justify-content: center;
            display: flex;
            gap: 10px;
        }

        .apply-btn,
        .save-btn {
            background-color: rgb(255, 220, 0);
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .posted-time {
            font-size: 12px;
            font-weight: 400;
        }

        .apply-btn:hover,
        .save-btn:hover {
            background-color: #e1c302;
        }

        .client-info1 {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .client-info1 h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .client-info1 .rating {
            font-size: 20px;
            color: #f39c12;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <div class="page">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo"><a href="user_home_page.php">CareerBridge</a></div>
            <ul>
                <li class="dropdown">
                    <a href="#">Find task</a>
                    <div class="dropdown-content">
                        <a href="user_home_page.php">Your Dashboard</a>
                        <a href="applied_jobs.php">Applied tasks</a>
                        <a href="saved_jobs.php">Saved tasks</a>
                    </div>
                </li>
                <li class="dropdown1">
                    <a href="#">Delivery task</a>
                    <div class="dropdown-content1">
                        <a href="user_active_contracts.php">Your active contracts</a>
                        <a href="completed_jobs.php">Completed Tasks</a>
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
                        <h3><?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) . ' ' . htmlspecialchars(ucfirst($_SESSION['lastname'])); ?></h3>
                    </div>
                    <hr>
                    <a href="user_profile.php" class="sub-menu-link">
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

        <div class="container">
            <aside class="profile-section">
                <div class="profile-card">
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) . ' ' . htmlspecialchars(ucfirst($_SESSION['lastname'])); ?></h2>
                        <p><?php echo htmlspecialchars($userData['profile_title']); ?></p>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo $completionPercentage; ?>%;"></div>
                        </div>
                        <a href="user_profile.php">Complete your profile</a>
                    </div>
                </div>

                <div class="promo-options">
                    <div class="promo-item">
                        <span>Preference</span>
                    </div>
                    <div class="promo-item">
                        <span>Proposal</span>
                    </div>
                </div>

                <div class="connections">
                    <h3>Connects: 10</h3>
                </div>

                <label class="switch">
                    <input type="checkbox" name="bargain">
                    <span class="slider round"></span>
                </label>
                <span>Available Now!</span>

            </aside>

            <main>
                <section class="job-list">
                    <h2>Jobs you might like</h2>
                    <div class="tabs">
                        <a href="user_home_page.php" id="tab1" class="tab active">All Jobs</a>
                        <a href="most_recent_job.php" id="tab2" class="tab">Most Recent</a>
                        <a href="saved_jobs.php" id="tab3" class="tab">Saved Jobs</a>
                    </div>

                    <!-- Job Cards -->
                    <div id="job-list">
                        <?php foreach ($jobPosts as $job): ?>
                            <div class="job-card" onclick="togglePopup({
                            created_at: '<?php echo htmlspecialchars($job['created_at']); ?>',
                            title: '<?php echo htmlspecialchars($job['title']); ?>',
                            fare: '<?php echo htmlspecialchars($job['fare']); ?>',
                            number_of_workers: '<?php echo htmlspecialchars($job['number_of_workers']); ?>',
                            type: '<?php echo htmlspecialchars($job['type']); ?>',
                            description: '<?php echo htmlspecialchars($job['description']); ?>',
                            skills_and_requirements: '<?php echo htmlspecialchars($job['skills_and_requirements']); ?>',
                            rating: '<?php echo isset($job['rating']) ? htmlspecialchars($job['rating']) : 'Not available'; ?>',
                            location: '<?php echo isset($job['location']) ? htmlspecialchars($job['location']) : 'Not specified'; ?>',
                            })">

                                <div class="job-header">
                                    <h2><?php echo htmlspecialchars($job['title']); ?></h2>
                                    <span class="posted-time">Posted on <?php echo htmlspecialchars($job['created_at']); ?></span>

                                </div>
                                <div class="job-info">
                                    <p><strong>Fair:</strong> <?php echo htmlspecialchars($job['fare']); ?></p>
                                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                                    <div class="tags">
                                        <span class="tag"><?php echo htmlspecialchars($job['skills_and_requirements']); ?></span>
                                    </div>
                                </div>
                                <div class="client-info">
                                    <span class="client-rating"><?php echo isset($job['rating']) ? htmlspecialchars($job['rating']) : 'Not available'; ?></span>
                                    <span class="client-location"><?php echo isset($job['location']) ? htmlspecialchars($job['location']) : 'Not specified'; ?></span>
                                </div>

                            </div>

                        <?php endforeach; ?>
                    </div>

                    <!-- Popup Modal for Job Details -->
                    <div class="popup" id="popup">
                        <span id="popup-close" onclick="closePopup()">&times;</span>
                        <div class="popup-content">
                            <div class="popup-content1">
                                <div class="job-header1">
                                    <p>Posted on<span id="popupPostedTime"></span></p>
                                    <h1 id="popupJobTitle">Job Title</h1>
                                </div>
                                <div class="job-content">
                                    <p>Description:<span id="popupDescription"></span></p>
                                    <p>Task type:<span id="popupType"></span></p>
                                    <p>Number of worker:<span id="popupNumber"></span></p>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <p><strong>Fair:</strong><span id="popupBudget"></span></p>
                                        <p>Bargain: </p>
                                    </div>
                                </div>
                                <div class="skills">
                                    <p><strong>Skills and Expertise:</strong> <span id="popupSkills"></span></p>
                                    <span></span>
                                </div>
                                <div class="job-actions">
                                    <a href="applied_jobs.php" class="apply-btn">Apply now</a>
                                    <a href="#" class="save-btn">Save job</a>
                                </div>
                            </div>
                        </div>

                        <div class="client-info1">
                            <h2>About the client</h2>
                            <p><span class="rating">4.9</span> of 23 reviews</p>
                            <p>United States<br>Piscataway 3:36 AM</p>
                            <p>83 jobs posted<br>236 hires, rate: 1 job open</p>
                        </div>
                    </div>
        </div>
    </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePopup(jobData) {
            // Populate the popup with job details
            document.getElementById('popupJobTitle').innerText = jobData.title;
            document.getElementById('popupPostedTime').innerText = jobData.created_at;
            document.getElementById('popupBudget').innerText = jobData.fare;
            document.getElementById('popupNumber').innerText = jobData.number_of_workers;
            document.getElementById('popupDescription').innerText = jobData.description;
            document.getElementById('popupSkills').innerText = jobData.skills_and_requirements;
            document.getElementById('popupType').innerText = jobData.type;

            // Show the popup by sliding it from the right
            document.getElementById('popup').classList.add('show');
        }

        function closePopup() {
            // Hide the popup by sliding it back
            document.getElementById('popup').classList.remove('show');
        }
    </script>

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
            navigator.geolocation.getCurrentPosition(function(position) {
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
        searchBox.addEventListener('input', function() {
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
    </script>

    <script>
        // Example of a new job being posted
        function fetchJobPosts() {
            fetch('fetch_jobs.php')
                .then(response => response.json())
                .then(data => {
                    const jobList = document.getElementById("job-list");
                    jobList.innerHTML = ''; // Clear current job list
                    data.forEach(job => {
                        const jobCard = document.createElement("div");
                        jobCard.classList.add("job-card");
                        jobCard.innerHTML = `
                        <div class="job-header">
                            <span class="posted-time">${job.posted_time}</span>
                            <h2>${job.title}</h2>
                        </div>
                        <div class="job-info">
                            <p><strong>Budget:</strong> ${job.fare}</p>
                            <p>${job.description}</p>
                            <div class="tags">
                                <span class="tag">HTML</span>
                            </div>
                        </div>
                        <div class="client-info">
                            <span class="client-rating">${job.client_rating  || 'Not available'}</span>
                            <span class="client-location">${job.client_location || 'Not specified'}</span>
                        </div>
                    `;
                        jobList.appendChild(jobCard);
                    });
                });
        }

        // Call fetchJobPosts every 5 seconds
        setInterval(fetchJobPosts, 5000);
    </script>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

    <script>
        //switching tabs
        const tab1 = document.getElementById('tab1');
        const tab2 = document.getElementById('tab2');
        const tab3 = document.getElementById('tab3');
        const underline = document.querySelector('.underline');
        const content = document.getElementById('content'); // Ensure this exists

        function activateTab(tab) {
            // Reset all tabs
            tab1.classList.remove('active');
            tab2.classList.remove('active');
            tab3.classList.remove('active');

            // Activate the clicked tab
            tab.classList.add('active');

            // Adjust the underline position and width
            if (underline) {
                underline.style.width = `${tab.offsetWidth}px`;
                underline.style.left = `${tab.offsetLeft}px`;
            }

            // Change content dynamically based on active tab
            if (tab === tab1 && content) {
                content.innerHTML = '<div class="empty-message">There are no job posts available.</div>';
            } else if (tab === tab2 && content) {
                content.innerHTML = '<div class="empty-message">There are no contracts available.</div>';
            } else if (tab === tab3 && content) {
                content.innerHTML = '<div class="empty-message">There are no saved jobs available.</div>';
            }
        }

        // Initialize the underline position and set default tab as active
        window.onload = () => {
            activateTab(tab1); // Set default tab as active
        };

        // Add event listeners to switch tabs
        tab1.addEventListener('click', () => activateTab(tab1));
        tab2.addEventListener('click', () => activateTab(tab2));
        tab3.addEventListener('click', () => activateTab(tab3));
    </script>

<footer class="page-footer" style="background-color: #424242; padding: 20px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col" style="flex: 0 0 60%; padding: 10px;">
                    <h2 style="color:  rgb(255, 221, 0);">About HustlUp</h2>
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
            <div class="container" style="text-align: center; color: white;">&copy;2024 CareerBridge</div>
        </div>
    </footer>

</body>

</html>

