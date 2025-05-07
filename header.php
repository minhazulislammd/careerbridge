<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navigation Bar */
        .nav-wrapper {
            background-color: #f0e9e0; /* Materialize's blue */
            padding: 10px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        /* Navigation Links */
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        ul li {
            margin-left: 20px;
        }

        ul li a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }

        /* Hide on small screens */
        @media screen and (max-width: 670px) {
            header {
                min-height: 500px;
            }

            ul {
                display: none;
            }
        }

    </style>
</head>
<body>
    <nav class="nav-wrapper">
        <div class="container">
            <img src="logo/logo.png" class="logo" alt="logo">
            <a href="#" class="brand-logo">JOB360</a>
        
            <ul class="right">
                <li><a href="#">Find jobs</a></li>
                <li><a href="#">Find talent</a></li>
                <li><a href="#">Why JOB360</a></li>
            </ul>
        </div>
    </nav>

