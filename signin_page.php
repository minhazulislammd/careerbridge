<?php
session_start();
include("connection.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    <link rel="stylesheet" href="signin_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Sign in</title>
</head>
<body class="login">
    <nav class="navbar">
        <div class="logo"><a href="landing_page.php">hustlUp</a></div>
    </nav>
    <div class="page">
        <main class="main_class">
            <div class="header_content">
                <h1 class="header_content_heading">Sign in</h1>
            </div>
            
            <form action="signin.php" method="post" id="form" novalidate>
                <div class="login_box">
                    <div class="input_box">
                        <label class="input_label" for="email">Email</label>
                        <input type="email" class="input_field" id="email" name="email" required>
                        <small>Error message</small>
                    </div>

                    <div class="input_box">
                        <label class="input_label" for="password">Password</label>
                        <input type="password" class="input_field" id="password" name="password" required>
                        <small>Error message</small>
                    </div>

                    <div class="forget_password">
                        <a href="#">Forget password?</a>
                    </div>

                    <div class="input_submit">
                        <button type="submit" id="submitBtn" class="submit_btn" name="submit" value="submit">Sign in</button>
                    </div>

                    <div class="sign_up_link">
                        <p class="p">Don't have an account? <a href="clientOrSeeker.php">Sign up</a></p>
                    </div>
                </div>
            </form>
        </main>
    </div>
    


</body>
</html>

<?php
mysqli_close($conn);
?>


<!--- <div class="third_party_join_container">
                            <div class="third_party_join_reg_option">
                                <span class="third_party_join_line_wrapper">
                                    <span class="third_party_join_line"></span>                                    
                                </span>
                                <span class="third_party_join_content">
                                    <span class="third_party_join_or_span">or</span>
                                </span>
                            </div>
                        </div> 

                        <div class="icons"> 
                            <i class="fab fa-google"></i>
                            <i class="fab fa-facebook"></i>
                        </div> -->