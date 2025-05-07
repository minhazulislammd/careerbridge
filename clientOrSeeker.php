<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="clientOrSeeker.css">
    <title>Client or Job Seeker</title>
</head>
<body>
<nav class="navbar">

    <div class="logo"><a href="landing_page.php">CareerBridge</a></div>
        
    </nav>
    <div class="page">
        <div class="header_content">
            <h1 class="header_content_heading">Join as a company or a job-seeker</h1>
        </div>

        <div class="box_container">
            <div class="container">
                <div class="box" id="client_box">
                    <p>Company</p>
                    <input type="radio" class="radio" id="client" name="select">
                </div>

                <div class="box" id="job_seeker_box">
                    <p>I'm a job seeker, looking for work</p>
                    <input type="radio" class="radio" id="job_seeker" name="select">
                </div>
            </div>
        </div>

        <div class="submit_container">
            <button type="button" id="submit_btn" class="submit_btn disabled" disabled>Create Account</button>
            <section>
                <p>Already have an account? <a href="signin_page.php">Sign in</a></p>
            </section>
        </div>
    </div>

    <script src="clientOrSeeker.js"></script>
</body>
</html>
