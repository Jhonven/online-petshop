<?php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Change this to your MySQL username
define('DB_PASS', '');      // Change this to your MySQL password
define('DB_NAME', 'petshop_db');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");
?>