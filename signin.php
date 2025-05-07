<?php
session_start();
include("connection.php");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Query to fetch the user by email
        $sql = "SELECT * FROM users_information WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        // Redirect to home page based on role
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify password (assuming password is hashed)
            if (password_verify($password, $user['password'])) {
                // Store user data in session variables
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['firstname'] = $user['firstname']; 
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION["country"] = $user['country'];
                $_SESSION["role"] = $user['role']; // Store role in session

                // Redirect based on the role
                if ($user['role'] === 'client') {
                    header("Location: client_home_page.php");
                } elseif ($user['role'] === 'seeker') {
                    header("Location: user_home_page.php");
                } else {
                    // Default redirection if role is unknown
                    header("Location: user_home_page.php");
                }
                exit();
            } else {
                echo "<script>alert('Invalid email or password'); window.location.href = 'signin_page.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password'); window.location.href = 'signin_page.php';</script>";
        }
    } else {
        echo "No POST data received.";
    }
}

// Close the connection
mysqli_close($conn);
?>
