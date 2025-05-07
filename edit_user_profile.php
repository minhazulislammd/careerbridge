<?php
session_start();
include("connection.php");

if (!isset($_SESSION["email"])) {
    header("Location: signin_page.php");
    exit();
}

// Retrieve the user_id from the session
$user_id = $_SESSION['user_id']; // Assuming you store the user_id in the session

// Fetch user profile data from seeker_information and users_information tables
$query = "SELECT si.*, ui.country 
          FROM seeker_information si 
          INNER JOIN users_information ui ON si.seeker_id = ui.user_id 
          WHERE si.seeker_id = $user_id"; // Ensure the user_id is appropriate here
$result = mysqli_query($conn, $query);

// If user data exists, store it in the session for display
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['profile_title'] = $row['profile_title'] ?? '';
    $_SESSION['contact'] = $row['contact'] ?? '';
    $_SESSION['age'] = $row['age'] ?? '';
    $_SESSION['address'] = $row['address'] ?? '';
    $_SESSION['city'] = $row['city'] ?? '';
    $_SESSION['country'] = $row['country'] ?? '';  // Get country from users_information
    $_SESSION['education'] = $row['education'] ?? '';
    $_SESSION['experience'] = $row['experience'] ?? '';
    $_SESSION['skills'] = $row['skills'] ?? '';
    $_SESSION['work_experience'] = $row['work_experience'] ?? '';
    $_SESSION['accomplishments'] = $row['accomplishments'] ?? '';
    $_SESSION['certification'] = $row['certification'] ?? '';
    $_SESSION['profile_description'] = $row['profile_description'] ?? '';
} else {
    // If no data exists, set default empty values
    $_SESSION['profile_title'] = '';
    $_SESSION['contact'] = '';
    $_SESSION['age'] = '';
    $_SESSION['address'] = '';
    $_SESSION['city'] = '';
    $_SESSION['country'] = '';  // Default empty country
    $_SESSION['education'] = '';
    $_SESSION['experience'] = '';
    $_SESSION['skills'] = '';
    $_SESSION['work_experience'] = '';
    $_SESSION['accomplishments'] = '';
    $_SESSION['certification'] = '';
    $_SESSION['profile_description'] = '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $profile_title = trim($_POST['profile_title']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $age = trim($_POST['age']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $education = trim($_POST['education']);
    $experience = trim($_POST['experience']);
    $skills = trim($_POST['skills']);
    $work_experience = trim($_POST['work_experience']);
    $accomplishments = trim($_POST['accomplishments']);
    $certification = trim($_POST['certification']);
    $profile_description = trim($_POST['profile_description']);

    // Check if all fields are filled
    if (empty($profile_title) || empty($first_name) || empty($last_name) || empty($email) || empty($contact) || empty($age) || empty($address) || empty($city) || empty($education) || empty($experience) || empty($skills) || empty($work_experience) || empty($accomplishments) || empty($certification) || empty($profile_description)) {
        echo "<script>alert('All fields should be filled up.');</script>";
    } else {
        // Check if the seeker information already exists for this user
        $query = "SELECT seeker_id FROM seeker_information WHERE seeker_id = $user_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Update the existing record
            $update_query = "UPDATE seeker_information SET 
                profile_title = '$profile_title',
                contact = '$contact',
                age = '$age',
                address = '$address',
                city = '$city',
                education = '$education',
                experience = '$experience',
                skills = '$skills',
                work_experience = '$work_experience',
                accomplishments = '$accomplishments',
                certification = '$certification',
                profile_description = '$profile_description'
            WHERE seeker_id = $user_id";

            if (mysqli_query($conn, $update_query)) {
                // Success message or redirection can be added here
            } else {
                echo "Error updating profile: " . mysqli_error($conn);
            }
        } else {
            // Insert a new record
            $insert_query = "INSERT INTO seeker_information (seeker_id, profile_title, contact, age, address, city, education, experience, skills, work_experience, accomplishments, certification, profile_description) 
            VALUES ($user_id, '$profile_title', '$contact', '$age', '$address', '$city', '$education', '$experience', '$skills', '$work_experience', '$accomplishments', '$certification', '$profile_description')";

            if (mysqli_query($conn, $insert_query)) {
                // Success message or redirection can be added here
            } else {
                echo "Error creating profile: " . mysqli_error($conn);
            }
        }
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
    <link rel="stylesheet" href="edit_user_profile.css">
    <title>Edit User Profile</title>
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
                        <h3>
                            <?php echo htmlspecialchars(ucfirst($_SESSION['firstname'])) . ' ' . htmlspecialchars(ucfirst($_SESSION['lastname'])); ?>
                        </h3>
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

        <form method="POST" action="edit_user_profile.php" onsubmit="return validateForm();"> 
            <div class="profile-edit-container">
                <div class="profile-header">
                    <img src="logo/user.png" class="profile-picture" alt="Profile Picture">
                    <button class="upload-btn" type="button">Upload new picture</button> <!-- Added type="button" to prevent form submission -->
                </div>

                <div class="profile-form">
                    <div class="form-group">
                        <label>Profile Title</label>
                        <input type="text" class="input_field" name="profile_title" placeholder="Enter profile title here" value="<?php echo isset($_SESSION['profile_title']) ? htmlspecialchars($_SESSION['profile_title']) : ''; ?>">
                    </div>

                    <div class="form-group two-column">
                        <div class="column">
                            <label>First Name</label>
                            <input type="text" class="input_field" name="first_name" placeholder="First Name" value="<?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname']) : ''; ?>">
                        </div>
                        <div class="column">
                            <label>Last Name</label>
                            <input type="text" class="input_field" name="last_name" placeholder="Last Name" value="<?php echo isset($_SESSION['lastname']) ? htmlspecialchars($_SESSION['lastname']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="input_field" name="email" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" class="input_field" name="contact" placeholder="Contact" value="<?php echo isset($_SESSION['contact']) ? htmlspecialchars($_SESSION['contact']) : ''; ?>">
                    </div>

                    <div class="form-group two-column">
                        <div class="column">
                            <label>Age</label>
                            <input type="number" class="input_field" name="age" placeholder="Age" value="<?php echo isset($_SESSION['age']) ? htmlspecialchars($_SESSION['age']) : ''; ?>">
                        </div>
                        <div class="column">
                            <label>Address</label>
                            <input type="text" class="input_field" name="address" placeholder="Address" value="<?php echo isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group two-column">
                        <div class="column">
                            <label>City</label>
                            <input type="text" class="input_field" name="city" placeholder="City" value="<?php echo isset($_SESSION['city']) ? htmlspecialchars($_SESSION['city']) : ''; ?>">
                        </div>
                        <div class="column">
                            <label>Country</label>
                            <input type="text" class="input_field" name="country" placeholder="Country" value="<?php echo isset($_SESSION['country']) ? htmlspecialchars($_SESSION['country']) : ''; ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Education</label>
                        <input type="text" class="input_field" name="education" placeholder="Education" value="<?php echo isset($_SESSION['education']) ? htmlspecialchars($_SESSION['education']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Experience</label>
                        <input type="text" class="input_field" name="experience" placeholder="Experience" value="<?php echo isset($_SESSION['experience']) ? htmlspecialchars($_SESSION['experience']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Skills</label>
                        <input type="text" class="input_field" name="skills" placeholder="Skills" value="<?php echo isset($_SESSION['skills']) ? htmlspecialchars($_SESSION['skills']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Work Experience</label>
                        <input type="text" class="input_field" name="work_experience" placeholder="Work Experience" value="<?php echo isset($_SESSION['work_experience']) ? htmlspecialchars($_SESSION['work_experience']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Accomplishments</label>
                        <input type="text" class="input_field" name="accomplishments" placeholder="Accomplishments" value="<?php echo isset($_SESSION['accomplishments']) ? htmlspecialchars($_SESSION['accomplishments']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Certification</label>
                        <input type="text" class="input_field" name="certification" placeholder="Certification" value="<?php echo isset($_SESSION['certification']) ? htmlspecialchars($_SESSION['certification']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Profile Description</label>
                        <textarea class="input_field" name="profile_description" rows="4" placeholder="Profile Description"><?php echo isset($_SESSION['profile_description']) ? htmlspecialchars($_SESSION['profile_description']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="save-btn">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Function to toggle user menu
        function toggleMenu() {
            const submenu = document.getElementById("subMenu");
            submenu.classList.toggle("open-menu");
        }

        // Form validation function
        function validateForm() {
            // Get the values of all input fields
            const profileTitle = document.querySelector('input[name="profile_title"]').value;
            const firstName = document.querySelector('input[name="first_name"]').value;
            const lastName = document.querySelector('input[name="last_name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const contact = document.querySelector('input[name="contact"]').value;
            const age = document.querySelector('input[name="age"]').value;
            const address = document.querySelector('input[name="address"]').value;
            const city = document.querySelector('input[name="city"]').value;
            const education = document.querySelector('input[name="education"]').value;
            const experience = document.querySelector('input[name="experience"]').value;
            const skills = document.querySelector('input[name="skills"]').value;
            const workExperience = document.querySelector('input[name="work_experience"]').value;
            const accomplishments = document.querySelector('input[name="accomplishments"]').value;
            const certification = document.querySelector('input[name="certification"]').value;
            const profileDescription = document.querySelector('textarea[name="profile_description"]').value;

            // Check if any field is empty
            if (!profileTitle || !firstName || !lastName || !email || !contact || !age || !address || !city || !education || !experience || !skills || !workExperience || !accomplishments || !certification || !profileDescription) {
                alert("All fields should be filled up.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>
