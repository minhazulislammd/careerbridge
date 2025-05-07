<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="client_all_job_post.css">
    <title>Job Posts</title>
    <style>
        /* Styling for the job posts table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        table th,
        table td {
            padding: 15px 15px;
            /* Add spacing inside the cells */
            text-align: left;
            border-bottom: 1px solid #ddd;
            /* Add a bottom line separator */
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
            /* Light gray background for the header */
        }

        table tr:hover {
            background-color: #f9f9f9;
            /* Slight hover effect for rows */
        }

        .no-contracts {
            font-size: 18px;
            color: #555;
            margin-top: 20px;
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
                        <a href="">All Courses</a>
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
                        <h3><?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) . ' ' . htmlspecialchars(ucfirst($_SESSION['lastname'])); ?></h3>
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
            <div class="tabs">
                <a href="client_all_job_post.php" id="jobTab" class="tab">All job posts</a>
                <a href="client_all_contract.php" id="contractTab" class="tab active">All contracts</a>
            </div>
            <div class="header">
                <h1>All job posts</h1>
                <a href="instant_post.php"><button class="post-job-btn">+ Post a new job</button></a>
            </div>
            <div class="controls">
                <div class="search-bar">
                    <input type="text" placeholder="Search by seekers">
                    <span>🔍</span>
                </div>
                <button class="filter-button">Filters</button>
                <div class="sort-options">
                    <label for="sort-by">Sort by</label>
                    <select id="sort-by">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <select id="order">
                        <option value="descending">Descending</option>
                        <option value="ascending">Ascending</option>
                    </select>
                </div>
            </div>


            <?php
            // Fetch the jobs from the database where client_id matches the session user ID
            $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
            $query = "SELECT title, status, created_at, job_id FROM job_posts WHERE client_id = '$user_id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Job Title</th><th>Status</th><th>Created At</th><th>Action</th></tr>';

                // Fetch and display each row from the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars(ucfirst($row['title'])) . '</td>';
                    echo '<td>' . htmlspecialchars(ucfirst($row['status'])) . '</td>';
                    echo '<td>' . htmlspecialchars(ucfirst($row['created_at'])) . '</td>';
                    echo '<td>';
                    echo '<a href="view_job_post.php?job_id=' . $row['job_id'] . '"><button class="open-btn-for-view">View</button></a>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                // Display this message if there are no job posts
                echo '<div class="no-contracts">';
                echo '<p>No job posts found.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>


    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }

        const jobTab = document.getElementById('jobTab');
        const contractTab = document.getElementById('contractTab');
        const underline = document.querySelector('.underline');

        function activateTab(tab) {
            jobTab.classList.remove('active');
            contractTab.classList.remove('active');
            tab.classList.add('active');

            // Adjust the underline position and width
            underline.style.width = `${tab.offsetWidth}px`;
            underline.style.left = `${tab.offsetLeft}px`;

            // Change content dynamically based on active tab
            if (tab === jobTab) {
                content.innerHTML = '<div class="empty-message">There are no job posts available.</div>';
            } else if (tab === contractTab) {
                content.innerHTML = '<div class="empty-message">There are no contracts available.</div>';
            }
        }

        // Initialize the underline position
        window.onload = () => {
            activateTab(jobTab); // Set default tab as active
        };

        jobTab.addEventListener('click', () => activateTab(jobTab));
        contractTab.addEventListener('click', () => activateTab(contractTab));
    </script>



</body>

</html>