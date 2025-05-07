<?php
    session_start();
    include("connection.php");

    if(!isset($_SESSION["email"])){
        header("Location: signin_page.php");
        exit();
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
    <link rel="stylesheet" href="client_profile.css">
    <title>Client Profile</title>
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
         
         <div class="profile-page">
            <!-- Sidebar Section -->
            <div class="profile-sidebar">
                <div class="profile-picture">
                    <img src="logo/user.png" alt="Profile Image">
                </div>
                <h2><?php echo ucfirst(htmlspecialchars($_SESSION['firstname'])). ' ' .htmlspecialchars($_SESSION['lastname']) ?></h2>
                <h5>UI/UX Designer</h5>
                <p>
                    Full stack product designer with hands-on experience in solving problems for clients ranging...
                </p>
                
                <div class="notes">
                    <h4>Add Notes</h4>
                    <textarea placeholder="Add notes for future reference"></textarea>
                    <button>Add Note</button>
                </div>
            </div>
            <!-- Main Content Section -->
            <div class="profile-main">
                <!-- Basic Info Section -->
                <div class="basic-info">
                    <div>
                        <h4>Basic Information</h4>
                        <p>First name: <strong><?php echo ucfirst(htmlspecialchars($_SESSION['firstname']))?></strong></p>
                        <p>Last name: <strong><?php echo ucfirst(htmlspecialchars($_SESSION['lastname']))?></strong></p>
                        <p>Email: <strong><?php echo htmlspecialchars($_SESSION['email'])?></strong></p>
                        <p>Country: <strong><?php echo htmlspecialchars($_SESSION['country'])?></strong></p>
                        <p>Age:<strong> </strong></p>
                        <p>Experience:<strong> </strong></p>
                        <p>Contact:<strong></strong></p>   
                    </div>
                    <div class="actions">
                        <button>Send Email</button>
                    </div>
                </div>
                
                <!-- Additional Info Section -->
                <div class="additional-info">
                    <div class="section" id="education">
                        <div class="section-header">
                            <h4>Education</h4>
                            <button class="dropdown-btn" onclick="toggleSection('education-content', this)">▼</button>
                        </div>
                        <div class="content" id="education-content">
                            <p>Bachelor of Design, UI/UX - XYZ University (2010-2014)</p>
                        </div>
                    </div>
                
                    <div class="section" id="accomplishments">
                        <div class="section-header">
                            <h4>Accomplishments</h4>
                            <button class="dropdown-btn" onclick="toggleSection('accomplishments-content', this)">▼</button>
                        </div>
                        <div class="content" id="accomplishments-content">
                            <p>Top 10 UX Designer in Design Magazine 2020</p>
                        </div>
                    </div>
                
                    <div class="section" id="certification">
                        <div class="section-header">
                            <h4>Certification</h4>
                            <button class="dropdown-btn" onclick="toggleSection('certification-content', this)">▼</button>
                        </div>
                        <div class="content" id="certification-content">
                            <p>Certified UX Professional by ABC Institute</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSection(sectionId, btn) {
        var content = document.getElementById(sectionId);
        
        // Toggle visibility of content
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            btn.innerHTML = "▲"; // Change to up arrow
        } else {
            content.style.display = "none";
            btn.innerHTML = "▼"; // Change to down arrow
        }
    }
    </script>

<script>
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

