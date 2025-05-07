<?php
session_start();
include("connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <title>HustlUp</title>
    <link rel="stylesheet" href="landing_page.css">
    <style>
        .container1 {
 display: grid;
  
 grid-template-columns: 1fr 1fr;
 column-gap: 10px;
 
}

img {
  max-width: 100%;
  max-height:100%;
  margin-left: 150px;
  border-radius:25px;
  width:540px ;
  height:300px;

}

.text {
  font-size: 30px;
  
  margin-left: 30px;
}
.text1 {
  font-size: 30px;
  margin-left:200px;
  
}
   </style>

</head>

<body>
    <div class="page">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo"><a href="landing_page.php">CareerBridge</a></div>
            <ul>
                <li class="dropdown">
                    <a href="#">Find Talent</a>
                    <div class="dropdown-content">
                        <a href="client_discover_for_landing.php">Discover</a>
                        <a href="client_hires_for_landing.php">Your hires</a>
                        <a href="client_saved_talent_for_landing.php">Saved talent</a>
                    </div>
                </li>
                <li class="dropdown1">
                    <a href="#">Find task</a>
                    <div class="dropdown-content1">
                        <a href="clientOrSeeker.php">Your Dashboard</a>
                        <a href="applied_tasks_for_landing.php">Applied tasks</a>
                        <a href="saved_jobs_for_landing.php">Saved tasks</a>
                    </div>
                </li>
                <li><a href="#">Why HustlUp</a></li>
            </ul>
          
            <div class="search-bar">
                <input type="text" placeholder="Search by contract, freelancer, or agency name">
                <span>🔍</span>
            </div>

            <div class="login">
                <a href="signin_page.php">Log in</a>
            </div>

            <div class="signUp">
                <a href="clientOrSeeker.php">Sign up</a>
            </div>
        </nav>

        <div class="container" >
        

        <section id="hero">
                <div class="hero-content">
                    <h1>Join Job from Applied Tasks</h1>
                    
                    
                </div>
            </section>

            
        
            <section>
            <div class="container1">
      <div class="image">
        <img src="logo/job9.png" style="margin-bottom: 30px;">
      </div>
      <div class="text">
        <h1>See how many task you have applied</h1>
        <h5 style="color: #566573;">See if your application is under review, shortlisted, or requires more information.</h5>
      </div>
    </div>
            </section>

            <section>
            <div class="container1">
            <div class="text1" font>
        <h1 >Find out your most suitable Job from applied jobs </h1>
        <h5 style="color: #566573;">Keep track of your career moves and stay organized. Your next opportunity is just a step away!</h5>
      </div>
      <div class="image1">
        <img src="logo/job10.png" style="border-radius: 25px; margin-left:70px;">
      </div>
      
    </div>
            </section>

            <section id="hero">
                <div class="hero-content">
                    <h1>See the Applied Tasks</h1>
                    <a href="clientOrSeeker.php" class="start_button">Applied Tasks</a>
                </div>
            </section>
        </div>
    </div>


    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function filterFunction() {
            const input = document.getElementById("myInput");
            const filter = input.value.toUpperCase();
            const div = document.getElementById("myDropdown");
            const a = div.getElementsByTagName("a");
            for (let i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
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