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
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>HustlUp</title>
    <link rel="stylesheet" href="landing_page.css">

</head>

<body>
    <div class="page">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <div class="logo"><a href="landing_page.php">CareerBridge</a></div>
            <ul>
                <li class="dropdown">
                    <a href="landing_page.php">Home</a>
                  
                </li>
                <li class="dropdown1">
                    <a href="#">Discover</a>
                    <div class="dropdown-content1">
                        <a href="client_discover_for_landing.php">Discover</a>
                        
                    </div>
                </li>
                <li><a href="#">About</a></li>
            </ul>
          
            <div class="search-bar">
                <input type="text" placeholder="Search by company name">
                <span>🔍</span>
            </div>

            <div class="login">
                <a href="signin_page.php">Log in</a>
            </div>

            <div class="signUp">
                <a href="clientOrSeeker.php">Sign up</a>
            </div>
        </nav>

        <div class="container">
            <section id="hero">
                <div class="hero-content">
                    <h1>Bridging Learning to Earning</h1>
                    <p>Join CareerBridge for instant and quick job placements.</p>
                    <a href="clientOrSeeker.php" class="start_button">Get Started</a>
                </div>
            </section>
	<!-- feature start -->
    <section class="feature c_padd" id="feature">
      <div class="container">
        <div class="row">
          <!-- item start -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="s_feature">
              <div class="s_img">
                <img src="logo/book1.jpg" class="img-fluid" alt="E-school">
              </div>
              <h2 class="f_h2 mb-0">1500+ Topic</h2>
              <p class="f_p mb-0">Learn Anythings</p>
            </div>
          </div>
          <!-- item end -->
          <!-- item start -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="s_feature">
              <div class="s_img">
                <img src="logo/certificate.jpg" class="img-fluid" alt="E-school">
              </div>
              <h2 class="f_h2 mb-0">1800+ Students</h2>
              <p class="f_p mb-0">Learn Anythings</p>
            </div>
          </div>
          <!-- item end -->
          <!-- item start -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="s_feature">
              <div class="s_img">
                <img src="logo/latter.jpg" class="img-fluid" alt="E-school">
              </div>
              <h2 class="f_h2 mb-0">9K+ Test Token</h2>
              <p class="f_p mb-0">Learn Anythings</p>
            </div>
          </div>
          <!-- item end -->
          <!-- item start -->
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="s_feature">
              <div class="s_img">
                <img src="logo/book2.jpg" class="img-fluid" alt="E-school">
              </div>
              <h2 class="f_h2 mb-0">2000+ Student</h2>
              <p class="f_p mb-0">Learn Anythings</p>
            </div>
          </div>
          <!-- item end -->
        </div>
      </div>
    </section>
    <!-- feature end -->
	
          
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