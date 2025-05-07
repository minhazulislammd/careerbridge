<?php
session_start();
include("connection.php");

// Initialize selected country variable
$selectedCountry = isset($_POST['country']) ? $_POST['country'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Sign up</title>
</head>
<body>
    <div class="page">
        <nav class="navbar">
            <div class="logo"><a href="landing_page.php">hustlUp</a></div>
        </nav>
        
        <form action="signup.php" method="post" novalidate>
            
            <main class="main_class">
                <div class="header_content">
                    <h1 class="header_content_heading">HustlUp your journey</h1>
                </div>

                <div class="login_box">
                    <div class="column">
                        <div class="input_box">
                            <label class="input_label">First name</label>
                            <input type="text" class="input_field" name="firstname" required/>
                        </div>
    
                        <div class="input_box">
                            <label class="input_label">Last name</label>
                            <input type="text" class="input_field" name="lastname" required/>
                        </div>
                    </div>

                    <div class="input_box">
                        <label class="input_label">Email</label>
                        <input type="email" class="input_field" name="email" required/>
                    </div>
                    
                    <div class="input_box">
                        <label class="input_label">Password</label>
                        <input type="password" class="input_field" name="password" placeholder="Password (8 or more characters)" required/>
                    </div>

                    <!-- Dynamic Country Dropdown -->
                    <div class="input_box">
                        <label class="input_label">Country</label>
                        <select id="country-dropdown" class="input_field" name="country" required>
                            <option value="">Select Country</option> <!-- Default option -->
                        </select>
                    </div>                    

                    <section>
                        <p>By clicking Agree & Join or Continue, you agree to the hustlUp <a href="" target="_blank">User Agreement</a>, <a href="" target="_blank">Privacy Policy</a>, and <a href="" target="_blank">Cookie Policy</a>.</p>
                    </section>

                    <div class="input_submit">    
                        <button id="submit" class="submit_btn" name="submit" type="submit" value="Agree & Join">Agree & Join</button>
                    </div>

                    <div class="sign_in_link">
                        <p>Already on CareerBridge? <a href="user_home_page.php">Sign in</a></p>
                    </div>
                </div>
                
            </main>
        </form>
    </div>

    <!-- JavaScript for Fetching Countries and Selected Role -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const countryDropdown = document.getElementById("country-dropdown");
            const selectedCountry = "<?php echo htmlspecialchars($selectedCountry, ENT_QUOTES, 'UTF-8'); ?>"; // Get selected country from PHP

            // Fetch country data using Fetch API
            fetch('https://restcountries.com/v3.1/all')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {

                    // Sort countries alphabetically
                    data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                    // Loop through country data and create option elements
                    data.forEach(country => {
                        const option = document.createElement("option");
                        option.value = country.name.common; // Country name as value
                        option.textContent = country.name.common; // Display country name
                        
                        // Check if this country was previously selected
                        if (country.name.common === selectedCountry) {
                            option.selected = true;
                        }

                        countryDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching countries:', error));

            // Get the selected role from sessionStorage
            const selectedRole = sessionStorage.getItem('selectedRole');
            
            // If a role is selected, create a hidden input field and append it to the form
            if (selectedRole) {
                const form = document.querySelector('form');
                const roleInput = document.createElement('input');
                roleInput.type = 'hidden';
                roleInput.name = 'role';
                roleInput.value = selectedRole;
                form.appendChild(roleInput);
            }
        });
    </script>

</body>
</html>
