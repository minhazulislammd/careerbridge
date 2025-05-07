

<?php
include("connection.php");
session_start();

// Fetch seekers information with corresponding firstname and lastname from users_information
$query = "
    SELECT si.*, CONCAT(ui.firstname, ' ', ui.lastname) AS full_name 
    FROM seeker_information si
    JOIN users_information ui ON si.seeker_id = ui.user_id"; // Assuming seeker_id is a foreign key referring to user_id in users_information

$result = mysqli_query($conn, $query);
$seekers = [];

if (mysqli_num_rows($result) > 0) {
    // Fetch all seekers as an associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $seekers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view_job_post.css">
    <title>View Posts</title>

    <style>
        .popup {
            position: fixed;
            top: 0;
            right: -100%;
            width: 40%;
            height: 100%;
            background-color: white;
            transition: right 0.3s ease;
            box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .popup.active {
            right: 0;
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

        
        .popup-content1 {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .job-header2 {
            font-size: 16px;
            font-weight: 400;
        }

        .job-header2 h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .job-header2 {
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
                        <h3>
                            <?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) . ' ' . htmlspecialchars(ucfirst($_SESSION['lastname'])); ?>
                        </h3>
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

        <div class="container">
            <aside class="profile-section">
                <div class="header">
                    <h1>Task details</h1>
                    <hr>
                </div>

                <?php
                if (isset($_GET['job_id'])) {
                    // Sanitize and assign the job_id to a variable
                    $job_id = intval($_GET['job_id']);

                    // Fetch the job details from the database where job_id matches
                    $query = "SELECT title, description, skills_and_requirements, number_of_workers, fare, status, type FROM job_posts WHERE job_id = $job_id";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $job = mysqli_fetch_assoc($result); // Fetch the job details as an associative array
                    } else {
                        echo "No job found for the given ID.";
                    }
                } else {
                    echo "Job ID is missing.";
                }
                ?>


                <div class="popu">
                    <div class="task-content">
                        <div class="task-content">
                            <?php if (isset($job)): ?>
                                <div class="job-header1">
                                    <h1>Task Title:
                                        <?php echo htmlspecialchars(ucfirst($job['title'])); ?>
                                    </h1>
                                    <hr>
                                </div>
                                <div class="job-content">
                                    <p>Description:
                                        <?php echo htmlspecialchars(ucfirst($job['description'])); ?>
                                    </p>
                                    <p>Task type:
                                        <?php echo htmlspecialchars(ucfirst($job['type'])); ?>
                                    </p>
                                    <p>Number of helper:
                                        <?php echo htmlspecialchars(ucfirst($job['number_of_workers'])); ?>
                                    </p>
                                    <p><strong>Fare:</strong>
                                        <?php echo htmlspecialchars(ucfirst($job['fare'])); ?>
                                    </p>
                                    <hr>
                                </div>
                                <div class="skills">
                                    <p><strong>Skills and Expertise:</strong>
                                        <?php echo htmlspecialchars(ucfirst($job['skills_and_requirements'])); ?>
                                    </p>
                                    <hr>
                                </div>
                                <div class="job-details">
                                    <div class="job-detail">
                                        <p><strong>Status:</strong>
                                            <?php echo htmlspecialchars(ucfirst($job['status'])); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </aside>

            <main>
                <section class="job-list">
                    <div class="client-info">
                        <h2>Applied candidates</h2>
                        <hr>
                        <section class="seekers-list">
                            <div id="seekers-container"></div> <!-- Dynamic seekers will be added here -->
                        </section>
                    </div>
                </section>
            </main>
        </div>

        <!-- Popup Container (move this outside of your seekers loop) -->
        <div class="popup" id="popup">
            <span id="popup-close" onclick="closePopup()">&times;</span>
            <div class="popup-content">
                <div class="popup-content1">
                    <div class="job-header2">
                        <h3 id="popup-title">Name: </h3>
                        <p id="popup-profile-title">Profile title: </p>
                        <p id="popup-profile-description">Profile description: </p>
                    </div>
                    <div class="job-content">
                        <p id="popup-experience">Experience: </p>
                        <p id="popup-skills">Skills: </p>
                        <p id="popup-work-experience">Work experience: </p>
                    </div>
                    <div class="job-details">
                        <div class="job-detail">
                            <p id="popup-education">Education</p>
                        </div>
                    </div>
                    <div class="skills">
                        <p id="popup-address">Address:</p>
                        <p id="popup-city">City:</p>
                        <p id="popup-contact">Contact: </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }

        // Fetch seekers data from PHP
        const seekers = <?php echo json_encode($seekers); ?>;

        // Function to display seekers in the container
        function addSeekers() {
            const container = document.getElementById('seekers-container');

            seekers.forEach(seeker => {
                const card = document.createElement('div');
                card.className = 'seekers-card';
                card.innerHTML = `
                    <div class="seekers-info">
                        <img src="logo/user.png"> <!-- Placeholder image -->
                        <h3>${seeker.full_name}</h3> <!-- Display full name -->
                        <p>${seeker.city}</p>
                        <p>Skills: ${seeker.skills}</p>
                        <a href="#" class="apply-btn"><button class="hire-btn">Hire</a>
                    </div>
                `;
                card.addEventListener('click', () => openPopup(seeker)); // Add click event listener to show popup
                container.appendChild(card);
            });
        }

        // Call addSeekers to populate the container
        addSeekers();

        // Function to open the popup and populate it with seeker information
        function openPopup(seeker) {
            document.getElementById('popup-title').textContent = seeker.full_name;
            document.getElementById('popup-profile-title').textContent = "Profile title: " + seeker.profile_title;
            document.getElementById('popup-profile-description').textContent = "Profile description: " + seeker.profile_description;
            document.getElementById('popup-experience').textContent = "Experience: " + seeker.experience;
            document.getElementById('popup-skills').textContent = "Skills: " + seeker.skills;
            document.getElementById('popup-work-experience').textContent = "Work experience: " + seeker.work_experience;
            document.getElementById('popup-address').textContent = "Address: " + seeker.address;
            document.getElementById('popup-city').textContent = "City: " + seeker.city;
            document.getElementById('popup-contact').textContent = "Contact: " + seeker.contact;
            document.getElementById('popup-education').textContent = "Education: " + seeker.education;

            document.getElementById('popup').classList.add('active');
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('popup').classList.remove('active');
        }
    </script>
</body>

</html>