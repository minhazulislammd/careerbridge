<?php
include("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $firstname = mysqli_real_escape_string($conn, filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lastname = mysqli_real_escape_string($conn, filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = mysqli_real_escape_string($conn, filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $country = mysqli_real_escape_string($conn, filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $role = mysqli_real_escape_string($conn, filter_var($_POST['role'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));  // New

    // Validate email
    if ($email === false) {
        echo "Invalid email address";
        exit();
    }

    // Check if the email already exists
    $sql = "SELECT * FROM users_information WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $count_email = mysqli_num_rows($result);

    if ($count_email == 0) {
        // Insert new data with role
        if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($country) && !empty($role)) {
            // Hash the password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user information with role
            $sql = "INSERT INTO users_information (firstname, lastname, email, password, country, role) 
                    VALUES ('$firstname', '$lastname', '$email', '$hash', '$country', '$role')";

            if (mysqli_query($conn, $sql)) {
                // Get the inserted user's ID
                $users_id = mysqli_insert_id($conn);

                // Store user data in session
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['role'] = $role;

                // Insert into the respective table based on role
                if ($role === 'client') {
                    $client_sql = "INSERT INTO client_information (client_id) VALUES ('$users_id')";
                    if (!mysqli_query($conn, $client_sql)) {
                        echo "Error inserting data into client_information: " . mysqli_error($conn);
                        exit();
                    }
                    // Redirect to client home page
                    header('Location: client_home_page.php');
                } elseif ($role === 'seeker') {
                    $seeker_sql = "INSERT INTO seeker_information (seeker_id) VALUES ('$users_id')";
                    if (!mysqli_query($conn, $seeker_sql)) {
                        echo "Error inserting data into seeker_information: " . mysqli_error($conn);
                        exit();
                    }
                    // Redirect to seeker home page
                    header('Location: user_home_page.php');
                } else {
                    // Default redirection if role is unknown
                    header('Location: user_home_page.php');
                }
                exit();
            } else {
                echo "Error inserting data: " . mysqli_error($conn);
            }
        } else {
            echo "Please fill in all required fields.";
        }
    } else {
        echo "An account with this email already exists.";
    }

    // Close connection
    mysqli_close($conn);
}
