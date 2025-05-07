<?php
$servername = "localhost";
$username = "root";
$password_ = "";
$db_name = "job";

$conn = new mysqli($servername,$username,$password_,$db_name, 3306);

    if($conn -> connect_error){
        die("Failed to connect" . $conn -> connect_error); 
    }
?>
